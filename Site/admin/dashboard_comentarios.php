<?php
session_start();
include "../conexao.php";

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["tipo_utilizador"] != "admin") {
    header("Location: index.php");
    exit();
}

$nome_admin = $_SESSION["nome"] ?? "Admin";


// ELIMINAR comentário
if (isset($_GET["eliminar"])) {
    $id = $_GET["eliminar"];

    $sql = "DELETE FROM comentarios WHERE id_comentario = $id";
    mysqli_query($conn, $sql);

    header("Location: dashboard_comentarios.php");
    exit();
}


// LISTAR comentários (com nome do user e jogo)
$sql = "SELECT c.id_comentario, c.comentario,c.data_comentario, u.nome AS nome_utilizador,j.titulo AS titulo_jogo
    FROM comentarios c
    JOIN users u ON c.id_utilizador = u.id_utilizador
    JOIN jogos j ON c.id_jogo = j.id_jogo
    ORDER BY c.id_comentario DESC
";

$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Backoffice - Comentários</title>

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
                <h1>Comentários</h1>
                <p>Gestão dos comentários dos utilizadores</p>
            </div>

            <span>Admin: <?php echo $nome_admin; ?></span>
        </div>

        <section class="table-card">

            <table>

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Utilizador</th>
                        <th>Jogo</th>
                        <th>Comentário</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>

                <?php while ($comentario = mysqli_fetch_assoc($resultado)) { ?>

                    <tr>

                        <td><?php echo $comentario["id_comentario"]; ?></td>

                        <td><?php echo $comentario["nome_utilizador"]; ?></td>

                        <td><?php echo $comentario["titulo_jogo"]; ?></td>

                        <td><?php echo $comentario["comentario"]; ?></td>

                        <td>
                            <?php echo date("d/m/Y H:i", strtotime($comentario["data_comentario"])); ?>
                        </td>

                        <td class="actions">

                            <a href="dashboard_comentarios.php?eliminar=<?php echo $comentario["id_comentario"]; ?>"
                               class="btn delete"
                               onclick="return confirm('Tens a certeza que queres eliminar este comentário?');">
                                Eliminar
                            </a>

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </section>

    </main>

</div>

</body>
</html>