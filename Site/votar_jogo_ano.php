<?php
session_start();
include "conexao.php";

header('Content-Type: application/json');

if (!isset($_SESSION["id"])) {
    echo json_encode(["success" => false, "error" => "Tens de iniciar sessão para votar."]);
    exit;
}

$id_utilizador = (int)$_SESSION["id"];
$id_jogo = isset($_POST['id_jogo']) ? (int)$_POST['id_jogo'] : 0;
$ano = isset($_POST['ano']) ? (int)$_POST['ano'] : 0;

if ($id_jogo === 0 || $ano === 0) {
    echo json_encode(["success" => false, "error" => "Dados de votação inválidos."]);
    exit;
}

mysqli_begin_transaction($conn);

try {
    $query_verificar = "SELECT id_jogo FROM votos_utilizadores_ano WHERE id_utilizador = $id_utilizador AND ano = $ano";
    $resultado_verificar = mysqli_query($conn, $query_verificar);
    
    if (mysqli_num_rows($resultado_verificar) > 0) {
        $voto_antigo = mysqli_fetch_assoc($resultado_verificar);
        $id_jogo_antigo = (int)$voto_antigo['id_jogo'];
        
        if ($id_jogo_antigo === $id_jogo) {
            mysqli_commit($conn);
            echo json_encode(["success" => true, "message" => "Voto mantido."]);
            exit;
        }
        
        $query_subtrair = "UPDATE jogo_do_ano SET num_votos = num_votos - 1 WHERE id_jogo = $id_jogo_antigo AND ano = $ano";
        mysqli_query($conn, $query_subtrair);
        
        $query_atualizar_voto = "UPDATE votos_utilizadores_ano SET id_jogo = $id_jogo WHERE id_utilizador = $id_utilizador AND ano = $ano";
        mysqli_query($conn, $query_atualizar_voto);
        
    } else {
        $query_inserir_voto = "INSERT INTO votos_utilizadores_ano (id_utilizador, id_jogo, ano) VALUES ($id_utilizador, $id_jogo, $ano)";
        mysqli_query($conn, $query_inserir_voto);
    }
    
    $query_adicionar = "INSERT INTO jogo_do_ano (id_jogo, ano, num_votos) VALUES ($id_jogo, $ano, 1) 
                        ON DUPLICATE KEY UPDATE num_votos = num_votos + 1";
    mysqli_query($conn, $query_adicionar);
    
    mysqli_commit($conn);
    echo json_encode(["success" => true]);

} catch (Exception $e) {
    mysqli_rollback($conn);
    echo json_encode(["success" => false, "error" => "Erro ao processar o voto na Base de Dados."]);
}
?>