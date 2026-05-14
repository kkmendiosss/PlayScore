<?php
session_start();
include "conexao.php";

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$tipo = strtolower(trim($_SESSION["tipo_utilizador"] ?? ""));

if ($tipo != "admin") {
    header("Location: index.php");
    exit();
}

$nome = $_SESSION["nome"] ?? "Admin";
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | PlayScore</title>

    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/backoffice.css">

    <link href="https://fonts.googleapis.com/css2?family=Kode+Mono&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">

    <link rel="icon" href="img/PlayScore_Icon.png">
</head>

<body>

    <div class="dashboard-layout">

        <aside class="sidebar">

            <div class="sidebar-logo">
                <img src="logo/Logo.png" alt="PlayScore">
            </div>

            <h2>Dashboard</h2>

            <nav class="sidebar-menu">
                <a href="dashboard.php?page=favoritos">Favoritos</a>
                <a href="dashboard.php?page=generos">Géneros</a>
                <a href="dashboard.php?page=contactos">Contactos</a>
                <a href="dashboard.php?page=franquias">Franquias</a>
                <a href="dashboard.php?page=jogos">Jogos</a>
                <a href="dashboard.php?page=jogo_do_ano">Jogo do Ano</a>
                <a href="dashboard.php?page=lancamentos">Lançamentos</a>
                <a href="dashboard_users.php">Users</a>
            </nav>

            <a href="index.php" class="back-site">Voltar ao site</a>

        </aside>

        <main class="dashboard-main">

            <header class="dashboard-header">
                <h1>Painel de Administração</h1>
                <p>Bem-vindo, <?php echo $nome; ?></p>
            </header>

            <section class="dashboard-content">

                <?php
                $page = $_GET["page"] ?? "home";

                if ($page == "favoritos") {
                    echo "<h2>Favoritos</h2>";
                    echo "<p>Gestão da tabela favoritos.</p>";
                } elseif ($page == "generos") {
                    echo "<h2>Géneros</h2>";
                    echo "<p>Gestão da tabela generos.</p>";
                } elseif ($page == "contactos") {
                    echo "<h2>Contactos</h2>";
                    echo "<p>Gestão da tabela contactos.</p>";
                } elseif ($page == "franquias") {
                    echo "<h2>Franquias</h2>";
                    echo "<p>Gestão da tabela franquias.</p>";
                } elseif ($page == "jogos") {
                    echo "<h2>Jogos</h2>";
                    echo "<p>Gestão da tabela jogos.</p>";
                } elseif ($page == "jogo_do_ano") {
                    echo "<h2>Jogo do Ano</h2>";
                    echo "<p>Gestão da tabela jogo_do_ano.</p>";
                } elseif ($page == "lancamentos") {
                    echo "<h2>Lançamentos</h2>";
                    echo "<p>Gestão da tabela lancamentos.</p>";
                } elseif ($page == "users") {
                    echo "<h2>Users</h2>";
                    echo "<p>Gestão da tabela users.</p>";
                } else {
                    echo "<h2>Resumo</h2>";
                    echo "<p>Escolhe uma secção na sidebar para começar.</p>";
                }
                ?>

            </section>

        </main>

    </div>

</body>

</html>