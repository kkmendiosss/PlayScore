<?php
session_start();
include "../conexao.php";

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

    $capa_url = "";

    if (isset($_FILES["capa"]) && $_FILES["capa"]["error"] == 0) {

        $pasta = "../uploads/capas/";

        if (!is_dir($pasta)) {
            mkdir($pasta, 0777, true);
        }

        $ext = pathinfo($_FILES["capa"]["name"], PATHINFO_EXTENSION);
        $nomeFicheiro = uniqid("capa_", true) . "." . $ext;
        $caminho = $pasta . $nomeFicheiro;

        if (move_uploaded_file($_FILES["capa"]["tmp_name"], $caminho)) {
            $capa_url = $caminho;
        }
    }

    $trailer_url = mysqli_real_escape_string($conn, $_POST["trailer_url"]);

    $plataforma = isset($_POST["plataforma"])
        ? implode(", ", $_POST["plataforma"])
        : "";

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
            $id_franquia,
            0,
            0
        )";

        if (mysqli_query($conn, $sql)) {

            $id_jogo = mysqli_insert_id($conn);

            if (!empty($_POST["id_genero"])) {

                foreach ($_POST["id_genero"] as $id_genero) {

                    $id_genero = intval($id_genero);

                    mysqli_query($conn, "
                        INSERT INTO jogo_genero (id_jogo, id_genero)
                        VALUES ($id_jogo, $id_genero)
                    ");
                }
            }

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

            <form action="dashboard_adicionar_jogos.php" method="POST" enctype="multipart/form-data" class="generos-form-insert">

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
                    <label for="capa">Capa do Jogo</label>
                    <input type="file" name="capa" accept="image/*">
                </div>

                <div class="generos-form-group">
                    <label for="trailer_url">Trailer URL</label>
                    <input type="text" name="trailer_url">
                </div>

                <div class="generos-form-group plataformas">
                    <label>Plataformas</label>

                    <div class="plataformas-grid">

                        <label class="plataforma-card">
                            <span>PC</span>
                            <input type="checkbox" name="plataforma[]" value="PC">
                        </label>

                        <label class="plataforma-card">
                            <span>PlayStation 5</span>
                            <input type="checkbox" name="plataforma[]" value="PlayStation 5">
                        </label>

                        <label class="plataforma-card">
                            <span>Xbox Series X/S</span>
                            <input type="checkbox" name="plataforma[]" value="Xbox Series X/S">
                        </label>

                        <label class="plataforma-card">
                            <span>Nintendo Switch</span>
                            <input type="checkbox" name="plataforma[]" value="Nintendo Switch">
                        </label>

                        <label class="plataforma-card">
                            <span>Mobile</span>
                            <input type="checkbox" name="plataforma[]" value="Mobile">
                        </label>

                    </div>
                </div>

                <div class="generos-form-group">
                    <label>Géneros</label>
                    <div class="generos-grid">
                        <?php while ($g = $generos->fetch_assoc()) { ?>
                            <label class="genero-card">
                                <input type="checkbox" name="id_genero[]" value="<?php echo $g['id_genero']; ?>">
                            <span><?php echo $g['nome']; ?></span>
                            </label>
                        <?php } ?>
                    </div>
                </div>

                <div class="generos-form-group">
                    <label>ID Franquia</label>
                    <input type="text" name="nome">
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