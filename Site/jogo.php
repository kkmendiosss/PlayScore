<?php

session_start();
include "conexao.php";

$nome = $_SESSION["nome"] ?? "";
$email = $_SESSION["email"] ?? "";
$tipo = strtolower(trim($_SESSION["tipo_utilizador"] ?? ""));

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$stmt = $conn->prepare("SELECT * FROM jogos WHERE id_jogo = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $jogo = $result->fetch_assoc();

} else {
    die("Jogo não encontrado.");
}

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crimson Desert - Playscore</title>

    <link rel="stylesheet" href="css/jogo.css">
    <link rel="stylesheet" href="css/headerfooter.css">
    <link href="https://fonts.googleapis.com/css2?family=Kode+Mono:wght@400;600&family=Abel&display=swap" rel="stylesheet">
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
                    <a href="#">Contactos</a>
                    <a href="regras.html">Regras da Comunidade</a>
                    <a href="#">Politicas e privacidade</a>
                    <a href="faq.html">FAQ</a>
                </div>

            </div>

            <div class="dropdown">

                <a href="#">Informação</a>

                <div class="dropdown-content">
                    <a href="#">Jogo do Ano</a>
                    <a href="franquia.html">Franquia</a>
                    <a href="lancamentos.html">Lançamentos</a>
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

    <main>

        <section class="banner">
            <h1><?= $jogo['titulo'] ?></h1>
        </section>

        <section class="content">

            <!-- SIDEBAR -->
    <aside class="sidebar">

        <img 
            src="<?= $jogo['capa_url'] ?>" 
            class="game-cover"
            alt="<?= $jogo['titulo'] ?>"
        >

        <div class="info-box">

            <h2>Playscore</h2>

            <div class="score">
                <?= $jogo['classificacao'] ?>/5
            </div>

            <p>
                <strong>Desenvolvedor:</strong><br>
                <?= $jogo['desenvolvedor'] ?>
            </p>

            <p>
                <strong>Editor:</strong><br>
                <?= $jogo['editor'] ?>
            </p>


            <p>
                <strong>Plataforma:</strong><br>
                <?= $jogo['plataforma'] ?>
            </p>

            <p>
                <strong>Lançamento:</strong><br>
                <?= $jogo['data_lancamento'] ?>
            </p>

            <a href="#" class="favorite">Favoritar</a>

        </div>

    </aside>

            <!-- MAIN CONTENT -->
            <div class="details">

        <section class="about">

            <h2>Sobre</h2>

            <p>
                <?= $jogo['descricao'] ?>
            </p>

        </section>

        <!-- TRAILER -->
        <section class="trailer">

            <h2>Trailer</h2>

            <div class="trailer-box">

                <iframe
                    src="<?= $jogo['trailer_url'] ?>"
                    title="Trailer"
                    frameborder="0"
                    allowfullscreen>
                </iframe>

            </div>

        </section>

        <section class="comments">
                    <h2>Comentários <span>(2 comentário)</span></h2>

                    <div class="comment">
                        <div class="avatar"></div>

                        <div>
                            <h3>Joaquim Ronaldo</h3>
                            <p>
                                Gosto muito do jogo é muito Crimson e também muito Desert.
                            </p>
                        </div>
                    </div>

                    <div class="comment">
                        <div class="avatar"></div>

                        <div>
                            <h3>Carlos Sá</h3>
                            <p>
                                Teve coisas do jogo que não gostei principalmente
                                a história, mas a gameplay no geral é muito boa.
                            </p>
                        </div>
                    </div>

                </section>

    </div>

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

    <div class="copyright">
        © 2026 PLAYSCORE NETWORK. TODOS OS DIREITOS RESERVADOS.
    </div>

    <script src="jogo.js"></script>
</body>
</html>