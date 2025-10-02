<?php
// AdoPET/manifestar_interesse.php
require_once 'db.php';
require_once 'helpers.php';
session_start();
header('Content-Type: text/html; charset=utf-8');

if (!isset($_SESSION['user_id'])) {
    set_flash_message('Faça login para manifestar interesse.', 'warning');
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: animais.php');
    exit();
}

$animal_id = $_POST['animal_id'] ?? null;
$id_interessado = $_SESSION['user_id'];
$mensagem = $_POST['mensagem'] ?? '';

if (!$animal_id) {
    set_flash_message('ID do animal não especificado.', 'danger');
    header('Location: animais.php');
    exit();
}

if (empty($mensagem) || strlen($mensagem) < 10) {
    set_flash_message('Por favor, escreva uma mensagem com pelo menos 10 caracteres para o doador.', 'danger');
    header('Location: animal_detalhes.php?id=' . $animal_id);
    exit();
}

$conn = get_db_connection();

$stmt_check = $conn->prepare("
    SELECT id 
    FROM interesses_adocao 
    WHERE id_animal = ? AND id_interessado = ? AND status IN ('Pendente', 'Aprovado')
");
$stmt_check->bind_param("ii", $animal_id, $id_interessado);
$stmt_check->execute();
if ($stmt_check->get_result()->num_rows > 0) {
    set_flash_message('Você já tem um interesse ativo neste animal. Verifique seu painel.', 'info');
    header('Location: animal_detalhes.php?id=' . $animal_id);
    exit();
}
$stmt_check->close();

$stmt_insert = $conn->prepare("
    INSERT INTO interesses_adocao (id_animal, id_interessado, mensagem_interessado, status) 
    VALUES (?, ?, ?, 'Pendente')
");
$stmt_insert->bind_param("iis", $animal_id, $id_interessado, $mensagem);

if ($stmt_insert->execute()) {
    set_flash_message('Seu interesse foi registrado com sucesso! O doador será notificado.', 'success');
} else {
    set_flash_message('Erro ao registrar interesse: ' . $stmt_insert->error, 'danger');
}

$stmt_insert->close();
$conn->close();
header('Location: animal_detalhes.php?id=' . $animal_id);
exit();
?>