<?php
session_start();
include "../conexao.php";

if (!isset($_SESSION["id"]) || $_SESSION["tipo_utilizador"] != "admin") {
    header("Location: login.php");
    exit();
}

$mensagem = "";

if (isset($_POST["adicionar"])) {

    $nome = trim($_POST["nome"]);
    $descricao = trim($_POST["descricao"]);
    $capa_url = "";

    if (
        isset($_FILES["capa_file"]) &&
        $_FILES["capa_file"]["error"] === UPLOAD_ERR_OK
    ) {

        $ext = strtolower(
            pathinfo($_FILES["capa_file"]["name"], PATHINFO_EXTENSION)
        );

        $permitidas = ["jpg", "jpeg", "png", "webp", "gif"];

        if (in_array($ext, $permitidas)) {

            $nome_unico = uniqid("franquia_", true) . "." . $ext;
            $pastaFisica = "../img/Franquia/uploads/";

            if (!is_dir($pastaFisica)) {
                mkdir($pastaFisica, 0777, true);
            }

            if (
                move_uploaded_file(
                    $_FILES["capa_file"]["tmp_name"],
                    $pastaFisica . $nome_unico
                )
            ) {
                $capa_url = "img/Franquia/uploads/" . $nome_unico;
            } else {
                $mensagem = "Erro ao fazer upload da imagem.";
            }
        } else {
            $mensagem = "Formato de imagem inválido.";
        }
    }

    if (!empty($capa_url)) {

        $stmt = $conn->prepare(
            "INSERT INTO franquias (nome, descricao, capa_url)
             VALUES (?, ?, ?)"
        );

        $stmt->bind_param("sss", $nome, $descricao, $capa_url);

        if ($stmt->execute()) {
            header("Location: dashboard_franquia.php");
            exit();
        } else {
            $mensagem = "Erro ao inserir na base de dados.";
        }

        $stmt->close();
    } elseif (empty($mensagem)) {
        $mensagem = "Erro: É necessário carregar uma imagem válida.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Adicionar Franquia | Dashboard</title>
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
                <h1>Adicionar Nova Franquia</h1>
            </div>

            <section class="table-card">
                <?php if ($mensagem) echo "<p style='color:red;'>$mensagem</p>"; ?>

                <form method="POST" class="add-form" enctype="multipart/form-data" style="display:flex; flex-direction:column; gap:15px; max-width:500px;">

                    <label>Nome da Franquia:</label>
                    <input type="text" name="nome" required style="padding:10px;">

                    <label>Descrição:</label>
                    <textarea name="descricao" rows="5" required style="padding:10px;"></textarea>

                    <label>Imagem de Capa:</label>
                    <input type="file" name="capa_file" accept="image/*" required>

                    <button type="submit" name="adicionar" class="add-btn" style="cursor:pointer;">
                        Guardar Franquia
                    </button>
                </form>
            </section>
        </main>
    </div>
</body>

</html>