<?php
session_start();
include "conexao.php";

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$id_utilizador = $_SESSION["id"];
$tipo = strtolower(trim($_SESSION["tipo_utilizador"] ?? ""));
$mensagem = "";

if (isset($_POST["guardar_avatar"])) {

    if (isset($_FILES["avatar"]) && $_FILES["avatar"]["error"] == 0) {

        if (!is_dir("uploads/avatars")) {
            mkdir("uploads/avatars", 0777, true);
        }

        $extensao = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
        $nome_ficheiro = "avatar_" . $id_utilizador . "_" . time() . "." . $extensao;
        $caminho_avatar = "uploads/avatars/" . $nome_ficheiro;

        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $caminho_avatar)) {

            $sql = "UPDATE users 
                    SET avatar_url='$caminho_avatar' 
                    WHERE id_utilizador=$id_utilizador";

            if (mysqli_query($conn, $sql)) {
                header("Location: perfil.php");
                exit();
            }
        }
    }
}

if (isset($_POST["guardar_bio"])) {

    $bio_nova = $_POST["bio"];

    $sql = "UPDATE users 
            SET bio='$bio_nova' 
            WHERE id_utilizador=$id_utilizador";

    if (mysqli_query($conn, $sql)) {
        header("Location: perfil.php");
        exit();
    }
}

$sqlUser = "SELECT * FROM users 
            WHERE id_utilizador = $id_utilizador";

$resultUser = mysqli_query($conn, $sqlUser);

$user = mysqli_fetch_assoc($resultUser);

$nome = $user["nome"];
$email = $user["email"];
$bio = $user["bio"];
$avatar = $user["avatar_url"];

$data_registo =
    date("d/m/Y", strtotime($user["data_registo"]));

$sqlFavoritos = "SELECT COUNT(*) as total 
                 FROM favoritos 
                 WHERE id_utilizador = $id_utilizador";

$resultFavoritos = mysqli_query($conn, $sqlFavoritos);

$total_favoritos =
    mysqli_fetch_assoc($resultFavoritos)["total"];
?>

<!DOCTYPE html>
<html lang="pt">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Perfil</title>

    <link rel="stylesheet" href="css/perfil.css">
    <link rel="stylesheet" href="css/headerfooter.css">

    <link href="https://fonts.googleapis.com/css2?family=Kode+Mono&display=swap"
        rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap"
        rel="stylesheet">

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
    <main class="container">

        <section class="profile-header">

            <div class="profile-info">

                <form method="POST"
                    enctype="multipart/form-data"
                    class="avatar-form">

                    <label for="avatarInput" class="avatar">

                        <?php if (!empty($avatar)) { ?>

                            <img src="<?php echo $avatar; ?>"
                                alt="Avatar">

                        <?php } else { ?>

                            <svg viewBox="0 0 24 24"
                                fill="white">

                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 
                            1.79-4 4 1.79 4 4 4zm0 
                            2c-2.67 0-8 1.34-8 
                            4v2h16v-2c0-2.66-5.33-4-8-4z" />

                            </svg>

                        <?php } ?>

                        <span class="avatar-edit-icon">
                            +
                        </span>

                    </label>

                    <input type="file"
                        id="avatarInput"
                        name="avatar"
                        accept="image/*"
                        style="display:none;">

                    <button type="submit"
                        name="guardar_avatar"
                        id="guardarAvatarBtn"
                        style="display:none;">
                        Guardar
                    </button>

                </form>

                <h1 class="username">
                    <?php echo $nome; ?>
                </h1>

            </div>

            <div class="stats-container">

                <div class="stat-box">

                    <p class="stat-label">
                        Conta criada em
                    </p>

                    <p class="stat-value">
                        <?php echo $data_registo; ?>
                    </p>

                </div>

                <div class="stat-box">

                    <p class="stat-label">
                        Total de favoritos
                    </p>

                    <p class="stat-value">
                        <?php echo $total_favoritos; ?>
                    </p>

                </div>

            </div>

        </section>

        <section class="bio-section">

            <div class="bio-header">

                <h2 class="section-title">
                    Bio
                </h2>

                <button type="button"
                    class="edit-bio-btn"
                    id="toggleBioEdit">

                    Editar Bio

                </button>

            </div>

            <?php if ($mensagem != "") { ?>

                <p class="bio-message">
                    <?php echo $mensagem; ?>
                </p>

            <?php } ?>

            <p class="bio-text">

                <?php
                if (!empty($bio)) {
                    echo nl2br(htmlspecialchars($bio));
                } else {
                    echo "Este utilizador ainda não tem descrição.";
                }
                ?>

            </p>

            <form method="POST"
                class="bio-form"
                id="bioForm"
                style="display:none;">

                <textarea
                    name="bio"
                    placeholder="Escreve algo sobre ti..."><?php echo $bio; ?></textarea>

                <button type="submit"
                    name="guardar_bio"
                    class="save-bio-btn">

                    Guardar Bio

                </button>

            </form>

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
    <script>
        document.getElementById("toggleBioEdit").onclick = function() {

            const form = document.getElementById("bioForm");

            if (form.style.display == "none") {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        };

        document.getElementById("avatarInput").onchange = function() {
            document.getElementById("guardarAvatarBtn").click();
        };
    </script>

</body>

</html>