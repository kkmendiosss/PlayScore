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
    header("Location: dashboard_users.php");
    exit();
}

$id = $_GET["id"];

$sql = "SELECT * FROM users WHERE id_utilizador = $id";
$resultado = mysqli_query($conn, $sql);

$user = mysqli_fetch_assoc($resultado);

if (!$user) {
    header("Location: dashboard_users.php");
    exit();
}

$mensagem = "";

if (isset($_POST["guardar"])) {

    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $tipo = $_POST["tipo_utilizador"];
    $avatar = $_POST["avatar_url"];

    $sql_update = "UPDATE users SET
        nome = '$nome',
        email = '$email',
        tipo_utilizador = '$tipo',
        avatar_url = '$avatar'
        WHERE id_utilizador = $id";

    if (mysqli_query($conn, $sql_update)) {

        header("Location: dashboard_users.php");
        exit();
    } else {

        $mensagem = "Erro ao atualizar utilizador.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Editar User</title>

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
                    <h1>Editar User</h1>
                    <p>Editar utilizador</p>
                </div>
            </div>

            <section class="table-card">

                <?php if (!empty($mensagem)) { ?>
                    <p><?php echo $mensagem; ?></p>
                <?php } ?>

                <form method="POST" class="add-user-form">

                    <input type="text"
                        name="nome"
                        value="<?php echo $user["nome"]; ?>"
                        required>

                    <input type="email"
                        name="email"
                        value="<?php echo $user["email"]; ?>"
                        required>

                    <input type="text"
                        name="avatar_url"
                        value="<?php echo $user["avatar_url"]; ?>"
                        placeholder="Avatar URL">

                    <select name="tipo_utilizador">

                        <option value="membro"
                            <?php if ($user["tipo_utilizador"] == "membro") echo "selected"; ?>>
                            Membro
                        </option>

                        <option value="admin"
                            <?php if ($user["tipo_utilizador"] == "admin") echo "selected"; ?>>
                            Admin
                        </option>

                    </select>

                    <button type="submit" name="guardar" class="add-btn">
                        Guardar Alterações
                    </button>

                </form>

            </section>

        </main>

    </div>

</body>

</html>