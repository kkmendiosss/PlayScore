<?php
session_start();
include "conexao.php";

$nome_user = $_SESSION["nome"] ?? "";
$email_user = $_SESSION["email"] ?? "";
$tipo = strtolower(trim($_SESSION["tipo_utilizador"] ?? ""));


if (isset($_GET['apagar_id'])) {

    $id_apagar = (int)$_GET['apagar_id'];

    $sql_delete = "DELETE FROM contactos WHERE id_contacto = $id_apagar";
    $conn->query($sql_delete);

    header("Location: contactos.php");
    exit;
}

$ticket_enviado = false;
$dados_ticket = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome_form = $conn->real_escape_string($_POST['nome']);
    $email_form = $conn->real_escape_string($_POST['email']);
    $mensagem_form = $conn->real_escape_string($_POST['mensagem']);

    $sql = "INSERT INTO contactos (nome, email, mensagem) VALUES ('$nome_form', '$email_form', '$mensagem_form')";

    if ($conn->query($sql) === TRUE) {
        $ticket_enviado = true;

        $id_inserido = $conn->insert_id;

        $dados_ticket = [
            'id' => $id_inserido,
            'nome' => htmlspecialchars($_POST['nome']),
            'email' => htmlspecialchars($_POST['email']),
            'mensagem' => htmlspecialchars($_POST['mensagem']),
            'estado' => 'Pendente'
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlayScore | Rede de Conexão // Contactos</title>
    <link rel="stylesheet" href="css/headerfooter.css">
    <link rel="stylesheet" href="css/contactos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kode+Mono:wght@400..700&family=Abel&display=swap" rel="stylesheet">
    <link rel="icon" href="img/PlayScore_Icon.png">
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

        <?php if ($nome_user != "") { ?>

            <div class="user-dropdown">

                <button class="btn-login">
                    <?php echo $nome_user; ?> ▼
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

    <div class="page-wrapper">

        <header class="page-header">
            <h1>REDE DE CONEXÃO // CONTACTOS</h1>
            <p>A elite não apenas joga, ela domina a comunicação. Estamos aqui para responder aos teus tickets.</p>
        </header>

        <div class="contact-container">

            <div class="contact-info">
                <h3>CANAIS DIRETOS DA ELITE</h3>
                <p><strong>Hub Técnico:</strong> tech@playscore.net</p>
                <p><strong>Parcerias:</strong> partnerships@playscore.net</p>
                <p><strong>Franquias:</strong> franchise@playscore.net</p>
                <br>
                <p><strong>Suporte Real-Time:</strong> #tech-support (via Discord)</p>
                <br>
                <p><strong>Localização Física:</strong><br> Leiria, Portugal</p>
            </div>

            <div class="contact-form-box">
                <h3>SUBMISSÃO DE TICKET V4.1</h3>

                <form action="" method="POST">
                    <div class="form-group">
                        <label for="nome">Nome de Identificação</label>
                        <input type="text" id="nome" name="nome" required placeholder="Insere o teu nome">
                    </div>

                    <div class="form-group">
                        <label for="email">Email de Performance</label>
                        <input type="email" id="email" name="email" required placeholder="email@exemplo.com">
                    </div>

                    <div class="form-group">
                        <label for="mensagem">Mensagem</label>
                        <textarea id="mensagem" name="mensagem" rows="5" required placeholder="Descreve a tua questão aqui..."></textarea>
                    </div>

                    <button type="submit" class="submit-btn">SUBMETER TICKET</button>
                </form>
            </div>
        </div>

        <?php if ($ticket_enviado): ?>
            <div class="ticket-status-box">
                <div class="ticket-header">
                    <h4>TICKET SUBMETIDO COM SUCESSO</h4>
                    <span class="badge-pendente">STATUS: <?php echo $dados_ticket['estado']; ?> ⏳</span>
                </div>
                <div class="ticket-body">
                    <p><strong>Identificação:</strong> <?php echo $dados_ticket['nome']; ?></p>
                    <p><strong>Email:</strong> <?php echo $dados_ticket['email']; ?></p>
                    <p><strong>Mensagem:</strong> <?php echo nl2br($dados_ticket['mensagem']); ?></p>
                </div>

                <div style="text-align: center; margin-top: 20px;">
                    <button type="button" class="btn-feito" onclick="window.location.href='contactos.php?apagar_id=<?php echo $dados_ticket['id']; ?>'">Concluido</button>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <footer>
        <div class="footer-content">
            <div class="footer-column brand-col">
                <div class="logo"><img src="logo/Logo.png" alt="PlayScore"></div>
                <p class="footer-desc">Transformamos dados em decisões inteligentes.</p>
            </div>
            <div class="footer-column nav-col">
                <h3>Navegação</h3>
                <a href="index.php">Início</a><a href="sobrenos.php">Sobre Nós</a><a href="catalogo.php">Catálogo</a>
            </div>
            <div class="footer-column legal-col">
                <h3>Legalidade</h3>
                <a href="regras.php">Regras</a><a href="politicas.php">Privacidade</a><a href="contactos.php">Contactos</a>
            </div>
            <div class="footer-social">
                <span>Discord</span><span>Twitter</span><span>LinkedIn</span>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2026 PLAYSCORE NETWORK. TODOS OS DIREITOS RESERVADOS.</p>
        </div>
    </footer>

    <script src="js/headerfooter.js"></script>
</body>

</html>