<?php
session_start();
include "conexao.php";

$nome = $_SESSION["nome"] ?? "";
$tipo = strtolower(trim($_SESSION["tipo_utilizador"] ?? ""));

if ($nome == "" || $tipo != "admin") {
    header("Location: login.php");
    exit;
}

if (!isset($_GET["id"])) {
    header("Location: dashboard_franquia.php");
    exit;
}

$id = (int) $_GET["id"];
$erros = [];


$stmt = $conn->prepare("SELECT * FROM franquias WHERE id_franquia = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    header("Location: dashboard_franquia.php");
    exit;
}

$franquia = $resultado->fetch_assoc();
$stmt->close();

// Atualizar dados
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $novo_nome = trim($_POST["nome"] ?? "");
    $nova_descricao = trim($_POST["descricao"] ?? "");
    $nova_imagem = $franquia["capa_url"];

    if ($novo_nome == "") {
        $erros[] = "O nome do projeto é obrigatório.";
    }

    if ($nova_descricao == "") {
        $erros[] = "A descrição é obrigatória.";
    }

    if (isset($_FILES["capa_file"]) && $_FILES["capa_file"]["error"] == 0) {
        $ficheiro = $_FILES["capa_file"];
        $extensoes_permitidas = ["jpg", "jpeg", "png", "gif", "webp"];
        $extensao = strtolower(pathinfo($ficheiro["name"], PATHINFO_EXTENSION));

        if (!in_array($extensao, $extensoes_permitidas)) {
            $erros[] = "Formato inválido. Usa JPG, JPEG, PNG, GIF ou WEBP.";
        } else {
            $pasta_destino = "img/Franquia/uploads/";

            if (!is_dir($pasta_destino)) {
                mkdir($pasta_destino, 0777, true);
            }

            $nome_unico = uniqid("franquia_", true) . "." . $extensao;
            $caminho_final = $pasta_destino . $nome_unico;

            if (move_uploaded_file($ficheiro["tmp_name"], $caminho_final)) {

               
                if (!empty($franquia["capa_url"]) && file_exists($franquia["capa_url"])) {
                    unlink($franquia["capa_url"]);
                }

                $nova_imagem = $caminho_final;
            } else {
                $erros[] = "Erro ao carregar a nova imagem.";
            }
        }
    }

    if (empty($erros)) {
        $stmt_update = $conn->prepare("
            UPDATE franquias 
            SET nome = ?, descricao = ?, capa_url = ?
            WHERE id_franquia = ?
        ");

        $stmt_update->bind_param("sssi", $novo_nome, $nova_descricao, $nova_imagem, $id);

        if ($stmt_update->execute()) {
            header("Location: dashboard_franquia.php");
            exit;
        } else {
            $erros[] = "Erro ao atualizar a franquia.";
        }

        $stmt_update->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Editar Franquia | Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/editar_franquia.css">
    <link rel="icon" href="img/PlayScore_Icon.png">
</head>

<body>

<div class="dashboard-layout">

    <aside class="sidebar">
        <div class="sidebar-logo">
            <img src="logo/Logo.png" alt="PlayScore">
        </div>

        <h2>Dashboard</h2>

        <a href="dashboard.php">Dashboard</a>
        <a href="dashboard_favoritos.php">Favoritos</a>
        <a href="dashboard_generos.php">Géneros</a>
        <a href="dashboard_contactos.php">Contactos</a>
        <a href="dashboard_franquia.php" class="active">Franquias</a>
        <a href="dashboard_jogos.php">Jogos</a>
        <a href="dashboard_jogodoano.php">Jogo do Ano</a>
        <a href="dashboard_lancamentos.php">Lançamentos</a>
        <a href="dashboard_comentarios.php">Comentários</a>
        <a href="dashboard_users.php">Users</a>
        <a href="index.php">Voltar ao site</a>
    </aside>

    <main class="dashboard-content">

        <div class="page-top">
            <div>
                <h1>Editar Franquia</h1>
                <p style="color:#aaa;">Alterar dados da franquia registada</p>
            </div>

            <a href="dashboard_franquia.php" class="btn-voltar">Voltar</a>
        </div>

        <section class="edit-card">

            <?php if (!empty($erros)) { ?>
                <div class="erro-box">
                    <ul>
                        <?php foreach ($erros as $erro) { ?>
                            <li><?php echo htmlspecialchars($erro); ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>

            <?php if (!empty($franquia["capa_url"])) { ?>
                <img class="preview-img" src="<?php echo htmlspecialchars($franquia["capa_url"]); ?>" alt="Imagem atual">
            <?php } ?>

            <form method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="nome">Nome do Projeto</label>
                    <input 
                        type="text" 
                        id="nome" 
                        name="nome" 
                        value="<?php echo htmlspecialchars($franquia["nome"]); ?>" 
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" required><?php echo htmlspecialchars($franquia["descricao"]); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="capa_file">Nova Imagem</label>
                    <input 
                        type="file" 
                        id="capa_file" 
                        name="capa_file" 
                        accept="image/*"
                    >
                </div>

                <button type="submit" class="btn-guardar">
                    Guardar Alterações
                </button>

            </form>

        </section>

    </main>

</div>

</body>
</html>