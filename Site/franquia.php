<?php
session_start();
include "conexao.php";
$nome = $_SESSION["nome"] ?? "";
$email = $_SESSION["email"] ?? "";
$tipo = strtolower(trim($_SESSION["tipo_utilizador"] ?? ""));
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlayScore | Expansão de Franquia & Negócios</title>
    <link rel="stylesheet" href="css/headerfooter.css">
    <link rel="stylesheet" href="css/franquia.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kode+Mono&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
    <link rel="icon" href="img/PlayScore_Icon.png">
</head>

<body>

    <header class="navbar">

        <div class="logo">
            <img src="logo/Logo.png" alt="PlayScore">
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


    <div class="page-wrapper">

        <header class="franchise-header">
            <h1>EXPANSÃO DE FRANQUIA</h1>
            <p>Seja dono de um nó oficial da rede PlayScore. Implemente a tecnologia de rating na sua região.</p>
        </header>

        <section class="portfolio-section">
            <h2>PORTFÓLIO DE JOGOS</h2>
            <div class="games-container">
                <div class="game-card">
                    <img src="img/Franquia/FZ.jpg" alt="Forza">
                    <h4>Forza</h4>
                </div>
                <div class="game-card">
                    <img src="img/Franquia/Capa_de_Forza_Horizon_2.png" alt="Forza 2">
                    <h4>Forza 2</h4>
                </div>
                <div class="game-card">
                    <img src="img/Franquia/Capa_de_Forza_Horizon_3.jpeg" alt="Forza 3">
                    <h4>Forza 3</h4>
                </div>
            </div>
        </section>

        <div class="info-grid">
            <div class="info-card">
                <h3>O QUE OFERECEMOS</h3>
                <ul>
                    <li>Direito de uso exclusivo do Algoritmo Heurístico V4.0.</li>
                    <li>Proteção de território.</li>
                    <li>Suporte técnico operacional.</li>
                </ul>
            </div>

            <div class="info-card">
                <h3>ROI ESTIMADO</h3>
                <p>Retorno de Investimento previsto entre 12 a 18 meses, com margem líquida superior a 25%.</p>
            </div>

            <div class="info-card">
                <h3>ESTRUTURA FÍSICA</h3>
                <p>Projetos arquitetónicos modulares para Lounges de Performance e Centros de Dados.</p>
            </div>

            <div class="info-card">
                <h3>VANTAGENS DO FRANQUEADO</h3>
                <p>Acesso ao Marketplace de Dados global e software de gestão proprietário.</p>
            </div>
        </div>



    </div>
    </div>
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
    <script src="js/headerfooter.js"></script>
</body>

</html>