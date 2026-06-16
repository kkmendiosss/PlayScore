<?php
session_start();
include "../conexao.php";

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["tipo_utilizador"] != "admin") {
    header("Location: index.php");
    exit();
}

$nome_admin = $_SESSION["nome"] ?? "Admin";

if (isset($_GET["eliminar"])) {
    $id = (int) $_GET["eliminar"];

    $stmt_img = $conn->prepare("SELECT capa_url FROM franquias WHERE id_franquia = ?");

    if ($stmt_img) {
        $stmt_img->bind_param("i", $id);
        $stmt_img->execute();

        $resultado_img = $stmt_img->get_result();
        $imagem = $resultado_img->fetch_assoc();

        if ($imagem && !empty($imagem["capa_url"]) && file_exists($imagem["capa_url"])) {
            unlink($imagem["capa_url"]);
        }

        $stmt_img->close();
    }

    $stmt_delete = $conn->prepare("DELETE FROM franquias WHERE id_franquia = ?");

    if ($stmt_delete) {
        $stmt_delete->bind_param("i", $id);
        $stmt_delete->execute();
        $stmt_delete->close();
    }

    header("Location: dashboard_franquia.php");
    exit();
}



$por_pagina = 10;

$pagina_atual = isset($_GET["pagina"]) ? (int) $_GET["pagina"] : 1;

if ($pagina_atual < 1) {
    $pagina_atual = 1;
}

$offset = ($pagina_atual - 1) * $por_pagina;


$sql_total = "SELECT COUNT(*) AS total FROM franquias";
$resultado_total = mysqli_query($conn, $sql_total);
$total_registos = 0;

if ($resultado_total) {
    $linha_total = mysqli_fetch_assoc($resultado_total);
    $total_registos = (int) $linha_total["total"];
}

$total_paginas = ceil($total_registos / $por_pagina);


$sql = "SELECT * FROM franquias ORDER BY id_franquia DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $por_pagina, $offset);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Backoffice - Franquias</title>
    <link rel="stylesheet" href="../css/backoffice.css">
    <link href="https://fonts.googleapis.com/css2?family=Kode+Mono&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
    <link rel="icon" href="img/PlayScore_Icon.png">
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
                <a href="dashboard_franquia.php" class="active">Franquias</a>
                <a href="dashboard_jogos.php">Jogos</a>
                <a href="dashboard_jogoano.php">Jogo do Ano</a>
                <a href="dashboard_lancamento.php">Lançamentos</a>
                <a href="dashboard_comentarios.php">Comentários</a>
                <a href="dashboard_users.php">Users</a>
            </nav>

            <a href="../index.php" class="back-site">Voltar ao site</a>

        </aside>

        <main class="main-content">

            <div class="topbar">
                <div>
                    <h1>Franquias</h1>
                    <p>Gestão das expansões e franquias registadas</p>
                </div>

                <div class="topbar-actions">
                    <a href="dashboard_adicionar_franquia.php" class="add-btn">
                        + Adicionar
                    </a>

                    <span>Admin: <?php echo htmlspecialchars($nome_admin); ?></span>
                </div>
            </div>

            <section class="table-card">

                <table>

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Capa</th>
                            <th>Nome do Projeto</th>
                            <th>Descrição</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if ($resultado && mysqli_num_rows($resultado) > 0) { ?>

                            <?php while ($franquia = mysqli_fetch_assoc($resultado)) { ?>

                                <tr>
                                    <td>
                                        <?php echo (int) $franquia["id_franquia"]; ?>
                                    </td>

                                    <td>
                                        <?php if (!empty($franquia["capa_url"])) { ?>
                                            <img 
                                                src="<?php echo htmlspecialchars($franquia["capa_url"]); ?>" 
                                                class="table-avatar-jogo" 
                                                alt="Capa da franquia"
                                                style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;"
                                            >
                                        <?php } else { ?>
                                            <div class="avatar-placeholder">?</div>
                                        <?php } ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($franquia["nome"]); ?>
                                    </td>

                                    <td>
                                        <?php
                                            $desc = htmlspecialchars($franquia["descricao"]);
                                            echo strlen($desc) > 50 ? substr($desc, 0, 50) . "..." : $desc;
                                        ?>
                                    </td>

                                    <td class="actions">

                                        <a 
                                            href="dashboard_ver_franquia.php?id=<?php echo (int) $franquia["id_franquia"]; ?>" 
                                            class="btn view"
                                        >
                                            Ver
                                        </a>

                                        <a 
                                            href="dashboard_editar_franquia.php?id=<?php echo (int) $franquia["id_franquia"]; ?>" 
                                            class="btn edit"
                                        >
                                            Editar
                                        </a>

                                        <a 
                                            href="dashboard_franquia.php?eliminar=<?php echo (int) $franquia["id_franquia"]; ?>" 
                                            class="btn delete" 
                                            onclick="return confirm('Tens a certeza que queres eliminar esta franquia do sistema?');"
                                        >
                                            Eliminar
                                        </a>

                                    </td>

                                </tr>

                            <?php } ?>

                        <?php } else { ?>

                            <tr>
                                <td colspan="5" style="text-align: center; padding: 30px;">
                                    Ainda não existem franquias registadas.
                                </td>
                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

                <?php if ($total_paginas > 1) { ?>

                    <div class="pagination">

                        <?php if ($pagina_atual > 1) { ?>
                            <a href="dashboard_franquia.php?pagina=<?php echo $pagina_atual - 1; ?>">
                                Anterior
                            </a>
                        <?php } ?>

                        <?php for ($i = 1; $i <= $total_paginas; $i++) { ?>

                            <a 
                                href="dashboard_franquia.php?pagina=<?php echo $i; ?>" 
                                class="<?php echo $i == $pagina_atual ? 'active-page' : ''; ?>"
                            >
                                <?php echo $i; ?>
                            </a>

                        <?php } ?>

                        <?php if ($pagina_atual < $total_paginas) { ?>
                            <a href="dashboard_franquia.php?pagina=<?php echo $pagina_atual + 1; ?>">
                                Seguinte
                            </a>
                        <?php } ?>

                    </div>

                <?php } ?>

            </section>

        </main>

    </div>

</body>

</html>