<?php
session_start();
include "conexao.php";

if (!isset($_SESSION["id"])) {
    die("Tens de iniciar sessão.");
}

$nome = $_SESSION["nome"] ?? "";
$tipo = strtolower($_SESSION["tipo_utilizador"] ?? "");

$id_utilizador = $_SESSION["id"];

$limite = 10;

$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina - 1) * $limite;

$stmt = $conn->prepare("
    SELECT j.id_jogo, j.titulo, j.capa_url
    FROM favoritos f
    INNER JOIN jogos j ON j.id_jogo = f.id_jogo
    WHERE f.id_utilizador = ?
    ORDER BY f.data_adicao DESC
    LIMIT ? OFFSET ?
");

$stmt->bind_param("iii", $id_utilizador, $limite, $inicio);
$stmt->execute();

$resultado = $stmt->get_result();
$stmt->close();

$total_stmt = $conn->prepare("
    SELECT COUNT(*) as total
    FROM favoritos
    WHERE id_utilizador = ?
");

$total_stmt->bind_param("i", $id_utilizador);
$total_stmt->execute();

$total_result = $total_stmt->get_result()->fetch_assoc();
$total_stmt->close();

$total = $total_result["total"];
$total_paginas = ceil($total / $limite);

?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favoritos</title>
    <link rel="icon" href="img/PlayScore_Icon.png">
    <link rel="stylesheet" href="css/favoritos.css">
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
            <h1>Favoritos</h1>
        </section>


        <div class="favoritos-container">

            <?php if ($resultado->num_rows > 0): ?>

                <?php while ($jogo = $resultado->fetch_assoc()): ?>

                    <a class="game-card" href="jogo.php?id=<?= $jogo["id_jogo"] ?>">

                        <div class="image-wrap">
                            <img src="<?= str_replace('../', '', $jogo["capa_url"]) ?>">
                        </div>

                        <div class="title">
                            <?= $jogo["titulo"] ?>
                        </div>

                    </a>

                <?php endwhile; ?>

            <?php else: ?>

                <p>Não tens jogos nos favoritos.</p>

            <?php endif; ?>

        </div>

        <div class="pagination">

            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>

                <a href="favoritos.php?pagina=<?= $i ?>"
                    class="<?= ($i == $pagina) ? 'active' : '' ?>">
                    <?= $i ?>
                </a>

            <?php endfor; ?>

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

    </footer>
    <div class="copyright">
        © 2026 PLAYSCORE NETWORK. TODOS OS DIREITOS RESERVADOS.
    </div>
</body>

</html>