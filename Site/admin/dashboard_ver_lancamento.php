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

if (!isset($_GET["id"])) {
    header("Location: dashboard_lancamento.php");
    exit();
}

$id = (int) $_GET["id"];

$sql = "SELECT * FROM lancamentos WHERE id_lancamento = $id";
$resultado = mysqli_query($conn, $sql);

$lancamento = mysqli_fetch_assoc($resultado);

if (!$lancamento) {
    header("Location: dashboard_lancamento.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Ver Lançamento</title>

    <link rel="stylesheet" href="../css/backoffice.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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
                    <h1>Ver Lançamento</h1>
                    <p>Informações do lançamento</p>
                </div>
            </div>

            <section class="table-card view-card">

                <div class="view-header">

                    <div class="view-placeholder">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>

                    <div>
                        <h2><?php echo htmlspecialchars($lancamento["nome"]); ?></h2>
                        <p><?php echo htmlspecialchars($lancamento["plataformas"]); ?></p>
                    </div>

                </div>

                <div class="view-info">

                    <div class="info-box">
                        <span>ID</span>
                        <strong><?php echo $lancamento["id_lancamento"]; ?></strong>
                    </div>

                    <div class="info-box">
                        <span>Data</span>
                        <strong>
                            <?php echo date("d/m/Y", strtotime($lancamento["data"])); ?>
                        </strong>
                    </div>

                    <div class="info-box">
                        <span>Plataformas</span>
                        <strong><?php echo htmlspecialchars($lancamento["plataformas"]); ?></strong>
                    </div>

                </div>

                <div class="view-buttons">

                    <a href="dashboard_editar_lancamento.php?id=<?php echo $lancamento["id_lancamento"]; ?>"
                        class="btn edit">
                        <i class="fa-solid fa-pen"></i>
                    </a>

                    <a href="dashboard_lancamento.php"
                        class="btn view">
                        Voltar
                    </a>

                </div>

            </section>

        </main>

    </div>

</body>

</html>