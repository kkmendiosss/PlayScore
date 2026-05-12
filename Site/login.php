<?php
session_start();
include "conexao.php";

$erro = "";

if (isset($_POST["entrar"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $resultado = mysqli_query($conn, $sql);

    if (mysqli_num_rows($resultado) == 1) {

        $user = mysqli_fetch_assoc($resultado);

        if ($password == $user["password_hash"]) {

            $_SESSION["id"] = $user["id"];
            $_SESSION["nome"] = $user["nome"];
            $_SESSION["email"] = $user["email"];

            header("Location: index.php");
            exit();
        } else {
            $erro = "Palavra-passe errada.";
        }
    } else {
        $erro = "Conta não encontrada.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="css/login.css">
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
            <a href="#Catalogo">Catalogo</a>

            <div class="dropdown">
                <a href="#SobreNos">Sobre Nós</a>

                <div class="dropdown-content">
                    <a href="#">Contactos</a>
                    <a href="regras.html">Regras da Comunidade</a>
                    <a href="#">Politicas e privacidade</a>
                    <a href="faq.html">FAQ</a>
                </div>
            </div>

            <div class="dropdown">
                <a>Informação</a>

                <div class="dropdown-content">
                    <a href="#jogodoano">Jogo do Ano</a>
                    <a href="franquia.html">Franquia</a>
                    <a href="lancamentos.html">Lançamentos</a>
                </div>
            </div>

        </nav>

        <?php if (isset($_SESSION["nome"])) { ?>

            <div class="user-dropdown">

                <button class="btn-login">
                    <?php echo $_SESSION["nome"]; ?> ▼
                </button>

                <div class="user-dropdown-content">
                    <a href="perfil.php">Perfil</a>
                    <a href="logout.php">Sair</a>
                </div>

            </div>

        <?php } else { ?>

            <a href="login.php">
                <button class="btn-login">Login</button>
            </a>

        <?php } ?>

        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>

    </header>

    <main class="login-page">

        <section class="login-card">

            <h1>Login</h1>

            <?php
            if ($erro != "") {
                echo "<p style='color:red; margin-bottom:15px;'>$erro</p>";
            }
            ?>

            <form class="login-form" method="POST" action="login.php">

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Palavra Passe</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" name="entrar">
                    Entrar
                </button>

            </form>

            <a href="registo.php" class="register-link">
                Ainda não criou conta?
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
                    Ajudamos a transformar dados em decisões mais inteligentes.
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