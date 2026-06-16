<?php
session_start();
include "../conexao.php";

$mensagem = "";

if (isset($_POST["adicionar"])) {

    $nome = $_POST["nome"];
    $plataformas = $_POST["plataformas"];
    $data = $_POST["data"];

    $sql = "INSERT INTO lancamentos (nome, plataformas, data)
            VALUES ('$nome', '$plataformas', '$data')";

    if (mysqli_query($conn, $sql)) {

        header("Location: dashboard_lancamento.php");
        exit();
    } else {

        $mensagem = "Erro ao adicionar lançamento.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Adicionar Lançamento</title>

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
                    <h1>Adicionar Lançamento</h1>
                    <p>Criar novo lançamento</p>
                </div>
            </div>

            <section class="table-card">

                <?php if (!empty($mensagem)) { ?>
                    <p><?php echo $mensagem; ?></p>
                <?php } ?>

                <form method="POST" class="add-form">

                    <input
                        type="text"
                        name="nome"
                        placeholder="Nome do jogo"
                        required>

                    <input
                        type="text"
                        name="plataformas"
                        placeholder="PC, PS5, Xbox Series X/S..."
                        required>

                    <input
                        type="date"
                        name="data"
                        required>

                    <button type="submit" name="adicionar" class="add-btn">
                        Adicionar Lançamento
                    </button>

                </form>

            </section>

        </main>

    </div>

</body>

</html>