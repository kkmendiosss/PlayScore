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
    header("Location: dashboard_jogos.php");
    exit();
}

$id = intval($_GET["id"]);

/* 🔥 JOGO */
$stmt = $conn->prepare("SELECT * FROM jogos WHERE id_jogo = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

$jogo = $result->fetch_assoc();

if (!$jogo) {
    header("Location: dashboard_jogos.php");
    exit();
}

/* 🎮 GÉNEROS */
$generos = [];

$stmt_gen = $conn->prepare("
    SELECT g.nome
    FROM generos g
    INNER JOIN jogo_genero jg ON g.id_genero = jg.id_genero
    WHERE jg.id_jogo = ?
");

$stmt_gen->bind_param("i", $id);
$stmt_gen->execute();

$res_gen = $stmt_gen->get_result();

while ($row = $res_gen->fetch_assoc()) {
    $generos[] = $row["nome"];
}

/* 🎮 PLATAFORMAS */
$plataformas = !empty($jogo["plataforma"])
    ? explode(", ", $jogo["plataforma"])
    : [];
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Ver Jogo</title>
    <link rel="stylesheet" href="css/backoffice.css">
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

    <div class="ver-jogo">

    <h1><?= htmlspecialchars($jogo["titulo"]) ?></h1>

    <div class="ver-jogo-layout">

        <div class="left">

            <img src="<?= $jogo["capa_url"] ?>">

            <p><strong>Desenvolvedor:</strong> <?= $jogo["desenvolvedor"] ?></p>
            <p><strong>Editor:</strong> <?= $jogo["editor"] ?></p>
            <p><strong>Data:</strong> <?= $jogo["data_lancamento"] ?></p>

        </div>

        <div class="right">

            <p><strong>Descrição:</strong><br>
                <?= nl2br($jogo["descricao"]) ?>
            </p>

            <p><strong>Géneros:</strong></p>
            <div class="tags">
                <?php foreach ($generos as $g) { ?>
                    <span class="tag"><?= htmlspecialchars($g) ?></span>
                <?php } ?>
            </div>

            <p><strong>Plataformas:</strong></p>
            <div class="tags">
                <?php foreach ($plataformas as $p) { ?>
                    <span class="tag"><?= htmlspecialchars($p) ?></span>
                <?php } ?>
            </div>

            <p>
                <strong>Trailer:</strong><br>
                <a href="<?= $jogo["trailer_url"] ?>" target="_blank">Ver Trailer</a>
            </p>

        </div>

    </div>

</div>

</div>

</body>
</html>