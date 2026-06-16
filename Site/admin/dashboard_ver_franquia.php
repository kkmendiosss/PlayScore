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
    header("Location: dashboard_franquia.php");
    exit();
}

$id = (int) $_GET["id"];

$sql = "SELECT * FROM franquias WHERE id_franquia = $id";
$resultado = mysqli_query($conn, $sql);

$franquia = mysqli_fetch_assoc($resultado);

if (!$franquia) {
    header("Location: dashboard_franquia.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Ver Franquia</title>

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
                    <h1>Ver Franquia</h1>
                    <p>Informações da franquia</p>
                </div>
            </div>

            <section class="table-card view-card">

                <div class="view-header">

                    <?php if (!empty($franquia["capa_url"])) { ?>

                        <img src="<?php echo $franquia["capa_url"]; ?>"
                            class="view-avatar">

                    <?php } else { ?>

                        <div class="view-placeholder">
                            <i class="fa-solid fa-gamepad"></i>
                        </div>

                    <?php } ?>

                    <div>

                        <h2>
                            <?php echo htmlspecialchars($franquia["nome"]); ?>
                        </h2>

                        <p>
                            Franquia de Jogos
                        </p>

                    </div>

                </div>

                <div class="view-info">

                    <div class="info-box">
                        <span>ID</span>
                        <strong><?php echo $franquia["id_franquia"]; ?></strong>
                    </div>

                    <div class="info-box">
                        <span>Nome</span>
                        <strong><?php echo htmlspecialchars($franquia["nome"]); ?></strong>
                    </div>

                    <div class="info-box">
                        <span>Descrição</span>
                        <strong><?php echo htmlspecialchars($franquia["descricao"]); ?></strong>
                    </div>

                </div>

                <div class="view-buttons">

                    <a href="dashboard_editar_franquia.php?id=<?php echo $franquia["id_franquia"]; ?>"
                        class="btn edit">
                        <i class="fa-solid fa-pen"></i>
                    </a>

                    <a href="dashboard_franquia.php"
                        class="btn view">
                        Voltar
                    </a>

                </div>

            </section>

        </main>

    </div>

</body>

</html>