<?php
session_start();
include "../conexao.php";

if (!isset($_SESSION["id"])) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION["tipo_utilizador"] != "admin") {
    header("Location: ../index.php");
    exit();
}

$nome_admin = $_SESSION["nome"] ?? "Admin";

$registosPorPagina = 10;

$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

if ($pagina < 1) {
    $pagina = 1;
}

$inicio = ($pagina - 1) * $registosPorPagina;

if (isset($_GET["eliminar"])) {
    $id = $_GET["eliminar"];

    $sql = "DELETE FROM jogos WHERE id_jogo = $id";

    mysqli_query($conn, $sql);

    header("Location: dashboard_jogos.php");
    exit();
}


$sql = "SELECT * FROM jogos
        ORDER BY id_jogo DESC
        LIMIT $inicio, $registosPorPagina";
$resultado = mysqli_query($conn, $sql);

$sqlTotal = "SELECT COUNT(*) AS total FROM jogos";
$resultadoTotal = mysqli_query($conn, $sqlTotal);

$total = mysqli_fetch_assoc($resultadoTotal)['total'];

$totalPaginas = ceil($total / $registosPorPagina);

?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Backoffice - Jogos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../css/backoffice.css">
    <link href="https://fonts.googleapis.com/css2?family=Kode+Mono&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
</head>

<body>

    <div class="backoffice">

        <aside class="sidebar">

            <div class="sidebar-logo">
                <img src="../logo/Logo.png" alt="PlayScore">
            </div>

            <h2>Dashboard</h2>

            <a href="dashboard.php">Dashboard</a>

            <nav class="sidebar-menu">
                <a href="dashboard_favoritos.php">Favoritos</a>
                <a href="dashboard_generos.php">Géneros</a>
                <a href="dashboard_contactos.php">Contactos</a>
                <a href="dashboard_franquia.php">Franquias</a>
                <a href="dashboard_jogos.php">Jogos</a>
                <a href="dashboard_jogoano.php">Jogo do Ano</a>
                <a href="dashboard_lancamento.php">Lançamentos</a>
                <a href="dashboard_comentarios.php">Comentários</a>
                <a href="dashboard_users.php">Users</a>
            </nav>

            <a href="../index.php" class="back-site">Voltar ao site</a>

        </aside>

        <main class="main-content">

            <div class="topbar">
                <div>
                    <h1>Jogos</h1>
                    <p>Gestão dos jogos registados</p>
                </div>
                
                 <div class="topbar-actions">
                <a href="dashboard_adicionar_jogos.php" class="add-btn">
                    + Adicionar
                </a>

                <span>Admin: <?php echo $nome_admin; ?></span>
            </div>
            </div>

            <section class="table-card">

                <table>

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Capa</th>
                            <th>Título</th>
                            <th>Plataforma</th>
                            <th>Classificação</th>
                            <th>Data Lançamento</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php while ($jogo = mysqli_fetch_assoc($resultado)) { ?>

                            <tr>

                                <td><?php echo $jogo["id_jogo"]; ?></td>

                                <td>
                                    <?php if (!empty($jogo["capa_url"])) { ?>

                                        <img src="<?php echo $jogo["capa_url"]; ?>" class="table-avatar-jogo">

                                    <?php } else { ?>

                                        <div class="avatar-placeholder">?</div>

                                    <?php } ?>
                                </td>

                                <td><?php echo $jogo["titulo"]; ?></td>

                                <td><?php echo $jogo["plataforma"]; ?></td>

                                <td><?php echo $jogo["classificacao"]; ?></td>

                                <td>
                                    <?php
                                    if (!empty($jogo["data_lancamento"])) {
                                        echo date("d/m/Y", strtotime($jogo["data_lancamento"]));
                                    } else {
                                        echo "-";
                                    }
                                    ?>
                                </td>
                            
                                <td class="actions">

                                    <a href="dashboard_ver_jogos.php?id=<?php echo $jogo["id_jogo"]; ?>"
                                        class="btn view">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    <a href="dashboard_editar_jogos.php?id=<?php echo $jogo["id_jogo"]; ?>"
                                        class="btn edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    <a href="dashboard_jogos.php?eliminar=<?php echo $jogo["id_jogo"]; ?>"
                                        class="btn delete"
                                        onclick="return confirm('Tens a certeza que queres eliminar este jogo?');">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>

                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

                <div class="pagination">

                    <?php if($pagina > 1){ ?>
                        <a href="?pagina=<?= $pagina-1 ?>">Anterior</a>
                    <?php } ?>

                <?php for($i = 1; $i <= $totalPaginas; $i++){ ?>

                    <?php if($i == $pagina){ ?>
                        <span class="ativa"><?= $i ?></span>
                    <?php } else { ?>
                        <a href="?pagina=<?= $i ?>"><?= $i ?></a>
                    <?php } ?>

                <?php } ?>

                    <?php if($pagina < $totalPaginas){ ?>
                        <a href="?pagina=<?= $pagina+1 ?>">Seguinte</a>
                    <?php } ?>

                </div>

            </section>

        </main>

    </div>

</body>

</html>