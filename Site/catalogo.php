<?php
session_start();
include "conexao.php";
$nome = $_SESSION["nome"] ?? "";
$email = $_SESSION["email"] ?? "";
$tipo = strtolower(trim($_SESSION["tipo_utilizador"] ?? ""));

$limite_por_pagina = 12;
$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina_atual < 1) $pagina_atual = 1;
$offset = ($pagina_atual - 1) * $limite_por_pagina;

$pesquisa = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';
$filtro_genero = isset($_GET['generos']) ? array_map('intval', (array)$_GET['generos']) : [];
$ordenacao = isset($_GET['ordem']) ? $_GET['ordem'] : '';

$where_sql = "WHERE 1=1";

if (!empty($pesquisa)) {
    $where_sql .= " AND titulo LIKE '%$pesquisa%'";
}
if (!empty($filtro_genero)) {
    $generos_ids = implode(',', $filtro_genero);
    $total_selecionados = count($filtro_genero);
    
    $where_sql .= " AND id_jogo IN (
        SELECT id_jogo FROM jogo_genero
        WHERE id_genero IN ($generos_ids)
        GROUP BY id_jogo 
        HAVING COUNT(DISTINCT id_genero) = $total_selecionados
    )";
}

$order_sql = "ORDER BY id_jogo DESC";
if ($ordenacao === 'az') {
    $order_sql = "ORDER BY titulo ASC";
} elseif ($ordenacao === 'za') {
    $order_sql = "ORDER BY titulo DESC";
} elseif ($ordenacao === 'recentes') {
    $order_sql = "ORDER BY data_lancamento DESC";
}

$query_total = "SELECT COUNT(id_jogo) as total FROM jogos $where_sql";
$resultado_total = mysqli_query($conn, $query_total);
$linha_total = mysqli_fetch_assoc($resultado_total);
$total_paginas = ceil($linha_total['total'] / $limite_por_pagina);

$query_jogos = "SELECT id_jogo, titulo, capa_url FROM jogos $where_sql $order_sql LIMIT $limite_por_pagina OFFSET $offset";
$resultado_jogos = mysqli_query($conn, $query_jogos);

$query_generos = "SELECT id_genero, nome FROM generos ORDER BY nome ASC";
$resultado_generos = mysqli_query($conn, $query_generos);

function construirUrlPaginacao($pag, $q, $gen_array, $ord)
{
    $url = "?pagina=$pag&q=" . urlencode($q);
    if (!empty($gen_array)) {
        foreach ($gen_array as $gen) {
            $url .= "&generos[]=" . (int)$gen;
        }
    }
    $url .= "&ordem=$ord";
    return $url;
}
?>

<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>
    <link href="https://fonts.googleapis.com/css2?family=Kode+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/catalogo.css">
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

                <a href="sobrenos.php">Sobre Nós</a>

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

    <main class="catalogo-container">

        <h1 class="catalogo-titulo">Catálogo</h1>

        <form action="catalogo.php" method="GET" class="catalogo-ferramentas">

            <div class="pesquisa-wrapper">
                <input type="text" name="q" placeholder="Pesquisar..." value="<?= htmlspecialchars($pesquisa) ?>">
                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>

            <div class="filtros-wrapper">
                <div class="filtro-dropdown-container" id="filtro-genero-container">
                    <div class="filtro-btn" onclick="toggleDropdown(event)">
                        <span class="filtro-label">Filtro: Género<span class="seta-rosa">▼</span></span>
                    </div>
                    <div class="lista-checkbox-generos" id="dropdown-generos">
                        <?php mysqli_data_seek($resultado_generos, 0); while ($genero = mysqli_fetch_assoc($resultado_generos)): ?>
                            <div class="checkbox-opcao">
                                <input type="checkbox" name="generos[]" id="gen_<?= $genero['id_genero'] ?>" value="<?= $genero['id_genero'] ?>" <?= in_array((int)$genero['id_genero'], $filtro_genero) ? 'checked' : '' ?>>
                                <label for="gen_<?= $genero['id_genero'] ?>">
                                    <?= htmlspecialchars($genero['nome']) ?>
                                </label>
                            </div>
                        <?php endwhile; ?>
                        <button type="submit" class="btn-aplicar-filtros">Aplicar</button>
                    </div>
                </div>
                <div class="filtro-item">
                    <span class="filtro-label">Ordenar por<span class="seta-rosa">▼</span></span>
                    <select name="ordem" onchange="this.form.submit()">
                        <option value="">Padrão</option>
                        <option value="az" <?= ($ordenacao == 'az') ? 'selected' : '' ?>>A - Z</option>
                        <option value="za" <?= ($ordenacao == 'za') ? 'selected' : '' ?>>Z - A</option>
                        <option value="recentes" <?= ($ordenacao == 'recentes') ? 'selected' : '' ?>>Mais Recentes</option>
                    </select>
                </div>
            </div>
        </form>

        <div class="jogos-grid">
            <?php if (mysqli_num_rows($resultado_jogos) > 0): ?>
                <?php while ($jogo = mysqli_fetch_assoc($resultado_jogos)): ?>
                    <div class="jogo-card">
                        <a href="jogo.php?id=<?= $jogo['id_jogo'] ?>">
                            <img src="uploads/<?= htmlspecialchars($jogo['capa_url']) ?>" alt="<?= htmlspecialchars($jogo['titulo']) ?>">
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="sem-resultados">Não foram encontrados jogos com estes critérios.</p>
            <?php endif; ?>
        </div>

        <?php if ($total_paginas > 1): ?>
            <div class="paginacao">
                <?php if ($pagina_atual > 1): ?>
                    <a href="<?= construirUrlPaginacao($pagina_atual - 1, $pesquisa, $filtro_genero, $ordenacao) ?>" class="btn-paginacao">
                        <span class="seta-rosa">◄</span> Anterior
                    </a>
                <?php endif; ?>

                <span class="pagina-atual"><?= $pagina_atual ?></span>

                <?php if ($pagina_atual < $total_paginas): ?>
                    <a href="<?= construirUrlPaginacao($pagina_atual + 1, $pesquisa, $filtro_genero, $ordenacao) ?>" class="btn-paginacao">
                        Próximo <span class="seta-rosa">►</span>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

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

    <script src="js/catalogo.js"></script>
    
</body>

</html>