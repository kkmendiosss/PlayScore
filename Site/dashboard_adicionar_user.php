<?php
session_start();
include "conexao.php";

if (isset($_POST["adicionar"])) {

    $nome = $_POST["nome"];
    $email = $_POST["email"];

    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $tipo = $_POST["tipo_utilizador"];

    $sql = "INSERT INTO users (nome, email, password_hash, tipo_utilizador)
            VALUES ('$nome', '$email', '$password', '$tipo')";

    if (mysqli_query($conn, $sql)) {

        header("Location: dashboard_users.php");
        exit();
    } else {

        $mensagem = "Erro ao adicionar utilizador.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Adicionar User</title>

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
                    <h1>Adicionar User</h1>
                    <p>Criar novo utilizador</p>
                </div>
            </div>

            <section class="table-card">

                <?php if (!empty($mensagem)) { ?>
                    <p><?php echo $mensagem; ?></p>
                <?php } ?>

                <form method="POST" class="add-form">

                    <input type="text"
                        name="nome"
                        placeholder="Nome"
                        required>

                    <input type="email"
                        name="email"
                        placeholder="Email"
                        required>

                    <input type="password"
                        name="password"
                        placeholder="Password"
                        required>

                    <select name="tipo_utilizador">

                        <option value="membro">
                            Membro
                        </option>

                        <option value="admin">
                            Admin
                        </option>

                    </select>

                    <button type="submit" name="adicionar" class="add-btn">
                        Adicionar User
                    </button>

                </form>

            </section>

        </main>

    </div>

</body>

</html>