<?php
session_start();
include "conexao.php";

$nome = $_SESSION["nome"] ?? "";
$tipo = $_SESSION["tipo_utilizador"] ?? "";

$resultado = mysqli_query($conn, "SELECT * FROM lancamentos ORDER BY data");
?>

<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>
    <link href="https://fonts.googleapis.com/css2?family=Kode+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/sobrenos.css">
    <link rel="icon" href="img/PlayScore_Icon.png">
    <link rel="stylesheet" href="css/headerfooter.css">
    <link rel="stylesheet" href="js/headerfooter.js">
</head>

<body class="fundo">

    <header class="navbar">

        <div class="logo">
            <img src="logo/Logo.png" alt="PlayScore">
        </div>

        <nav class="nav-links" id="navLinks">

            <a href="index.php">Início</a>
            <a href="catalogo.php">Catalogo</a>

            <div class="dropdown">

                <a href="#">Sobre Nós▼</a>

                <div class="dropdown-content">
                    <a href="contactos.php">Contactos</a>
                    <a href="regras.php">Regras da Comunidade</a>
                    <a href="politicas.php">Politicas de privacidade</a>
                    <a href="faq.php">FAQ</a>
                </div>

            </div>

            <div class="dropdown">

                <a href="#">Informação▼</a>

                <div class="dropdown-content">
                    <a href="jogodoano.php">Jogo do Ano</a>
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
                            <a href="admin/dashboard.php">Dashboard</a>
                        <?php } ?>

                        <a href="logout.php">Sair</a>
                    </div>

                </div>

        <?php } else { ?>

            <a href="login.php" class="btn-login">Login</a>

        <?php } ?>

        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>

    </header> 

        <main class="sobre-container">

        <section class="sobre-topo">
            <p class="sobre-label">Sobre &gt; Sobre Nós V1 / Equipa</p>

            <h1>Sobre a Elite</h1>

            <p class="sobre-subtitulo">
                Esta não é apenas força da PlayScore. Conheça os arquitetos do conhecimento competitivo.
                A força do nosso top 10 altera a comunidade. Encontra-se aqui tudo.
            </p>
        </section>

        <section class="missao-card">

            <div class="missao-titulo">
                <span>A nossa missão //</span>
                <strong>O objetivo final</strong>
            </div>

            <div class="missao-conteudo">


                <div class="missao-texto">
                    <p>
                        Desenvolver ferramentas, algoritmos métricos validados pelos nossos K/D,
                        mapas e ranking. Utilizar a PlayScore para criar uma análise imparcial
                        para a indústria competitiva.
                    </p>

                    <ul>
                        <li>Acesso estatístico, play pools e cálculos pro.</li>
                        <li>Análise detalhada para ti e para a tua equipa.</li>
                        <li>Conduzir para eventos, parcerias pro e um versus justo.</li>
                    </ul>
                </div>

            </div>

        </section>

        <section class="equipa">

            <div class="membro">
                <img src="img/equipa/IMG_20260318_154255.jpg" alt="João Mendes">
                <h3>João Verdes</h3>
            </div>

            <div class="membro">
                <img src="img/equipa/20240901_154029.jpg" alt="Samuel Cardoso">
                <h3>Samuel Cardoso</h3>
            </div>

            <div class="membro">
                <img src="img/equipa/IMG-20250820-WA0002.jpg" alt="Rodrigo Ramos">
                <h3>Rodrigo Ramos</h3>
            </div>

            <div class="membro">
                <img src="img/equipa/Fotografia.jpg" alt="João Santos">
                <h3>João Santos</h3>
            </div>

        </section>

    </main>

    <script src="js/headerfooter.js"></script>
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
                <a href="regras.html">Regras da Comunidade</a>
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

    <script src="/js/headerfooter.js"></script>
</body>
</html>