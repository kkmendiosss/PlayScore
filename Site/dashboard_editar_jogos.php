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

$sql = "SELECT * FROM jogos WHERE id_jogo = $id";
$resultado = mysqli_query($conn, $sql);

$jogo = mysqli_fetch_assoc($resultado);

if (!$jogo) {
    header("Location: dashboard_jogos.php");
    exit();
}

$generos_jogo = [];

$result = mysqli_query($conn, "
    SELECT id_genero 
    FROM jogo_genero 
    WHERE id_jogo = $id
");

while ($row = mysqli_fetch_assoc($result)) {
    $generos_jogo[] = (int)$row['id_genero'];
}

$plataformas_array = !empty($jogo['plataforma'])
    ? explode(", ", $jogo['plataforma'])
    : [];

$mensagem = "";

$generos = mysqli_query($conn, "SELECT id_genero, nome FROM generos");
$franquias = mysqli_query($conn, "SELECT id_franquia, nome FROM franquias");

if (isset($_POST["guardar"])) {

    $titulo = mysqli_real_escape_string($conn, $_POST["titulo"]);
    $desenvolvedor = mysqli_real_escape_string($conn, $_POST["desenvolvedor"]);
    $editor = mysqli_real_escape_string($conn, $_POST["editor"]);
    $descricao = mysqli_real_escape_string($conn, $_POST["descricao"]);
    $data_lancamento = $_POST["data_lancamento"];
    $trailer_url = mysqli_real_escape_string($conn, $_POST["trailer_url"]);

    // 📸 CAPA (mantém a antiga se não enviar nova)
    $capa_url = $jogo['capa_url'];

    if (isset($_FILES["capa"]) && $_FILES["capa"]["error"] == 0) {

        $pasta = "uploads/capas/";

        if (!is_dir($pasta)) {
            mkdir($pasta, 0777, true);
        }

        $nomeFicheiro = time() . "_" . basename($_FILES["capa"]["name"]);
        $caminho = $pasta . $nomeFicheiro;

        if (move_uploaded_file($_FILES["capa"]["tmp_name"], $caminho)) {
            $capa_url = $caminho;
        }
    }

    // 🏷️ FRANQUIA
    $id_franquia = !empty($_POST["id_franquia"])
        ? intval($_POST["id_franquia"])
        : "NULL";

    // 🔧 UPDATE JOGO (SEM géneros aqui)
    $sql_update = "UPDATE jogos SET
        titulo = '$titulo',
        desenvolvedor = '$desenvolvedor',
        editor = '$editor',
        descricao = '$descricao',
        data_lancamento = '$data_lancamento',
        capa_url = '$capa_url',
        trailer_url = '$trailer_url',
        id_franquia = $id_franquia
        WHERE id_jogo = $id";

    if (mysqli_query($conn, $sql_update)) {

        // 🧹 apagar géneros antigos
        mysqli_query($conn, "DELETE FROM jogo_genero WHERE id_jogo = $id");

        // 🎯 inserir novos géneros (ARRAY)
        if (!empty($_POST["id_genero"]) && is_array($_POST["id_genero"])) {

            foreach ($_POST["id_genero"] as $id_genero) {

                $id_genero = intval($id_genero);

                mysqli_query($conn, "
                    INSERT INTO jogo_genero (id_jogo, id_genero)
                    VALUES ($id, $id_genero)
                ");
            }
        }

        header("Location: dashboard_jogos.php");
        exit();

    } else {
        $mensagem = "Erro ao atualizar jogo: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Editar Jogo</title>

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
                <h1>Editar Jogo</h1>
                <p>Editar informações do jogo</p>
            </div>
        </div>

        <section class="table-card">

            <?php if (!empty($mensagem)) { ?>
                <p><?php echo $mensagem; ?></p>
            <?php } ?>

            <form method="POST" enctype="multipart/form-data" class="generos-form-insert">

                <div class="generos-form-group">
                    <label>Título</label>
                    <input
                        type="text"
                        name="titulo"
                        value="<?php echo $jogo['titulo']; ?>"
                        required>
                </div>

                <div class="generos-form-group">
                    <label>Desenvolvedor</label>
                    <input
                        type="text"
                        name="desenvolvedor"
                        value="<?php echo $jogo['desenvolvedor']; ?>"
                        required>
                </div>

                <div class="generos-form-group">
                    <label>Editor</label>
                    <input
                        type="text"
                        name="editor"
                        value="<?php echo $jogo['editor']; ?>"
                        required>
                </div>

                <div class="generos-form-group">
                    <label>Descrição</label>
                    <textarea name="descricao"><?php echo $jogo['descricao']; ?></textarea>
                </div>

                <div class="generos-form-group">
                    <label>Data de Lançamento</label>
                    <input
                        type="date"
                        name="data_lancamento"
                        value="<?php echo $jogo['data_lancamento']; ?>">
                </div>

                <div class="generos-form-group">
                    <label for="capa">Capa do Jogo</label>
                    <input type="file" name="capa" accept="image/*">
                </div>

                <div class="generos-form-group">
                    <label>Trailer URL</label>
                    <input
                        type="text"
                        name="trailer_url"
                        value="<?php echo $jogo['trailer_url']; ?>">
                </div>

                <div class="generos-form-group plataformas">
                <label>Plataformas</label>

                    <div class="plataformas-grid">

                        <label class="plataforma-card">
                            <input type="checkbox" name="plataforma[]" value="PC"
                            <?php if (!empty($plataformas_array) && in_array("PC", $plataformas_array)) echo "checked"; ?>>
                            <span>PC</span>
                        </label>

                        <label class="plataforma-card">
                            <input type="checkbox" name="plataforma[]" value="PlayStation 5"
                            <?php if (!empty($plataformas_array) && in_array("PlayStation 5", $plataformas_array)) echo "checked"; ?>>
                            <span>PlayStation 5</span>
                        </label>

                        <label class="plataforma-card">
                            <input type="checkbox" name="plataforma[]" value="Xbox Series X/S"
                            <?php if (!empty($plataformas_array) && in_array("Xbox Series X/S", $plataformas_array)) echo "checked"; ?>>
                            <span>Xbox Series X/S</span>
                        </label>

                        <label class="plataforma-card">
                            <input type="checkbox" name="plataforma[]" value="Nintendo Switch"
                            <?php if (!empty($plataformas_array) && in_array("Nintendo Switch", $plataformas_array)) echo "checked"; ?>>
                            <span>Nintendo Switch</span>
                        </label>

                        <label class="plataforma-card">
                            <input type="checkbox" name="plataforma[]" value="Mobile"
                            <?php if (!empty($plataformas_array) && in_array("Mobile", $plataformas_array)) echo "checked"; ?>>
                            <span>Mobile</span>
                        </label>

                    </div>
                </div>

                <div class="generos-form-group">
                <label>Géneros</label>
                    <div class="generos-grid">
                        <?php while ($g = mysqli_fetch_assoc($generos)) { ?>
                            <label class="genero-card">
                                <input type="checkbox" name="id_genero[]" value="<?php echo $g['id_genero']; ?>"
                                    <?php if (in_array((int)$g['id_genero'], $generos_jogo)) echo "checked"; ?>>
                                <span><?php echo $g['nome']; ?></span>
                            </label>
                        <?php } ?>
                    </div>
                </div>

                <div class="generos-form-group">
                    <label>Franquia</label>

                    <select name="id_franquia">

                        <option value="">Sem franquia</option>

                        <?php while ($f = mysqli_fetch_assoc($franquias)) { ?>

                            <option
                                value="<?php echo $f['id_franquia']; ?>"
                                <?php if ($f['id_franquia'] == $jogo['id_franquia']) echo "selected"; ?>>

                                <?php echo $f['nome']; ?>

                            </option>

                        <?php } ?>

                    </select>
                </div>

                <div class="generos-form-buttons">

                    <button
                        type="submit"
                        name="guardar"
                        class="btn view">

                        Guardar Alterações

                    </button>

                    <a
                        href="dashboard_jogos.php"
                        class="btn delete">

                        Cancelar

                    </a>

                </div>

            </form>

        </section>

    </main>

</div>

</body>
</html>
```
