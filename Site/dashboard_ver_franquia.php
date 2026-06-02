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
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Ver Franquia | Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="../css/ver_franquia.css">
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
                <h1>Ver Franquia</h1>
                <p style="color:#aaa;">Detalhes da franquia registada</p>
            </div>

            <a href="dashboard_franquia.php" class="btn-voltar">Voltar</a>
        </div>

        <section class="franquia-view-card">

            <?php if (!empty($franquia["capa_url"])) { ?>
                <img src="<?php echo htmlspecialchars($franquia["capa_url"]); ?>" alt="Imagem da franquia">
            <?php } ?>

            <div class="info-row">
                <span>ID</span>
                <p><?php echo $franquia["id_franquia"]; ?></p>
            </div>

            <div class="info-row">
                <span>Nome do Projeto</span>
                <p><?php echo htmlspecialchars($franquia["nome"]); ?></p>
            </div>

            <div class="info-row">
                <span>Descrição</span>
                <p><?php echo nl2br(htmlspecialchars($franquia["descricao"])); ?></p>
            </div>

            <div class="info-row">
                <span>Caminho da Imagem</span>
                <p><?php echo htmlspecialchars($franquia["capa_url"]); ?></p>
            </div>

            <div class="actions">
                <a 
                    href="dashboard_editar_franquia.php?id=<?php echo $franquia["id_franquia"]; ?>" 
                    class="btn-editar"
                >
                    Editar
                </a>

                <a 
                    href="dashboard_franquia.php?apagar_id=<?php echo $franquia["id_franquia"]; ?>" 
                    class="btn-eliminar"
                    onclick="return confirm('Tens a certeza que queres eliminar esta franquia?');"
                >
                    Eliminar
                </a>
            </div>

        </section>

    </main>

</div>

</body>
</html>