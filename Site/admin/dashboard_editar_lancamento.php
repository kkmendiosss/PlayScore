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
    header("Location: dashboard_lancamento.php");
    exit();
}

$id = (int) $_GET["id"];

$sql = "SELECT * FROM lancamentos WHERE id_lancamento = $id";
$resultado = mysqli_query($conn, $sql);

$lancamento = mysqli_fetch_assoc($resultado);

if (!$lancamento) {
    header("Location: dashboard_lancamento.php");
    exit();
}

$mensagem = "";

if (isset($_POST["guardar"])) {

    $data = $_POST["data"];
    $nome = $_POST["nome"];
    $plataformas = $_POST["plataformas"];

    $sql_update = "UPDATE lancamentos SET
        data = '$data',
        nome = '$nome',
        plataformas = '$plataformas'
        WHERE id_lancamento = $id";

    if (mysqli_query($conn, $sql_update)) {
        header("Location: dashboard_lancamento.php");
        exit();
    } else {
        $mensagem = "Erro ao atualizar lançamento.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Editar Lançamento</title>

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
                    <h1>Editar Lançamento</h1>
                    <p>Editar lançamento</p>
                </div>
            </div>

            <section class="table-card">

                <?php if (!empty($mensagem)) { ?>
                    <p><?php echo $mensagem; ?></p>
                <?php } ?>

                <form method="POST" class="add-form">

                    <input type="date"
                        name="data"
                        value="<?php echo htmlspecialchars($lancamento["data"]); ?>"
                        required>

                    <input type="text"
                        name="nome"
                        value="<?php echo htmlspecialchars($lancamento["nome"]); ?>"
                        placeholder="Nome do lançamento"
                        required>

                    <input type="text"
                        name="plataformas"
                        value="<?php echo htmlspecialchars($lancamento["plataformas"]); ?>"
                        placeholder="Plataformas">

                    <button type="submit" name="guardar" class="add-btn">
                        Guardar Alterações
                    </button>

                </form>

            </section>

        </main>

    </div>

</body>

</html>