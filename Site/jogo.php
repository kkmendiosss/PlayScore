<?php
session_start();
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_SESSION["id"])) {
        die("Não estás logado.");
    }

    if (!isset($_POST["comentario"], $_POST["id_jogo"])) {
        die("Dados em falta.");
    }

    $id_utilizador = $_SESSION["id"];
    $id_jogo = intval($_POST["id_jogo"]);
    $comentario = trim($_POST["comentario"]);

    if ($comentario === "") {
        die("Comentário vazio.");
    }

    $stmt = $conn->prepare("
        INSERT INTO comentarios (comentario, id_utilizador, id_jogo)
        VALUES (?, ?, ?)
    ");

    if (!$stmt) {
        die("Erro prepare: " . $conn->error);
    }

    $stmt->bind_param("sii", $comentario, $id_utilizador, $id_jogo);

    if (!$stmt->execute()) {
        die("Erro execute: " . $stmt->error);
    }

    header("Location: jogo.php?id=" . $id_jogo);
    exit();
}

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
    <title><?= $jogo['titulo'] ?> - Playscore</title>

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
                    <a href="contactos.php">Contactos</a>
                    <a href="regras.php">Regras da Comunidade</a>
                    <a href="politicas.php">Politicas e privacidade</a>
                    <a href="faq.php">FAQ</a>
                </div>

            </div>

            <div class="dropdown">

                <a href="#">Informação</a>

                <div class="dropdown-content">
                    <a href="jogoano.php">Jogo do Ano</a>
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
                    alt="<?= $jogo['titulo'] ?>">

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

                <?php

                $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                if ($page < 1) $page = 1;

                $limit = 10;
                $offset = ($page - 1) * $limit;
                $stmt = $conn->prepare("SELECT c.comentario, c.data_comentario, u.nome, u.avatar_url
                    FROM comentarios c
                    JOIN users u ON c.id_utilizador = u.id_utilizador
                    WHERE c.id_jogo = ?
                    ORDER BY c.data_comentario DESC
                    LIMIT ? OFFSET ?
                ");

                $stmt->bind_param("iii", $id, $limit, $offset);
                $stmt->execute();

                $result = $stmt->get_result();

                $stmt2 = $conn->prepare("SELECT COUNT(*) as total
                    FROM comentarios
                    WHERE id_jogo = ?
                ");

                $stmt2->bind_param("i", $id);
                $stmt2->execute();

                $total = $stmt2->get_result()->fetch_assoc()['total'];

                $total_pages = ceil($total / $limit);
                ?>

                <h2>Comentários</h2>

                <section class="comments">

                    <?php if ($result->num_rows > 0) { ?>

                        <?php while ($c = $result->fetch_assoc()) { ?>

                            <div class="comment">
                                <div class="avatar">
                                    <?php if (!empty($c["avatar_url"])) { ?>
                                        <img src="<?= htmlspecialchars($c["avatar_url"]) ?>" alt="avatar">
                                    <?php } else { ?>
                                        <div class="avatar-placeholder">👤</div>
                                    <?php } ?>
                                </div>

                                <div>
                                    <h3><?= htmlspecialchars($c["nome"]) ?></h3>

                                    <p><?= nl2br(htmlspecialchars($c["comentario"])) ?></p>

                                <small>
                                    <?= date("d/m/Y H:i", strtotime($c["data_comentario"])) ?>
                                </small>
                            </div>
                        </div>

                    <?php } ?>

                <?php } else { ?>

                <p class="no-comments">
                    Ainda não existem comentários. Sê o primeiro a comentar!
                </p>

            <?php } ?>

        </section>


<?php if ($total_pages > 1) { ?>

<div class="pagination">

    <?php if ($page > 1) { ?>
        <a href="?id=<?= $id ?>&page=<?= $page - 1 ?>">← Anterior</a>
    <?php } ?>

    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>

        <a href="?id=<?= $id ?>&page=<?= $i ?>"
           class="<?= ($i == $page) ? 'active' : '' ?>">
            <?= $i ?>
        </a>

    <?php } ?>

    <?php if ($page < $total_pages) { ?>
        <a href="?id=<?= $id ?>&page=<?= $page + 1 ?>">Seguinte →</a>
    <?php } ?>

</div>

<?php } ?>


<!-- FORMULÁRIO COMENTÁRIO -->
<?php if (isset($_SESSION["id"])) { ?>

    <form method="POST" class="comment-form">
        <input type="hidden" name="id_jogo" value="<?= $id ?>">

        <textarea name="comentario" placeholder="Escreve um comentário..." required></textarea>

        <button type="submit">Enviar</button>
    </form>

<?php } else { ?>

    <p class="no-comments">
        <a href="login.php">Faz login</a> para comentar.
    </p>

<?php } ?>

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