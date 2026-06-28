<?php
session_start();
include "../conexao.php";

if (!isset($_SESSION["id"]) || $_SESSION["tipo_utilizador"] != "admin") {
    header("Location: login.php");
    exit();
}

$nome_admin = $_SESSION["nome"] ?? "Admin";

$por_pagina = 10;
$pagina = $_GET["pagina"] ?? 1;
$pagina = max(1, intval($pagina));

$inicio = ($pagina - 1) * $por_pagina;

$sql_total = "SELECT COUNT(*) AS total FROM votos_utilizadores_ano";
$resultado_total = mysqli_query($conn, $sql_total);
$total_linhas = mysqli_fetch_assoc($resultado_total)["total"];

$total_paginas = ceil($total_linhas / $por_pagina);

$sql = "SELECT v.ano, u.nome AS nome_utilizador, j.titulo AS titulo_jogo 
        FROM votos_utilizadores_ano v
        JOIN users u ON v.id_utilizador = u.id_utilizador
        JOIN jogos j ON v.id_jogo = j.id_jogo
        ORDER BY v.ano DESC, u.nome ASC 
        LIMIT $inicio, $por_pagina";
        
$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Backoffice - Jogo do Ano</title>
    <link rel="stylesheet" href="../css/backoffice.css">
    <link href="https://fonts.googleapis.com/css2?family=Kode+Mono&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
</head>

<body>

    <div class="backoffice">

        <aside class="sidebar">
            <div class="sidebar-logo">
                <img src="../logo/Logo.png" alt="PlayScore">
            </div>

            <h2>Dashboard</h2>
            <a href="dashboard.php">Dashboard</a>

            <nav class="sidebar-menu">
                <a href="dashboard_favoritos.php">Favoritos</a>
                <a href="dashboard_generos.php">Géneros</a>
                <a href="dashboard_contactos.php">Contactos</a>
                <a href="dashboard_franquia.php">Franquias</a>
                <a href="dashboard_jogos.php">Jogos</a>
                <a href="dashboard_jogoano.php" class="active">Jogo do Ano</a>
                <a href="dashboard_lancamento.php">Lançamentos</a>
                <a href="dashboard_comentarios.php">Comentários</a>
                <a href="dashboard_users.php">Users</a>
            </nav>

            <a href="../index.php" class="back-site">Voltar ao site</a>
        </aside>

        <main class="main-content">

            <div class="topbar">
                <div>
                    <h1>Jogo do Ano</h1>
                    <p>Visualização dos votos submetidos pelos utilizadores</p>
                </div>

                <div class="topbar-actions">
                    <span>Admin: <?php echo $nome_admin; ?></span>
                </div>
            </div>

            <section class="table-card">
                <table>
                    <thead>
                        <tr>
                            <th>Utilizador</th>
                            <th>Ano</th>
                            <th>Jogo Votado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($resultado) > 0) { ?>
                            <?php while ($voto = mysqli_fetch_assoc($resultado)) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($voto["nome_utilizador"]); ?></td>
                                    <td><?php echo $voto["ano"]; ?></td>
                                    <td><?php echo htmlspecialchars($voto["titulo_jogo"]); ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>

                <?php if ($total_paginas > 1) { ?>
                <div class="pagination">

                    <?php if ($pagina > 1) { ?>
                        <a href="dashboard_jogoano.php?pagina=<?php echo $pagina - 1; ?>">
                            Anterior
                        </a>
                    <?php } ?>

                    <?php for ($i = 1; $i <= $total_paginas; $i++) { ?>
                        <a href="dashboard_jogoano.php?pagina=<?php echo $i; ?>"
                            class="<?php echo ($i == $pagina) ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php } ?>

                    <?php if ($pagina < $total_paginas) { ?>
                        <a href="dashboard_jogoano.php?pagina=<?php echo $pagina + 1; ?>">
                            Próxima
                        </a>
                    <?php } ?>

                </div>
                <?php } ?>

            </section>

        </main>

    </div>

</body>

</html>