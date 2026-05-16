<?php
session_start();
include "conexao.php";

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["tipo_utilizador"] != "admin") {
    header("Location: index.php");
    exit();
}

$nome_admin = $_SESSION["nome"] ?? "Admin";

if (isset($_GET["eliminar"])) {
    $id = $_GET["eliminar"];

    $sql = "DELETE FROM contactos WHERE id_contacto = $id";

    mysqli_query($conn, $sql);

    header("Location: dashboard_contactos.php");
    exit();
}

$sql = "SELECT * FROM contactos ORDER BY id_contacto DESC";
$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Backoffice - Contactos</title>

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
                    <h1>Contactos</h1>
                    <p>Mensagens enviadas pelo formulário de contacto</p>
                </div>

                <span>Admin: <?php echo $nome_admin; ?></span>

            </div>

            <section class="table-card">

                <table>

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Mensagem</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php while ($contacto = mysqli_fetch_assoc($resultado)) { ?>

                            <tr>

                                <td>
                                    <?php echo $contacto["id_contacto"]; ?>
                                </td>

                                <td>
                                    <?php echo $contacto["nome"]; ?>
                                </td>

                                <td>
                                    <?php echo $contacto["email"]; ?>
                                </td>

                                <td style="max-width: 500px;">
                                    <?php echo nl2br($contacto["mensagem"]); ?>
                                </td>
                                <td class="actions">

                                    <a href="ver_contacto.php?id=<?php echo $contacto["id_contacto"]; ?>" class="btn view">
                                        Ver
                                    </a>

                                    <a href="dashboard_contactos.php?eliminar=<?php echo $contacto["id_contacto"]; ?>"
                                        class="btn delete"
                                        onclick="return confirm('Tens a certeza que queres eliminar esta mensagem?');">
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