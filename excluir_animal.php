<?php
// AdoPET/excluir_animal.php
require_once 'db.php';
require_once 'helpers.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_animal = $_POST['id_animal'] ?? null;
    $user_id = $_SESSION['user_id'];

    if (!$id_animal) {
        set_flash_message('ID do animal não fornecido.', 'danger');
        header('Location: dashboard.php');
        exit();
    }

    $conn = get_db_connection();

    $stmt = $conn->prepare("SELECT id_usuario FROM animais WHERE id = ?");
    $stmt->bind_param("i", $id_animal);
    $stmt->execute();
    $result = $stmt->get_result();
    $animal = $result->fetch_assoc();
    $stmt->close();

    if ($animal && $animal['id_usuario'] == $user_id) {
        $delete_stmt = $conn->prepare("DELETE FROM animais WHERE id = ?");
        $delete_stmt->bind_param("i", $id_animal);

        if ($delete_stmt->execute()) {
            set_flash_message('Animal excluído com sucesso.', 'success');
        } else {
            set_flash_message('Erro ao excluir o animal.', 'danger');
        }
        $delete_stmt->close();
    } else {
        set_flash_message('Você não tem permissão para excluir este animal.', 'danger');
    }

    $conn->close();
    header('Location: dashboard.php');
    exit();
}
?>