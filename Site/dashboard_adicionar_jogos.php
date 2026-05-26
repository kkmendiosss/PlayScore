<?php
session_start();
include "conexao.php";

if (!isset($_SESSION["id"]) || $_SESSION["tipo_utilizador"] != "admin") {
    header("Location: login.php");
    exit();
}

$nome_admin = $_SESSION["nome"] ?? "Admin";
$mensagem = "";

$generos = mysqli_query($conn, "SELECT id_genero, nome FROM generos");
$franquias = mysqli_query($conn, "SELECT id_franquia, nome FROM franquias");

if (!$generos || !$franquias) {
    die("Erro ao carregar dados: " . mysqli_error($conn));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $titulo = mysqli_real_escape_string($conn, $_POST["titulo"]);
    $desenvolvedor = mysqli_real_escape_string($conn, $_POST["desenvolvedor"]);
    $editor = mysqli_real_escape_string($conn, $_POST["editor"]);
    $descricao = mysqli_real_escape_string($conn, $_POST["descricao"]);
    $data_lancamento = $_POST["data_lancamento"];
    $capa_url = mysqli_real_escape_string($conn, $_POST["capa_url"]);
    $trailer_url = mysqli_real_escape_string($conn, $_POST["trailer_url"]);
    $plataforma = mysqli_real_escape_string($conn, $_POST["plataforma"]);

    $id_genero = intval($_POST["id_genero"]);

    $id_franquia = !empty($_POST["id_franquia"]) 
        ? intval($_POST["id_franquia"]) 
        : "NULL";

    if (!empty($titulo) && !empty($desenvolvedor) && !empty($editor)) {

        $sql = "INSERT INTO jogos (
            titulo,
            desenvolvedor,
            editor,
            descricao,
            data_lancamento,
            capa_url,
            trailer_url,
            plataforma,
            classificacao,
            id_genero,
            id_franquia,
            num_votos,
            soma_classificacao
        ) VALUES (
            '$titulo',
            '$desenvolvedor',
            '$editor',
            '$descricao',
            '$data_lancamento',
            '$capa_url',
            '$trailer_url',
            '$plataforma',
            0,
            $id_genero,
            $id_franquia,
            0,
            0
        )";

        if (mysqli_query($conn, $sql)) {
            header("Location: dashboard_jogos.php");
            exit();
        } else {
            $mensagem = "Erro ao adicionar jogo: " . mysqli_error($conn);
        }

    } else {
        $mensagem = "Preenche os campos obrigatórios.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Backoffice - Adicionar Jogo</title>
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
                <h1>Adicionar Jogo</h1>
                <p>Insira um novo jogo no sistema</p>
            </div>

            <div class="topbar-actions">
                <span>Admin: <?php echo $nome_admin; ?></span>
            </div>
        </div>

        <section class="table-card">

            <?php if (!empty($mensagem)): ?>
                <p class="form-message"><?php echo $mensagem; ?></p>
            <?php endif; ?>

            <form action="dashboard_adicionar_jogos.php" method="POST" class="generos-form-insert">

                <div class="generos-form-group">
                    <label for="titulo">Título</label>
                    <input type="text" name="titulo" required>
                </div>

                <div class="generos-form-group">
                    <label for="desenvolvedor">Desenvolvedor</label>
                    <input type="text" name="desenvolvedor" required>
                </div>

                <div class="generos-form-group">
                    <label for="editor">Editor</label>
                    <input type="text" name="editor" required>
                </div>

                <div class="generos-form-group">
                    <label for="descricao">Descrição</label>
                    <textarea name="descricao"></textarea>
                </div>

                <div class="generos-form-group">
                    <label for="data_lancamento">Data de Lançamento</label>
                    <input type="date" name="data_lancamento">
                </div>

                <div class="generos-form-group">
                    <label for="capa_url">Capa URL</label>
                    <input type="text" name="capa_url">
                </div>

                <div class="generos-form-group">
                    <label for="trailer_url">Trailer URL</label>
                    <input type="text" name="trailer_url">
                </div>

                <div class="generos-form-group">
                    <label for="plataforma">Plataforma</label>
                    <input type="text" name="plataforma">
                </div>

                <div class="generos-form-group">
                    <label>Género</label>
                    <select name="id_genero" required>

                    <option value="">Escolhe um género</option>

                    <?php while ($g = $generos->fetch_assoc()): ?>
                    <option value="<?= $g['id_genero'] ?>">
                        <?= $g['nome'] ?>
                    </option>
                    <?php endwhile; ?>

                    </select>
                </div>

                <div class="generos-form-group">
                    <label>ID Franquia</label>
                    <input type="number" name="id_franquia">
                </div>

                <div class="generos-form-buttons">
                    <button type="submit" class="btn view">Salvar</button>
                    <a href="dashboard_jogos.php" class="btn delete">Cancelar</a>
                </div>

            </form>

        </section>

    </main>

</div>

</body>
</html>