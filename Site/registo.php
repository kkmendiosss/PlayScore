<?php
include "conexao.php";
$nome = $_SESSION["nome"] ?? "";
$mensagem = "";
$tipo = strtolower(trim($_SESSION["tipo_utilizador"] ?? ""));
if (isset($_POST["registar"])) {

    $nome = mysqli_real_escape_string($conn, $_POST["nome"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    // Verificar se email já existe
    $sql_check = "SELECT * FROM users WHERE email = '$email'";
    $result_check = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result_check) > 0) {

        $mensagem = "Este email já está registado.";
    } else {

        $sql = "INSERT INTO users (nome, email, password_hash)
                VALUES ('$nome', '$email', '$password')";

        if (mysqli_query($conn, $sql)) {

            $mensagem = "Conta criada com sucesso!";
        } else {

            $mensagem = "Erro ao criar conta: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registo</title>

    <link rel="stylesheet" href="css/registo.css">
    <link rel="stylesheet" href="css/headerfooter.css">

    <link href="https://fonts.googleapis.com/css2?family=Kode+Mono&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
</head>

<body>

    <header class="navbar">

        <div class="logo">
            <img src="logo/Logo.png" alt="PlayScore">
        </div>

        <nav class="nav-links" id="navLinks">

            <a href="index.php">Início</a>
            <a href="#">Catalogo</a>

            <div class="dropdown">

                <a href="#">Sobre Nós</a>

                <div class="dropdown-content">
                    <a href="contactos.php">Contactos</a>
                    <a href="regras.php">Regras da Comunidade</a>
                    <a href="politicas.php">Politicas e privacidade</a>
                    <a href="faq.php">FAQ</a>
                </div>

            </div>

            <div class="dropdown">

                <a href="#">Informação</a>

                <div class="dropdown-content">
                    <a href="jogoano.php">Jogo do Ano</a>
                    <a href="franquia.php">Franquia</a>
                    <a href="lancamentos.php">Lançamentos</a>
                </div>

            </div>

        </nav>

        <?php if ($nome != "") { ?>

            <div class="user-dropdown">

                <button class="btn-login">
                    <?php echo $nome; ?> ▼
                </button>

                <div class="user-dropdown-content">

                    <a href="perfil.php">Perfil</a>

                    <?php if ($tipo == "admin") { ?>
                        <a href="dashboard.php">Dashboard</a>
                    <?php } ?>

                    <a href="logout.php">Sair</a>

                </div>

            </div>

        <?php } else { ?>

            <a href="login.php">
                <button class="btn-login">
                    Login
                </button>
            </a>

        <?php } ?>

        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>

    </header>

    <main class="register-page">

        <section class="register-card">

            <h1>Registo</h1>

            <?php
            if ($mensagem != "") {
                echo "<p style='margin-bottom:15px;'>$mensagem</p>";
            }
            ?>

            <form class="register-form" method="POST" action="registo.php">

                <label for="nome">Nome do Utilizador</label>
                <input type="text" id="nome" name="nome" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Palavra Passe</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" name="registar">
                    Criar conta
                </button>

            </form>

            <a href="login.php" class="login-link">
                Já criou uma conta?
            </a>

        </section>

    </main>

    <footer>

        <div class="footer-content">

            <div class="footer-column brand-col">

                <div class="logo">
                    <img src="logo/Logo.png" alt="PlayScore">
                </div>

                <p class="footer-desc">
                    Ajudamos a transformar dados em decisões mais inteligentes.<br>
                </p>

            </div>

            <div class="footer-column nav-col">

                <h3>Navegação</h3>

                <a href="#">Início</a>
                <a href="#">Sobre Nós</a>
                <a href="#">Catalogo</a>

            </div>

            <div class="footer-column legal-col">

                <h3>Legalidade</h3>

                <a href="regras.html">Regras da Comunidade</a>
                <a href="#">Política de privacidade</a>
                <a href="#">Contactos</a>

            </div>

            <div class="footer-social">
                <span>Discord</span>
                <span>Twitter</span>
                <span>LinkedIn</span>
            </div>

        </div>

        <div class="footer-bottom">
            <p>© 2026 PLAYSCORE NETWORK. TODOS OS DIREITOS RESERVADOS.</p>
        </div>

    </footer>

    <script src="js/headerfooter.js"></script>

</body>

</html>