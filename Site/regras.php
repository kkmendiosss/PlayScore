<?php
session_start();
include "conexao.php";
$nome = $_SESSION["nome"] ?? "";
$email = $_SESSION["email"] ?? "";
$tipo = strtolower(trim($_SESSION["tipo_utilizador"] ?? ""));
?>
<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regras da Comunidade</title>
    <link href="https://fonts.googleapis.com/css2?family=Kode+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/regras.css">
    <link rel="icon" href="img/PlayScore_Icon.png">
    <link rel="stylesheet" href="css/headerfooter.css">
    <link rel="stylesheet" href="js/headerfooter.js">
</head>

<body>

    <header class="navbar">

        <div class="logo">
            <img src="logo/Logo.png" alt="PlayScore">
        </div>

        <nav class="nav-links" id="navLinks">

            <a href="index.php">Início</a>
            <a href="catalogo.php">Catálogo</a>

            <div class="dropdown">
                <a href="#">Sobre Nós</a>

                <div class="dropdown-content">
                    <a href="contactos.php">Contactos</a>
                    <a href="regras.php">Regras da Comunidade</a>
                    <a href="politicas.php">Políticas e Privacidade</a>
                    <a href="faq.php">FAQ</a>
                </div>
            </div>

            <div class="dropdown">
                <a href="#">Informação</a>

                <div class="dropdown-content">
                    <a href="jogodoano.php">Jogo do Ano</a>
                    <a href="lancamentos.php">Lançamentos</a>
                </div>
            </div>

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

        </nav>

        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>

    </header>

    <div class="main-title">
        <h1>Regras da Comunidade</h1>
    </div>

    <main class="rules-container">
        <div class="rules-grid">
            <div class="rule-card card-blue">
                <img src="img/Regras/Icon1.png" alt="Ícone 1" class="rule-icon">
                <p>Sê respeitoso. Não toleramos assédio, ataques pessoais ou qualquer discurso de ódio. Mantém a toxicidade fora do jogo.</p>
            </div>
            <div class="rule-card card-pink">
                <img src="img/Regras/Icon2.png" alt="Ícone 2" class="rule-icon">
                <p>Não partilhes links para conteúdo ilegal ou pirateado. Respeita os direitos de autor e a segurança da comunidade.</p>
            </div>
            <div class="rule-card card-pink">
                <img src="img/Regras/Icon3.png" alt="Ícone 3" class="rule-icon">
                <p>Escreve as tuas próprias reviews. Plágio e textos gerados por IA são proibidos. Queremos opiniões reais de pessoas reais.</p>
            </div>
            <div class="rule-card card-blue">
                <img src="img/Regras/Icon4.png" alt="Ícone 4" class="rule-icon">
                <p>Usa a tag de "Spoiler" em qualquer detalhe importante da história. Não estragues a experiência aos outros jogadores.</p>
            </div>
            <div class="rule-card card-blue">
                <img src="img/Regras/Icon5.png" alt="Ícone 5" class="rule-icon">
                <p>Mantém as reviews e comentários sobre o jogo. Evita dramas da comunidade ou discussões fora de contexto.</p>
            </div>
            <div class="rule-card card-pink">
                <img src="img/Regras/Icon6.png" alt="Ícone 6" class="rule-icon">
                <p>Não uses o site para publicidade ou para ganhar tráfego noutras redes. Links sem conteúdo útil serão removidos.</p>
            </div>
            <div class="rule-card card-pink">
                <img src="img/Regras/Icon7.png" alt="Ícone 7" class="rule-icon">
                <p>Explica o porquê da tua nota. Reviews vazias ou de quem admite não ter jogado o título serão eliminadas.</p>
            </div>
            <div class="rule-card card-blue">
                <img src="img/Regras/Icon8.png" alt="Ícone 8" class="rule-icon">
                <p>Viste algo errado? Denuncia. Avisos e infrações repetidas podem levar à suspensão ou expulsão permanente da conta.</p>
            </div>
        </div>
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
</body>

</html>