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

if (!isset($_GET["id"])) {
    header("Location: dashboard_users.php");
    exit();
}

$id = $_GET["id"];

$sql = "SELECT * FROM users WHERE id_utilizador = $id";
$resultado = mysqli_query($conn, $sql);

$user = mysqli_fetch_assoc($resultado);

if (!$user) {
    header("Location: dashboard_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Ver User</title>

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
                    <h1>Ver User</h1>
                    <p>Informações do utilizador</p>
                </div>
            </div>

            <section class="table-card view-card">

                <div class="view-header">

                    <?php if (!empty($user["avatar_url"])) { ?>

                        <img src="<?php echo $user["avatar_url"]; ?>"
                            class="view-avatar">

                    <?php } else { ?>

                        <div class="view-placeholder">
                            ?
                        </div>

                    <?php } ?>

                    <div>

                        <h2>
                            <?php echo $user["nome"]; ?>
                        </h2>

                        <p>
                            <?php echo $user["email"]; ?>
                        </p>

                    </div>

                </div>

                <div class="view-info">

                    <div class="info-box">
                        <span>ID</span>
                        <strong><?php echo $user["id_utilizador"]; ?></strong>
                    </div>

                    <div class="info-box">
                        <span>Tipo</span>
                        <strong><?php echo $user["tipo_utilizador"]; ?></strong>
                    </div>

                    <div class="info-box">
                        <span>Data Registo</span>
                        <strong>
                            <?php echo date("d/m/Y", strtotime($user["data_registo"])); ?>
                        </strong>
                    </div>

                </div>

                <div class="view-buttons">

                    <a href="dashboard_editar_user.php?id=<?php echo $user["id_utilizador"]; ?>"
                        class="btn edit">
                        Editar
                    </a>

                    <a href="dashboard_users.php"
                        class="btn view">
                        Voltar
                    </a>

                </div>

            </section>

        </main>

    </div>

</body>

</html>