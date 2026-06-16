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

$id = (int)$_GET["id"];

$sql = "SELECT * FROM franquias WHERE id_franquia = $id";
$resultado = mysqli_query($conn, $sql);

$franquia = mysqli_fetch_assoc($resultado);

if (!$franquia) {
    header("Location: dashboard_franquia.php");
    exit();
}

$mensagem = "";

if (isset($_POST["guardar"])) {

    $nome = mysqli_real_escape_string($conn, $_POST["nome"]);
    $descricao = mysqli_real_escape_string($conn, $_POST["descricao"]);

    $capa_url = $franquia["capa_url"];

    if (
        isset($_FILES["capa_file"]) &&
        $_FILES["capa_file"]["error"] === UPLOAD_ERR_OK
    ) {

        $pastaFisica = dirname(__DIR__) . "/img/Franquia/uploads/";

        if (!is_dir($pastaFisica)) {
            mkdir($pastaFisica, 0777, true);
        }

        $extensao = strtolower(
            pathinfo($_FILES["capa_file"]["name"], PATHINFO_EXTENSION)
        );

        $nomeImagem = uniqid("franquia_", true) . "." . $extensao;

        $destino = $pastaFisica . $nomeImagem;

        if (move_uploaded_file($_FILES["capa_file"]["tmp_name"], $destino)) {
            $capa_url = "img/Franquia/uploads/" . $nomeImagem;
        } else {
            $mensagem = "Erro ao fazer upload da imagem.";
        }
    }

    $sql_update = "
        UPDATE franquias
        SET
            nome = '$nome',
            descricao = '$descricao',
            capa_url = '$capa_url'
        WHERE id_franquia = $id
    ";

    if (mysqli_query($conn, $sql_update)) {
        header("Location: dashboard_franquia.php");
        exit();
    } else {
        $mensagem = "Erro ao atualizar franquia.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Editar Franquia</title>

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
                    <h1>Editar Franquia</h1>
                    <p>Editar franquia</p>
                </div>
            </div>

            <section class="table-card">

                <?php if (!empty($mensagem)) { ?>
                    <p><?php echo $mensagem; ?></p>
                <?php } ?>

                <form method="POST" class="add-form" enctype="multipart/form-data">

                    <input type="text"
                        name="nome"
                        value="<?php echo htmlspecialchars($franquia["nome"]); ?>"
                        placeholder="Nome da franquia"
                        required>

                    <textarea
                        name="descricao"
                        rows="5"
                        placeholder="Descrição da franquia"
                        required><?php echo htmlspecialchars($franquia["descricao"]); ?></textarea>

                    <?php if (!empty($franquia["capa_url"])) { ?>

                        <img src="<?php echo $franquia["capa_url"]; ?>"
                            style="max-width:200px;margin-bottom:10px;">

                    <?php } ?>

                    <input type="file" name="capa_file">

                    <button type="submit" name="guardar" class="add-btn">
                        Guardar Alterações
                    </button>

                </form>

            </section>

        </main>

    </div>

</body>

</html>