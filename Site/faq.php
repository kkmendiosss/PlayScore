<?php
session_start();
include "conexao.php";
$nome = $_SESSION["nome"] ?? "";
$email = $_SESSION["email"] ?? "";
$tipo = strtolower(trim($_SESSION["tipo_utilizador"] ?? ""));
?>
<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FAQ</title>
  <link rel="stylesheet" href="css/faq.css">
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
    <h1>Perguntas Frequentes</h1>
  </div>

  <div class="container">

    <h2 class="section-title">Conta e Acesso</h2>

    <div class="faq-item">
      <div class="faq-question">
        Como posso criar uma conta?
        <div class="triangle"></div>
      </div>
      <div class="faq-answer">
        Para criar uma conta, clique em “Login” no topo do site, vá a "Registrar" e preencha os seus dados (nome, email e palavra-passe).
      </div>
    </div>

    <div class="faq-item">
      <div class="faq-question">
        Já tenho conta. Como faço login?
        <div class="triangle"></div>
      </div>
      <div class="faq-answer">
        Clique em "Login" no topo do site e preencha os seus dados (nome, email e palavra-passe).
      </div>
    </div>

    <h2 class="section-title">Pesquisa e Navegação</h2>

    <div class="faq-item">
      <div class="faq-question">
        Como posso encontrar jogos no site?
        <div class="triangle"></div>
      </div>
      <div class="faq-answer">
        Pode usar a barra de pesquisa ou filtrar jogos por categoria, como empresa, consola, género ou popularidade.
      </div>
    </div>

    <div class="faq-item">
      <div class="faq-question">
        Posso filtrar jogos por consola ou tipo?
        <div class="triangle"></div>
      </div>
      <div class="faq-answer">
        Sim, temos filtros avançados que permitem procurar por consola (PlayStation, Xbox, PC, etc.), género (ação, RPG, desporto, etc.) e muito mais.
      </div>
    </div>

    <div class="faq-item">
      <div class="faq-question">
        O site mostra jogos recomendados?
        <div class="triangle"></div>
      </div>
      <div class="faq-answer">
        Sim, apresentamos recomendações com base na sua atividade e jogos favoritos.
      </div>
    </div>

    <h2 class="section-title">Avaliações, Comentários e Favoritos</h2>

    <div class="faq-item">
      <div class="faq-question">
        Como posso avaliar um jogo?
        <div class="triangle"></div>
      </div>
      <div class="faq-answer">
        Após fazer login, pode atribuir uma classificação (ex: 1 a 5 estrelas) na página do jogo.
      </div>
    </div>

    <div class="faq-item">
      <div class="faq-question">
        Posso deixar comentários sobre os jogos?
        <div class="triangle"></div>
      </div>
      <div class="faq-answer">
        Sim, pode comentar em qualquer jogo depois de estar autenticado.
      </div>
    </div>

    <div class="faq-item">
      <div class="faq-question">
        Como adiciono jogos aos favoritos?
        <div class="triangle"></div>
      </div>
      <div class="faq-answer">
        Clique no botão “Adicionar aos Favoritos” na página do jogo.
      </div>
    </div>

    <div class="faq-item">
      <div class="faq-question">
        Onde posso ver os meus jogos favoritos?
        <div class="triangle"></div>
      </div>
      <div class="faq-answer">
        Na sua área de perfil, na secção “Favoritos”.
      </div>
    </div>

  </div>

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
    const items = document.querySelectorAll('.faq-item');

    items.forEach(item => {
      item.addEventListener('click', () => {
        item.classList.toggle('active');
      });
    });
  </script>

</body>

</html>