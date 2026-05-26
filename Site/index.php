<?php
session_start();
include "conexao.php";
$nome = $_SESSION["nome"] ?? "";
$email = $_SESSION["email"] ?? "";
$tipo = strtolower(trim($_SESSION["tipo_utilizador"] ?? ""));

$sql_avaliacoes = "SELECT COUNT(*) AS total FROM avaliacoes";
$result_avaliacoes = mysqli_query($conn, $sql_avaliacoes);
$total_avaliacoes = mysqli_fetch_assoc($result_avaliacoes)["total"];

$sql_comentarios = "SELECT COUNT(*) AS total FROM comentarios";
$result_comentarios = mysqli_query($conn, $sql_comentarios);
$total_comentarios = mysqli_fetch_assoc($result_comentarios)["total"];

$sql_jogos = "SELECT COUNT(*) AS total FROM jogos";
$result_jogos = mysqli_query($conn, $sql_jogos);
$total_jogos = mysqli_fetch_assoc($result_jogos)["total"];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlayScore</title>

    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/headerfooter.css">
    <link href="https://fonts.googleapis.com/css2?family=Kode+Mono:wght@400;600&family=Abel&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
</head>

<body>

    <header class="navbar">

        <div class="logo">
            <a href="index.php"><img src="logo/Logo.png" alt="PlayScore"></a>
        </div>

        <nav class="nav-links" id="navLinks">

            <a href="index.php">Início</a>
            <a href="catalogo.php">Catalogo</a>

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
                    <a href="jogodoano.php">Jogo do Ano</a>
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

    <section class="hero">

        <img src="https://sempretopgames.com.br/wp-content/uploads/2024/10/Melhores-Jogos-de-Videogames.jpg" alt="Banner Principal" class="hero-image">

        <div class="overlay"></div>

        <div class="hero-content">
            <h1>Descobre os Melhores Jogos</h1>
            <p>Avaliações, comentários e rankings da comunidade gamer.</p>

            <button>Explorar Agora</button>
        </div>

    </section>

    <!-- MAIN -->

    <section class="banner">
        <h1>Jogos Mais Votados</h1>
    </section>

    <main class="container">

        <section class="games-section">

            <div class="slider-container">

                <button class="slider-btn left" id="prevBtn">&#10094;</button>

                <div class="games-slider" id="slider">

                    <div class="game-card">
                        <a href="jogo.php?id=2">
                            <img src="https://images.igdb.com/igdb/image/upload/t_cover_big_2x/co8yd0.jpg" alt="">
                        </a>
                    </div>

                    <div class="game-card">
                        <a href="jogo.php?id=3">
                            <img src="https://images.igdb.com/igdb/image/upload/t_cover_big_2x/cobkt6.jpg" alt="">
                        </a>
                    </div>

                    <div class="game-card">
                        <a href="jogo.php?id=4">
                            <img src="https://images.igdb.com/igdb/image/upload/t_cover_big_2x/co65ac.jpg" alt="">
                        </a>
                    </div>

                </div>

                <button class="slider-btn right" id="nextBtn">&#10095;</button>

            </div>
        </section>

        <section class="stats">

            <div class="stat-box">
                <h3>Avaliações</h3>
                <span><?php echo $total_avaliacoes; ?></span>
            </div>

            <div class="stat-box">
                <h3>Comentários</h3>
                <span><?php echo $total_comentarios; ?></span>
            </div>

            <div class="stat-box">
                <h3>Jogos</h3>
                <span><?php echo $total_jogos; ?></span>
            </div>

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
                <a href="index.php">Início</a>
                <a href="sobrenos.php">Sobre Nós</a>
                <a href="catalogo.php">Catalogo</a>
            </div>

            <div class="footer-column legal-col">
                <h3>Legalidade</h3>
                <a href="regras.php">Regras da Comunidade</a>
                <a href="politicas.php">Política de privacidade</a>
                <a href="contactos.php">Contactos</a>
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

    <script src="js/index.js"></script>
</body>

</html>