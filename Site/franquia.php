    <?php
    session_start();
    include "conexao.php";

    function imagemUrl($caminho, $pastasPossiveis = [])
    {
        $caminho = trim($caminho ?? "");

        if ($caminho === "") {
            return "";
        }

        $caminho = str_replace("\\", "/", $caminho);

        while (substr($caminho, 0, 3) === "../") {
            $caminho = substr($caminho, 3);
        }

        while (substr($caminho, 0, 2) === "./") {
            $caminho = substr($caminho, 2);
        }

        $caminho = ltrim($caminho, "/");

        $posImg = strpos($caminho, "img/");
        if ($posImg !== false) {
            $caminho = substr($caminho, $posImg);
        }

        if (file_exists(__DIR__ . "/" . $caminho)) {
            return $caminho;
        }

        $nomeFicheiro = basename($caminho);

        foreach ($pastasPossiveis as $pasta) {
            $pasta = trim($pasta, "/");
            $tentativa = $pasta . "/" . $nomeFicheiro;

            if (file_exists(__DIR__ . "/" . $tentativa)) {
                return $tentativa;
            }
        }

        return "";
    }

    $nome = $_SESSION["nome"] ?? "";
    $tipo = strtolower(trim($_SESSION["tipo_utilizador"] ?? ""));

    $id_franquia = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

    if ($id_franquia <= 0) {
        $res_primeira = $conn->query("SELECT id_franquia FROM franquias ORDER BY id_franquia ASC LIMIT 1");

        if ($res_primeira && $res_primeira->num_rows > 0) {
            $id_franquia = (int)$res_primeira->fetch_assoc()["id_franquia"];
        }
    }

    $ordem = $_GET["ordem"] ?? "recentes";

    switch ($ordem) {
        case "antigos":
            $orderBy = "data_lancamento ASC";
            break;

        case "rating":
            $orderBy = "(soma_classificacao / NULLIF(num_votos, 0)) DESC";
            break;

        default:
            $ordem = "recentes";
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
            <a href="index.php"><img src="logo/Logo.png" alt="PlayScore"></a>
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

    <main class="franquia-page">

        <?php if ($franquia) { ?>

            <section class="franquia-topo">

                <div class="franquia-imagem">

                    <?php
                    $imagem_franquia = imagemUrl(
                        $franquia["capa_url"] ?? "",
                        [
                            "img/Franquia/uploads",
                            "img/Franquia",
                            "img/franquia/uploads",
                            "img/franquia"
                        ]
                    );
                    ?>

                    <?php if (!empty($imagem_franquia)) { ?>

                        <img
                            src="<?php echo htmlspecialchars($imagem_franquia); ?>"
                            alt="<?php echo htmlspecialchars($franquia["nome"]); ?>"
                        >

                    <?php } else { ?>

                        <div class="placeholder-img">Imagem</div>

                    <?php } ?>

                </div>

                <div class="franquia-info">

                    <h1><?php echo htmlspecialchars($franquia["nome"]); ?></h1>

                    <div class="franquia-meta">

                        <span>🎮 <?php echo $jogos->num_rows; ?> jogos</span>

                        <span>📅
                            <?php
                            $stmt_datas = $conn->prepare("
                                SELECT 
                                    MIN(data_lancamento) AS primeira,
                                    MAX(data_lancamento) AS ultima
                                FROM jogos
                                WHERE id_franquia = ?
                            ");

                            $stmt_datas->bind_param("i", $id_franquia);
                            $stmt_datas->execute();
                            $datas = $stmt_datas->get_result();
                            $d = $datas->fetch_assoc();
                            $stmt_datas->close();

                            if (!empty($d["primeira"])) {
                            echo date("Y", strtotime($d["primeira"])) . " - ";
                            if (!empty($d["ultima"]) && $d["ultima"] != $d["primeira"]) {
                            echo date("Y", strtotime($d["ultima"]));
                            } else {
                            echo date("Y");
                            }
                            } else {
                            echo "Sem dados";
                            }
                            ?>
                        </span>

                    </div>

                    <p><?php echo htmlspecialchars($franquia["descricao"]); ?></p>

                </div>

            </section>

            <section class="jogos-franquia">

                <h2>Jogos da Franquia</h2>

                <div class="jogos-grid">

                    <?php if ($jogos && $jogos->num_rows > 0) { ?>

                        <?php while ($jogo = $jogos->fetch_assoc()) { ?>

                            <?php
                            $id_jogo = $jogo["id_jogo"] ?? $jogo["id"] ?? 0;

                            $imagem_jogo = imagemUrl(
                                $jogo["capa_url"] ?? "",
                                [
                                    "img/Jogos/uploads",
                                    "img/Jogos",
                                    "img/jogos/uploads",
                                    "img/jogos",
                                    "img/Jogo/uploads",
                                    "img/Jogo",
                                    "img/jogo/uploads",
                                    "img/jogo",
                                    "img/uploads"
                                ]
                            );
                            ?>

                            <article class="jogo-card">

                                <div class="jogo-img">

                                    <?php if (!empty($imagem_jogo)) { ?>

                                        <img
                                            src="<?php echo htmlspecialchars($imagem_jogo); ?>"
                                            alt="<?php echo htmlspecialchars($jogo["titulo"]); ?>"
                                        >

                                    <?php } else { ?>

                                        <div class="placeholder-img">Imagem</div>

                                    <?php } ?>

                                </div>

                                <div class="jogo-conteudo">

                                    <h3><?php echo htmlspecialchars($jogo["titulo"]); ?></h3>

                                    <p>
                                        <?php
                                        echo !empty($jogo["data_lancamento"])
                                            ? date("Y", strtotime($jogo["data_lancamento"]))
                                            : "Sem data";
                                        ?>
                                    </p>

                                    <p>
                                        ⭐
                                        <?php
                                        $num_votos = (int)($jogo["num_votos"] ?? 0);
                                        $soma = (float)($jogo["soma_classificacao"] ?? 0);

                                        echo $num_votos > 0 ? round($soma / $num_votos, 1) : "0";
                                        ?>
                                        (<?php echo $num_votos; ?> votos)
                                    </p>

                                    <a href="jogo.php?id=<?php echo (int)$id_jogo; ?>" class="btn-ver-jogo">
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

        <div class="footer-content">

            <div class="footer-column brand-col">
                <div class="logo">
                    <img src="logo/Logo.png" alt="PlayScore">
                </div>
                <p class="footer-desc">Transformamos dados em decisões inteligentes.</p>
            </div>

            <div class="footer-column nav-col">
                <h3>Navegação</h3>
                <a href="index.php">Início</a>
                <a href="sobrenos.php">Sobre Nós</a>
                <a href="catalogo.php">Catálogo</a>
            </div>

            <div class="footer-column legal-col">
                <h3>Legalidade</h3>
                <a href="regras.php">Regras</a>
                <a href="politicas.php">Privacidade</a>
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
    <script src="js/headerfooter.js"></script>
    </body>

    </html>