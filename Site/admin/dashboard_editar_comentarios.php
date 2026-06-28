<?php
session_start();
include "../conexao.php";

if (!isset($_SESSION["id"]) || $_SESSION["tipo_utilizador"] != "admin") {
    header("Location: login.php");
    exit();
}

$id = (int)$_GET["id"];

$sql = "
SELECT *
FROM comentarios
WHERE id_comentario = $id
";

$resultado = mysqli_query($conn, $sql);
$comentario = mysqli_fetch_assoc($resultado);

if (!$comentario) {
    echo "Comentário não encontrado.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $novo_comentario = mysqli_real_escape_string($conn, $_POST["comentario"]);

    $update = "
        UPDATE comentarios
        SET comentario = '$novo_comentario'
        WHERE id_comentario = $id
    ";

    if (mysqli_query($conn, $update)) {
        header("Location: dashboard_comentarios.php");
        exit();
    } else {
        echo "Erro ao atualizar comentário: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Backoffice - Comentários</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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

            <div class="edit-comment-page">

            <div class="edit-comment-card">

                <h2 class="edit-comment-title">Editar Comentário</h2>

                <form method="POST" class="edit-comment-form">

                    <label class="edit-comment-label">Comentário</label>

                    <textarea 
                        name="comentario" 
                        class="edit-comment-textarea"
                        rows="6"
                    ><?= htmlspecialchars($comentario['comentario']); ?></textarea>

                    <div class="edit-comment-actions">

                        <button type="submit" class="edit-comment-btn save">
                            Guardar
                        </button>

                        <a href="dashboard_comentarios.php" class="edit-comment-btn cancel">
                            Cancelar
                        </a>

                    </div>

                </form>

            </div>

        </div>
    </main>

</div>

</body>
</html>