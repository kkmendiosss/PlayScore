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
    <link rel="stylesheet" href="css/contactos.css">
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
            <a href="#Home">Início</a>
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
                    <a href="lancamentos.html">Lançamentos </a>
                </div>
            </div>
        </nav>

        <button class="btn-login">Login</button>

        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </header>

    <div class="page-wrapper">
    
    <header class="page-header">
        <h1>REDE DE CONEXÃO // CONTACTOS</h1>
        <p>A elite não apenas joga, ela domina a comunicação. Estamos aqui para responder aos teus tickets.</p>
    </header>

    <div class="contact-container">
        
        <div class="contact-info">
            <h3>CANAIS DIRETOS DA ELITE</h3>
            <p><strong>Hub Técnico:</strong> tech@playscore.net</p>
            <p><strong>Parcerias:</strong> partnerships@playscore.net</p>
            <p><strong>Franquias:</strong> franchise@playscore.net</p>
            <br>
            <p><strong>Suporte Real-Time:</strong> #tech-support (via Discord)</p>
            <br>
            <p><strong>Localização Física (Lounges):</strong><br>
            Lisboa & Porto, Portugal</p>
        </div>

        <div class="contact-form-box">
            <h3>SUBMISSÃO DE TICKET V4.1</h3>
            
            <form action="processar_contacto.php" method="POST">
                
                <div class="form-group">
                    <label for="nome">Nome de Identificação</label>
                    <input type="text" id="nome" name="nome" required placeholder="Insere o teu nome">
                </div>

                <div class="form-group">
                    <label for="email">Email de Performance</label>
                    <input type="email" id="email" name="email" required placeholder="email@exemplo.com">
                </div>

                <div class="form-group">
                    <label for="mensagem">Mensagem</label>
                    <textarea id="mensagem" name="mensagem" rows="5" required placeholder="Descreve a tua questão aqui..."></textarea>
                </div>

                <button type="submit" class="submit-btn">SUBMETER TICKET</button>
            </form>
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
<script src="js/headerfooter.js"></script>
</body>
</html>