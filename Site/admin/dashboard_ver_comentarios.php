<?php
session_start();
include "../conexao.php";

if (!isset($_SESSION["id"]) || $_SESSION["tipo_utilizador"] != "admin") {
    header("Location: login.php");
    exit();
}

$id = (int)$_GET["id"];

$sql = "
SELECT c.*, u.nome AS nome_utilizador, j.titulo AS titulo_jogo
FROM comentarios c
JOIN users u ON c.id_utilizador = u.id_utilizador
JOIN jogos j ON c.id_jogo = j.id_jogo
WHERE c.id_comentario = $id
";

$resultado = mysqli_query($conn, $sql);
$comentario = mysqli_fetch_assoc($resultado);

if (!$comentario) {
    echo "Comentário não encontrado.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Ver Jogo</title>
    <link rel="stylesheet" href="../css/backoffice.css">

    <link href="https://fonts.googleapis.com/css2?family=Kode+Mono&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
</head>
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

    <main class="jogo-detalhe-main">
        <h2>Comentário</h2>

        <p><strong>Utilizador:</strong> <?= $comentario['nome_utilizador']; ?></p>
        <p><strong>Jogo:</strong> <?= $comentario['titulo_jogo']; ?></p>
        <p><strong>Data:</strong> <?= $comentario['data_comentario']; ?></p>

        <hr>

        <p><?= nl2br($comentario['comentario']); ?></p>

        <br>

        <a href="dashboard_comentarios.php">← Voltar</a>

    

</main>

</div>

</body>
</html>