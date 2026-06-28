<?php
session_start();
include "conexao.php";
$nome = $_SESSION["nome"] ?? "";
$email = $_SESSION["email"] ?? "";
$tipo = strtolower(trim($_SESSION["tipo_utilizador"] ?? ""));

$id_utilizador = $_SESSION["id"] ?? null; 

$ano_selecionado = isset($_GET['ano']) ? (int)$_GET['ano'] : 2026;

$voto_atual_titulo = "";
if ($id_utilizador) {
    $query_voto = "SELECT j.titulo FROM votos_utilizadores_ano v 
                   JOIN jogos j ON v.id_jogo = j.id_jogo 
                   WHERE v.id_utilizador = $id_utilizador AND v.ano = $ano_selecionado";
    $resultado_voto = mysqli_query($conn, $query_voto);
    if ($resultado_voto && mysqli_num_rows($resultado_voto) > 0) {
        $linha_voto = mysqli_fetch_assoc($resultado_voto);
        $voto_atual_titulo = $linha_voto['titulo'];
    }
}

$query_resultados = "SELECT j.id_jogo, j.titulo, j.capa_url, ja.num_votos 
                     FROM jogo_do_ano ja
                     JOIN jogos j ON ja.id_jogo = j.id_jogo
                     WHERE ja.ano = $ano_selecionado AND ja.num_votos > 0
                     ORDER BY ja.num_votos DESC";
$resultados_top = mysqli_query($conn, $query_resultados);
$jogos_top = [];
if ($resultados_top) {
    while ($row = mysqli_fetch_assoc($resultados_top)) {
        $jogos_top[] = $row;
    }
}

$query_jogos_ano = "SELECT id_jogo, titulo FROM jogos WHERE YEAR(data_lancamento) = $ano_selecionado ORDER BY titulo ASC";
$resultado_jogos_ano = mysqli_query($conn, $query_jogos_ano);
$jogos_para_pesquisa = [];
if ($resultado_jogos_ano) {
    while ($row = mysqli_fetch_assoc($resultado_jogos_ano)) {
        $jogos_para_pesquisa[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jogo do Ano</title>
    <link href="https://fonts.googleapis.com/css2?family=Kode+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/jogodoano.css">
    <link rel="icon" href="img/PlayScore_Icon.png">
    <link rel="stylesheet" href="css/headerfooter.css">
    <link rel="stylesheet" href="js/headerfooter.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

    <div class="main-title">
        <h1>Jogo do Ano</h1>
    </div>

    <main class="jda-container">

        <div class="jda-seletor-ano">
            <label>Escolhe o Ano: </label>
            <div class="custom-select-wrapper">
                <select id="selectAno" onchange="mudarAno(this.value)">
                    <?php 
                    for ($a = 2026; $a >= 2004; $a--) {
                        $selected = ($a == $ano_selecionado) ? 'selected' : '';
                        echo "<option value='$a' $selected>$a</option>";
                    }
                    ?>
                </select>
                <i class="fa-solid fa-caret-down seta-rosa"></i>
            </div>
        </div>

        <div class="jda-votacao-area">
            <h2 class="jda-pergunta">
                Qual é o teu Jogo do Ano de <span class="destaque-rosa"><?= $ano_selecionado ?></span> ?
            </h2>
            
            <?php if ($voto_atual_titulo != ""): ?>
                <p class="voto-atual-texto">O teu voto atual: <span class="destaque-cyan"><?= htmlspecialchars($voto_atual_titulo) ?></span></p>
            <?php endif; ?>

            <div class="jda-pesquisa-wrapper" id="pesquisaWrapper">
                <input type="text" id="inputPesquisa" placeholder="Procurar jogo para votar ..." autocomplete="off" <?= !$id_utilizador ? 'disabled' : '' ?>>
                <i class="fa-solid fa-magnifying-glass icone-lupa"></i>
                
                <div class="jda-resultados-pesquisa" id="dropdownPesquisa"></div>
            </div>
            
            <?php if (!$id_utilizador): ?>
                <p class="nota-votacao" style="color:#ff4444;">Tens de iniciar sessão para poderes votar.</p>
            <?php else: ?>
                <p class="nota-votacao">Nota: "Podes alterar o teu voto a qualquer momento votando num novo jogo."</p>
            <?php endif; ?>
        </div>

        <div class="jda-resultados-area">
            <h2 class="jda-titulo-resultados">
                Resultados de <span class="destaque-rosa"><?= $ano_selecionado ?></span>
            </h2>

            <div class="jda-podio-grid">
                <?php if (count($jogos_top) > 0): ?>
                    <?php foreach ($jogos_top as $index => $jogo): ?>
                        <?php 
                            $classe_podio = "lugar-outros";
                            if ($index == 0) $classe_podio = "lugar-1";
                            elseif ($index == 1) $classe_podio = "lugar-2";
                            elseif ($index == 2) $classe_podio = "lugar-3";
                        ?>
                        <div class="jogo-podio-card <?= $classe_podio ?>">
                            <img src="uploads/<?= htmlspecialchars($jogo['capa_url']) ?>" alt="<?= htmlspecialchars($jogo['titulo']) ?>" class="capa-podio">
                            <p class="votos-texto"><?= $jogo['num_votos'] ?> votos</p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: white; font-family: 'Kode Mono'; text-align:center; width:100%;">Ainda não há votos registados para este ano.</p>
                <?php endif; ?>
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

    <script>
        const jogosDoAno = <?= json_encode($jogos_para_pesquisa) ?>;
    </script>
    <script src="js/jogodoano.js"></script>
</body>
</html>