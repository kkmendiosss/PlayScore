<?php
session_start();
include "../conexao.php";

if (!isset($_SESSION["id"]) || $_SESSION["tipo_utilizador"] != "admin") {
    header("Location: login.php");
    exit();
}

$nome_admin = $_SESSION["nome"] ?? "Admin";
$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_genero = trim($_POST["nome"]);
    
    $nome_genero_seguro = mysqli_real_escape_string($conn, $nome_genero);

    if (!empty($nome_genero)) {
        
        $sql_verificar = "SELECT * FROM generos WHERE nome = '$nome_genero_seguro'";
        $resultado_verificar = mysqli_query($conn, $sql_verificar);
        
        if (mysqli_num_rows($resultado_verificar) > 0) {
            $mensagem = "Erro: Esse género já se encontra registado!";
        } else {
            $sql = "INSERT INTO generos (nome) VALUES ('$nome_genero_seguro')";
            
            if (mysqli_query($conn, $sql)) {
                header("Location: dashboard_generos.php");
                exit();
            } else {
                $mensagem = "Erro ao adicionar género: " . mysqli_error($conn);
            }
        }
    } else {
        $mensagem = "Erro: O nome do género não pode estar vazio.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Backoffice - Adicionar Género</title>
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

            <div class="topbar">
                <div>
                    <h1>Adicionar Género</h1>
                    <p>Insira um novo género no sistema</p>
                </div>

                <div class="topbar-actions">
                    <span>Admin: <?php echo $nome_admin; ?></span>
                </div>
            </div>

            <section class="table-card">
                
                <?php if (!empty($mensagem)): ?>
                    <p class="generos-form-message"><?php echo $mensagem; ?></p>
                <?php endif; ?>

                <form action="dashboard_adicionar_generos.php" method="POST" class="generos-form-insert" onsubmit="return validarFormulario()">
    
                    <div class="generos-form-group">
                        <label for="nome">Nome do Género</label>
                        <input type="text" id="nome" name="nome" required placeholder="Ex: Ação, Aventura...">
                    </div>

                    <div class="generos-form-buttons">
                        <button type="submit" class="btn view">
                            Salvar
                        </button>
                        <a href="dashboard_generos.php" class="btn delete">
                            Cancelar
                        </a>
                    </div>

                </form>

            </section>

        </main>

    </div>

    <script src="js/dashboard.js"></script>                    

</body>

</html>