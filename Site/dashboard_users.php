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

$nome_admin = $_SESSION["nome"] ?? "Admin";

if (isset($_GET["eliminar"])) {
    $id = $_GET["eliminar"];

    $sql = "DELETE FROM users WHERE id_utilizador = $id";

    mysqli_query($conn, $sql);

    header("Location: dashboard_users.php");
    exit();
}

$sql = "SELECT * FROM users ORDER BY id_utilizador DESC";
$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Backoffice - Users</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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
                    <h1>Users</h1>
                    <p>Gestão dos utilizadores registados</p>
                </div>

                <div class="topbar-actions">
                    <a href="dashboard_adicionar_user.php" class="add-btn">
                        + Adicionar
                    </a>

                    <span>Admin: <?php echo $nome_admin; ?></span>
                </div>
            </div>
            <section class="table-card">

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Avatar</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Tipo</th>
                            <th>Data Registo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php while ($user = mysqli_fetch_assoc($resultado)) { ?>

                            <tr>
                                <td><?php echo $user["id_utilizador"]; ?></td>

                                <td>
                                    <?php if (!empty($user["avatar_url"])) { ?>
                                        <img src="<?php echo $user["avatar_url"]; ?>" class="table-avatar">
                                    <?php } else { ?>
                                        <div class="avatar-placeholder">?</div>
                                    <?php } ?>
                                </td>

                                <td><?php echo $user["nome"]; ?></td>
                                <td><?php echo $user["email"]; ?></td>
                                <td><?php echo $user["tipo_utilizador"]; ?></td>

                                <td>
                                    <?php echo date("d/m/Y", strtotime($user["data_registo"])); ?>
                                </td>

                                <td class="actions">

                                    <a href="dashboard_ver_user.php?id=<?php echo $user["id_utilizador"]; ?>"
                                        class="btn view"
                                        title="Ver">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    <a href="dashboard_editar_user.php?id=<?php echo $user["id_utilizador"]; ?>"
                                        class="btn edit"
                                        title="Editar">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    <a href="dashboard_users.php?eliminar=<?php echo $user["id_utilizador"]; ?>"
                                        class="btn delete"
                                        title="Eliminar"
                                        onclick="return confirm('Tens a certeza que queres eliminar este utilizador?');">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>

                                </td>
                            </tr>

                        <?php } ?>

                    </tbody>
                </table>

            </section>

        </main>

    </div>

</body>

</html>