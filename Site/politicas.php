<?php
session_start();
include "conexao.php";

$nome = $_SESSION["nome"] ?? "";
$tipo = $_SESSION["tipo_utilizador"] ?? "";

$resultado = mysqli_query($conn, "SELECT * FROM lancamentos ORDER BY data");
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlayScore - Lançamentos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kode+Mono&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/politicas.css">
    <link rel="stylesheet" href="css/headerfooter.css">
    <link rel="icon" href="img/PlayScore_Icon.png">
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


    <section class="hero">
        <h1 class="title">Politicas de Privacidade</h1>
    </section>

    <section class="politicas-container">

        <div class="politica-card">
            <h2>1. Dados que recolhemos</h2>
            <p>Podemos recolher os seguintes dados:</p>

            <ul>
                <li>Dados fornecidos pelo utilizador, como nome, endereço de email ou outras informações ao criar conta, avaliar jogos ou deixar comentários.</li>
                <li>Dados de utilização, incluindo informações sobre como utiliza o site, páginas visitadas e interações realizadas.</li>
                <li>Dados técnicos, como endereço IP, tipo de dispositivo, navegador e sistema operativo.</li>
                <li>Cookies, pequenos ficheiros armazenados no dispositivo para melhorar a experiência de navegação.</li>
            </ul>
        </div>

        <div class="politica-card">
            <h2>2. Finalidade da utilização dos dados</h2>
            <p>Os dados recolhidos são utilizados para:</p>

            <ul>
                <li>Permitir a utilização das funcionalidades do site (avaliações, comentários, etc.).</li>
                <li>Melhorar o desempenho e o conteúdo do PlayScore.</li>
                <li>Personalizar a experiência do utilizador.</li>
                <li>Comunicar com os utilizadores, quando necessário.</li>
                <li>Garantir a segurança da plataforma e prevenir utilizações indevidas.</li>
            </ul>
        </div>

        <div class="politica-card">
            <h2>3. Partilha de dados</h2>
            <p>O PlayScore não vende nem cede os seus dados pessoais a terceiros, exceto:</p>

            <ul>
                <li>Quando exigido por lei.</li>
                <li>A prestadores de serviços (ex.: alojamento web e ferramentas de análise) que tratam os dados em nosso nome e com garantias de proteção.</li>
                <li>Para proteção dos direitos, propriedade ou segurança do PlayScore e dos seus utilizadores.</li>
            </ul>
        </div>

        <div class="politica-card">
            <h2>4. Utilização de cookies</h2>
            <p>Utilizamos cookies para:</p>

            <ul>
                <li>Guardar preferências do utilizador.</li>
                <li>Analisar o tráfego do website.</li>
                <li>Melhorar a funcionalidade e o desempenho.</li>
            </ul>

            <p>Pode configurar o seu navegador para recusar cookies, mas isso poderá afetar o funcionamento do site.</p>
        </div>

        <div class="politica-card">
            <h2>5. Segurança dos dados</h2>

            <p>
                Implementamos medidas técnicas e organizativas adequadas para proteger os seus dados pessoais
                contra perda, acesso não autorizado ou divulgação indevida. Ainda assim, nenhum sistema é
                completamente seguro.
            </p>
        </div>

        <div class="politica-card">
            <h2>6. Direitos do titular dos dados</h2>

            <p>Nos termos do Regulamento Geral sobre a Proteção de Dados (RGPD), tem direito a:</p>

            <ul>
                <li>Aceder aos seus dados pessoais.</li>
                <li>Solicitar a sua retificação ou eliminação.</li>
                <li>Limitar ou opor-se ao tratamento dos dados.</li>
                <li>Retirar o consentimento, quando aplicável.</li>
                <li>Apresentar reclamação junto da autoridade de controlo (em Portugal, a CNPD).</li>
            </ul>
        </div>

        <div class="politica-card">
            <h2>7. Ligações a sites de terceiros</h2>

            <p>
                O nosso website pode conter ligações para outros sites. O PlayScore não se responsabiliza
                pelas práticas de privacidade desses websites.
            </p>
        </div>

        <div class="politica-card">
            <h2>8. Alterações à Política de Privacidade</h2>

            <p>
                Reservamo-nos o direito de atualizar esta Política de Privacidade a qualquer momento.
                Recomendamos a consulta regular desta página.
            </p>
        </div>

    </section>
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