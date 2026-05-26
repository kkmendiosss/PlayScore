<?php
$jogo_id = $_POST['jogo_id'];
$classificacao = $_POST['classificacao'];

$stmt = $pdo->prepare("UPDATE jogos SET classificacao = ? WHERE id = ?");
$stmt->execute([$classificacao, $jogo_id]);

header("Location: jogo.php?id=$jogo_id");