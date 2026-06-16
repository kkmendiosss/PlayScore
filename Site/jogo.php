<?php
session_start();
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["comentario"])) {

    if (!isset($_SESSION["id"])) {
        die("Não estás logado.");
    }

    if (!isset($_POST["id_jogo"])) {
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

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["classificacao"])) {

    if (!isset($_SESSION["id"])) {
        die("Tens de estar logado.");
    }

    $id_utilizador = $_SESSION["id"];
    $id_jogo = intval($_POST["id_jogo"]);
    $voto = intval($_POST["classificacao"]);

    if ($voto < 1 || $voto > 5) {
        die("Voto inválido.");
    }

    // 🔥 VERIFICAR SE JÁ VOTOU
    $check = $conn->prepare("
        SELECT id 
        FROM avaliacoes 
        WHERE id_utilizador = ? AND id_jogo = ?
    ");
    $check->bind_param("ii", $id_utilizador, $id_jogo);
    $check->execute();
    $exists = $check->get_result()->fetch_assoc();

    if ($exists) {

        $stmt = $conn->prepare("
            UPDATE avaliacoes 
            SET classificacao = ?
            WHERE id_utilizador = ? AND id_jogo = ?
        ");
        $stmt->bind_param("iii", $voto, $id_utilizador, $id_jogo);
        $stmt->execute();
    } else {

        $stmt = $conn->prepare("
            INSERT INTO avaliacoes (id_utilizador, id_jogo, classificacao)
            VALUES (?, ?, ?)
        ");
        $stmt->bind_param("iii", $id_utilizador, $id_jogo, $voto);
        $stmt->execute();
    }

    $avg = $conn->prepare("
        SELECT AVG(classificacao) AS media, COUNT(*) AS total
        FROM avaliacoes
        WHERE id_jogo = ?
    ");
    $avg->bind_param("i", $id_jogo);
    $avg->execute();
    $data = $avg->get_result()->fetch_assoc();

    $media = $data["media"];
    $total = $data["total"];

    $update = $conn->prepare("
        UPDATE jogos 
        SET classificacao = ?, num_votos = ?
        WHERE id_jogo = ?
    ");
    $update->bind_param("dii", $media, $total, $id_jogo);
    $update->execute();

    header("Location: jogo.php?id=" . $id_jogo . "&rated=1");
    exit();
}

$nome = $_SESSION["nome"] ?? "";
$email = $_SESSION["email"] ?? "";
$tipo = strtolower(trim($_SESSION["tipo_utilizador"] ?? ""));

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$stmt_jogo = $conn->prepare("
    SELECT *
    FROM jogos
    WHERE id_jogo = ?
");

$stmt_jogo->bind_param("i", $id);
$stmt_jogo->execute();
$result = $stmt_jogo->get_result();

if ($result->num_rows > 0) {
    $jogo = $result->fetch_assoc();
} else {
    die("Jogo não encontrado.");
}

$generos = [];

$stmt_gen = $conn->prepare("
    SELECT g.nome
    FROM generos g
    INNER JOIN jogo_genero jg ON g.id_genero = jg.id_genero
    WHERE jg.id_jogo = ?
");

$stmt_gen->bind_param("i", $id);
$stmt_gen->execute();

$res_gen = $stmt_gen->get_result();

while ($row = $res_gen->fetch_assoc()) {
    $generos[] = $row["nome"];
}

$user_vote = null;

if (isset($_SESSION["id"])) {

    $stmt_vote = $conn->prepare("
        SELECT classificacao 
        FROM avaliacoes 
        WHERE id_utilizador = ? AND id_jogo = ?
    ");

    $stmt_vote->bind_param("ii", $_SESSION["id"], $id);
    $stmt_vote->execute();

    $res = $stmt_vote->get_result()->fetch_assoc();

    if ($res) {
        $user_vote = $res["classificacao"];
    }
}

if (!$jogo) {
    die("Jogo não encontrado (ID: $id)");
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
                        <a href="/admin/dashboard.php">Dashboard</a>
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
                <a class="btn-franquia" href="franquia.php?id=<?php echo $jogo['id_franquia']; ?>">
                    Ver franquia
                </a>
                <img
                    src="<?= $jogo['capa_url'] ?>"
                    class="game-cover"
                    alt="<?= $jogo['titulo'] ?>">

                <div class="info-box">

                    <h2>Playscore</h2>

                    <div class="rating-box">

                        <div class="rating-info">
                            ⭐ <strong><?= number_format($jogo['classificacao'] ?? 0, 1) ?></strong>/5
                            <span>(<?= $jogo['num_votos'] ?> votos)</span>
                        </div>

                        <form method="POST" action="jogo.php?id=<?= $jogo['id_jogo'] ?>">

                            <input type="hidden" name="id_jogo" value="<?= $jogo['id_jogo'] ?>">

                            <div class="stars">

                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                    <input
                                        type="radio"
                                        name="classificacao"
                                        value="<?= $i ?>"
                                        id="star<?= $i ?>"
                                        <?= ($user_vote == $i) ? 'checked' : '' ?>>
                                    <label for="star<?= $i ?>">★</label>
                                <?php endfor; ?>

                            </div>

                            <button type="submit">Guardar avaliação</button>

                        </form>
                    </div>

                    <div id="toast" class="toast">Avaliação guardada!</div>

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

                    <p class="generos-line">
                        <strong>Género:</strong>
                        <span class="generos-tags">
                            <?= !empty($generos) ? implode(", ", $generos) : "Sem género" ?>
                        </span>
                    </p>

                    <a href="#" class="favorite">Favoritar</a>

                </div>

            </aside>

            <div class="details">

                <section class="about">

                    <h2>Sobre</h2>

                    <p>
                        <?= $jogo['descricao'] ?>
                    </p>

                </section>

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

    <div class="copyright">
        © 2026 PLAYSCORE NETWORK. TODOS OS DIREITOS RESERVADOS.
    </div>

    <script src="js/jogo.js"></script>
</body>

</html>