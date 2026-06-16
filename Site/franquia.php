<?php
session_start();
include "conexao.php";

$nome = $_SESSION["nome"] ?? "";
$tipo = strtolower(trim($_SESSION["tipo_utilizador"] ?? ""));

$id_franquia = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_franquia <= 0) {
    $res_primeira = $conn->query("SELECT id_franquia FROM franquias ORDER BY id_franquia ASC LIMIT 1");

    if ($res_primeira && $res_primeira->num_rows > 0) {
        $id_franquia = (int)$res_primeira->fetch_assoc()['id_franquia'];
    }
}

$ordem = $_GET['ordem'] ?? 'recentes';

switch ($ordem) {
    case 'antigos':
        $orderBy = "data_lancamento ASC";
        break;

    case 'rating':
        $orderBy = "(soma_classificacao / NULLIF(num_votos, 0)) DESC";
        break;

    default:
        $ordem = 'recentes';
        $orderBy = "data_lancamento DESC";
        break;
}

$stmt = $conn->prepare("SELECT * FROM franquias WHERE id_franquia = ?");
$stmt->bind_param("i", $id_franquia);
$stmt->execute();
$franquia = $stmt->get_result()->fetch_assoc();
$stmt->close();

$stmt_jogos = $conn->prepare("SELECT * FROM jogos WHERE id_franquia = ? ORDER BY $orderBy");
$stmt_jogos->bind_param("i", $id_franquia);
$stmt_jogos->execute();
$jogos = $stmt_jogos->get_result();
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlayScore | Franquia</title>

    <link rel="stylesheet" href="css/headerfooter.css">
    <link rel="stylesheet" href="css/franquia.css">
    <link rel="icon" href="img/PlayScore_Icon.png">
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
                <button class="btn-login"><?php echo htmlspecialchars($nome); ?> ▼</button>
                <div class="user-dropdown-content">
                    <a href="perfil.php">Perfil</a>
                    <?php if ($tipo == "admin") { ?>
                        <a href="admin/dashboard.php">Dashboard</a>
                    <?php } ?>
                    <a href="logout.php">Sair</a>
                </div>
            </div>
        <?php } else { ?>
            <a href="login.php"><button class="btn-login">Login</button></a>
        <?php } ?>

        <div class="hamburger" id="hamburger">
            <span></span><span></span><span></span>
        </div>
    </header>

    <main class="franquia-page">

        <?php if ($franquia) { ?>

            <section class="franquia-topo">
                <div class="franquia-imagem">
                    <?php if (!empty($franquia['capa_url'])) { ?>
                        <img src="<?php echo htmlspecialchars($franquia['capa_url']); ?>" alt="<?php echo htmlspecialchars($franquia['nome']); ?>">
                    <?php } else { ?>
                        <div class="placeholder-img">Imagem</div>
                    <?php } ?>
                </div>

                <div class="franquia-info">
                    <h1><?php echo htmlspecialchars($franquia['nome']); ?></h1>

                    <div class="franquia-meta">

                        <span>🎮 <?php echo $jogos->num_rows; ?> jogos</span>

                        <span>📅
                            <?php
                            $datas = $conn->query(
                                "
        SELECT 
            MIN(data_lancamento) AS primeira,
            MAX(data_lancamento) AS ultima
        FROM jogos
        WHERE id_franquia = " . (int)$id_franquia
                            );

                            if ($datas) {
                                $d = $datas->fetch_assoc();

                                if ($d['primeira']) {
                                    echo date("Y", strtotime($d['primeira'])) . " - ";

                                    if ($d['ultima'] && $d['ultima'] != $d['primeira']) {
                                        echo date("Y", strtotime($d['ultima']));
                                    } else {
                                        echo "Presente";
                                    }
                                } else {
                                    echo "Sem dados";
                                }
                            }
                            ?>
                        </span>

                        <span>🏷️
                            <?php
                            $generos = $conn->query("
    SELECT DISTINCT g.nome
    FROM jogos j
    JOIN generos g ON j.id_genero = g.id_genero
    WHERE j.id_franquia = $id_franquia
    LIMIT 3
");

                            $lista = [];

                            while ($g = $generos->fetch_assoc()) {
                                if (!empty($g['genero'])) {
                                    $lista[] = $g['genero'];
                                }
                            }

                            echo !empty($lista) ? implode(", ", $lista) : "Sem género";
                            ?>
                        </span>

                    </div>

                    <p><?php echo htmlspecialchars($franquia['descricao']); ?></p>
                </div>
            </section>

            <section class="jogos-franquia">
                <h2>Jogos da Franquia</h2>

                <div class="filtros">
                    <select>
                        <option>Ordenar por: Mais recentes</option>
                        <option>Mais antigos</option>
                        <option>Melhor classificação</option>
                    </select>

                </div>

                <div class="jogos-grid">
                    <?php if ($jogos && $jogos->num_rows > 0) { ?>
                        <?php while ($jogo = $jogos->fetch_assoc()) { ?>

                            <?php
                            $id_jogo = $jogo['id'] ?? $jogo['id_jogo'] ?? 0;
                            ?>

                            <article class="jogo-card">
                                <div class="jogo-img">
                                    <?php if (!empty($jogo['capa_url'])) { ?>
                                        <img src="<?php echo htmlspecialchars($jogo['capa_url']); ?>" alt="<?php echo htmlspecialchars($jogo['titulo']); ?>">
                                    <?php } else { ?>
                                        <div class="placeholder-img">Imagem</div>
                                    <?php } ?>
                                </div>

                                <div class="jogo-conteudo">
                                    <h3><?php echo htmlspecialchars($jogo['titulo']); ?></h3>

                                    <p> <?php echo !empty($jogo['data_lancamento']) ? date("Y", strtotime($jogo['data_lancamento'])) : "Sem data"; ?></p>



                                    <p>
                                        ⭐
                                        <?php
                                        $num_votos = (int)($jogo['num_votos'] ?? 0);
                                        $soma = (float)($jogo['soma_classificacao'] ?? 0);

                                        echo $num_votos > 0 ? round($soma / $num_votos, 1) : "0";
                                        ?>
                                        (<?php echo $num_votos; ?> votos)
                                    </p>

                                    <a href="jogo.php?id=<?php echo $id_jogo; ?>" class="btn-ver-jogo">
                                        Ver jogo
                                    </a>
                                </div>
                            </article>

                        <?php } ?>
                    <?php } else { ?>
                        <p class="sem-jogos">Ainda não existem jogos ligados a esta franquia.</p>
                    <?php } ?>
                </div>
            </section>

        <?php } else { ?>
            <p class="sem-jogos">Nenhuma franquia encontrada.</p>
        <?php } ?>

    </main>

    <footer>
        <div class="footer-bottom">
            <p>© 2026 PLAYSCORE NETWORK. TODOS OS DIREITOS RESERVADOS.</p>
        </div>
    </footer>

    <script src="js/headerfooter.js"></script>

</body>

</html>