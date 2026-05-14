<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlayScore</title>

    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/headerfooter.css">
  <link href="https://fonts.googleapis.com/css2?family=Kode+Mono:wght@400;600&family=Abel&display=swap" rel="stylesheet">
</head>
<body>

    <header class="navbar">
        <div class="logo">
            <img src="logo/Logo.png" alt="PlayScore">
        </div>

        <nav class="nav-links" id="navLinks">
            <a href="#Home">Início</a>
            <a href="#Catalogo">Catalogo</a>

            <div class="dropdown">
                <a href="#SobreNos">Sobre Nós</a>
                <div class="dropdown-content">
                    <a href="contactos.php">Contactos</a>
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
                    <a href="lancamentos.html">Lançamentos </a>
                </div>
            </div>
        </nav>

        <button onclick="window.location.href='login.php'" class="btn-login" >Login</button>

        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </header>

    <section class="hero">
    
        <img src="https://media.gq-magazine.co.uk/photos/645b5c3c8223a5c3801b8b26/16:9/w_1920,c_limit/100-best-games-hp-b.jpg" alt="Banner Principal" class="hero-image">

        <div class="overlay"></div>

        <div class="hero-content">
            <h1>Descobre os Melhores Jogos</h1>
            <p>Avaliações, comentários e rankings da comunidade gamer.</p>

            <button>Explorar Agora</button>
        </div>

    </section>

    <!-- MAIN -->
    <main class="container">

        <section class="games-section">
            <h2>Jogos Mais Votados</h2>

            <div class="slider-container">

                <button class="slider-btn left" id="prevBtn">&#10094;</button>

                <div class="games-slider" id="slider">

                    <div class="game-card">
                        <img src="https://upload.wikimedia.org/wikipedia/en/4/4f/Forza_Horizon_6_cover.jpg" alt="">
                    </div>

                    <div class="game-card">
                        <img src="https://upload.wikimedia.org/wikipedia/en/0/03/Resident_Evil_Requiem.jpg" alt="">
                    </div>

                    <div class="game-card">
                        <img src="https://upload.wikimedia.org/wikipedia/en/8/89/Pragmata_cover.jpg" alt="">
                    </div>

                    <div class="game-card">
                        <img src="https://upload.wikimedia.org/wikipedia/en/3/3e/Fable_cover_art.jpg" alt="">
                    </div>

                    <div class="game-card">
                        <img src="https://images.igdb.com/igdb/image/upload/t_cover_big/co5vmg.jpg" alt="">
                    </div>

                </div>

                <button class="slider-btn right" id="nextBtn">&#10095;</button>

            </div>
        </section>

        <!-- STATS -->
        <section class="stats">
            <div class="stat-box">
                <h3>Avaliações</h3>
                <span>000</span>
            </div>

            <div class="stat-box">
                <h3>Comentários</h3>
                <span>000</span>
            </div>

            <div class="stat-box">
                <h3>Jogos</h3>
                <span>000</span>
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
                <a href="#">Início</a>
                <a href="#">Sobre Nós</a>
                <a href="#">Catalogo</a>
            </div>

            <div class="footer-column legal-col">
                <h3>Legalidade</h3>
                <a href="#">Regras da Comunidade</a>
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

    <script src="js/index.js"></script>
</body>
</html>