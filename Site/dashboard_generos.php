<?php
session_start();
include "conexao.php";

if (!isset($_SESSION["id"]) || $_SESSION["tipo_utilizador"] != "admin") {
    header("Location: login.php");
    exit();
}

$nome_admin = $_SESSION["nome"] ?? "Admin";

if (isset($_GET["eliminar"])) {
    $id = mysqli_real_escape_string($conn, $_GET["eliminar"]);
    $sql_delete = "DELETE FROM generos WHERE id_genero = '$id'";
    
    if (mysqli_query($conn, $sql_delete)) {
        header("Location: dashboard_generos.php");
        exit();
    }
}

$por_pagina = 10;
$pagina = $_GET["pagina"] ?? 1;
$pagina = max(1, intval($pagina));

$inicio = ($pagina - 1) * $por_pagina;

$sql_total = "SELECT COUNT(*) AS total FROM generos";
$resultado_total = mysqli_query($conn, $sql_total);
$total_linhas = mysqli_fetch_assoc($resultado_total)["total"];

$total_paginas = ceil($total_linhas / $por_pagina);

$sql = "SELECT * FROM generos ORDER BY id_genero ASC LIMIT $inicio, $por_pagina";
$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Backoffice - Géneros</title>
    <link rel="stylesheet" href="css/backoffice.css">
    <link href="https://fonts.googleapis.com/css2?family=Kode+Mono&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
</head>

<body>

    <div class="backoffice">

        <aside class="sidebar">

            <div class="sidebar-logo">
                <img src="logo/Logo.png" alt="PlayScore">
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

            <a href="index.php" class="back-site">Voltar ao site</a>

        </aside>

        <main class="main-content">

            <div class="topbar">
                <div>
                    <h1>Géneros</h1>
                    <p>Gestão dos géneros registados</p>
                </div>

                <div class="topbar-actions">
                    <a href="dashboard_adicionar_generos.php" class="add-btn">
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
                            <th>Nome</th>
                            <th class="actions-title">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($genero = mysqli_fetch_assoc($resultado)) { ?>
                            <tr>
                                <td><?php echo $genero["id_genero"]; ?></td>
                                <td><?php echo $genero["nome"]; ?></td>
                                <td class="actions">
                                    
                                    <a href="dashboard_editar_generos.php?id=<?php echo $genero["id_genero"]; ?>" class="btn edit">
                                        Editar
                                    </a>

                                    <a href="dashboard_generos.php?eliminar=<?php echo $genero["id_genero"]; ?>" 
                                       class="btn delete" 
                                       onclick="return confirm('Tens a certeza que queres eliminar este género?');">
                                        Eliminar
                                    </a>

                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <div class="pagination">

                    <?php if ($pagina > 1) { ?>
                        <a href="dashboard_generos.php?pagina=<?php echo $pagina - 1; ?>">
                            Anterior
                        </a>
                    <?php } ?>

                    <?php for ($i = 1; $i <= $total_paginas; $i++) { ?>
                        <a href="dashboard_generos.php?pagina=<?php echo $i; ?>"
                            class="<?php echo ($i == $pagina) ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php } ?>

                    <?php if ($pagina < $total_paginas) { ?>
                        <a href="dashboard_generos.php?pagina=<?php echo $pagina + 1; ?>">
                            Próxima
                        </a>
                    <?php } ?>

                </div>

            </section>

        </main>

    </div>

</body>

</html>