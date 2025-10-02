<?php
// AdoPET/editar_animal.php
require_once 'db.php';
require_once 'helpers.php';
session_start();
$page_title = 'Editar Animal';

include 'templates/header.php';

if (!isset($_SESSION['user_id'])) {
    set_flash_message('Faça login para editar um animal.', 'warning');
    header('Location: login.php');
    exit();
}

$animal_id = $_GET['id'] ?? 0;
if (!$animal_id) {
    header('Location: dashboard.php');
    exit();
}

$conn = get_db_connection();
$user_id = $_SESSION['user_id'];

// Buscar animal
$stmt = $conn->prepare("SELECT * FROM animais WHERE id = ? AND id_usuario = ?");
$stmt->bind_param("ii", $animal_id, $user_id);
$stmt->execute();
$animal = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$animal) {
    set_flash_message('Animal não encontrado ou você não tem permissão para editá-lo.', 'danger');
    header('Location: dashboard.php');
    exit();
}

// Buscar espécies
$especies = [];
$stmt_especie = $conn->prepare("SELECT id, nome FROM especies ORDER BY nome");
$stmt_especie->execute();
$result_especie = $stmt_especie->get_result();
while ($row = $result_especie->fetch_assoc()) {
    $especies[] = $row;
}
$stmt_especie->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $id_especie = $_POST['especie'];
    $raca = $_POST['raca'] ?: 'Não definida';
    $idade = $_POST['idade'];
    $genero = $_POST['genero'];
    $porte = $_POST['porte'];
    $castrado = isset($_POST['castrado']) ? 1 : 0;
    $vacinado = isset($_POST['vacinado']) ? 1 : 0;
    $vermifugado = isset($_POST['vermifugado']) ? 1 : 0;
    $descricao = $_POST['descricao'];
    $disponivel = $_POST['disponivel']; 

    $foto_url = $animal['foto_url'];
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        
    }

    $stmt_update = $conn->prepare("UPDATE animais SET nome = ?, id_especie = ?, raca = ?, idade = ?, genero = ?, porte = ?, castrado = ?, vacinado = ?, vermifugado = ?, disponivel = ?, descricao = ?, foto_url = ? WHERE id = ?");
    $stmt_update->bind_param("sissssiiisssi", $nome, $id_especie, $raca, $idade, $genero, $porte, $castrado, $vacinado, $vermifugado, $disponivel, $descricao, $foto_url, $animal_id);

    if ($stmt_update->execute()) {
        set_flash_message('Animal atualizado com sucesso!', 'success');
        header('Location: dashboard.php');
        exit();
    } else {
        set_flash_message('Erro ao atualizar animal: ' . $stmt_update->error, 'danger');
    }
    $stmt_update->close();
    $conn->close(); 
    header("Location: editar_animal.php?id=" . $animal_id); 
    exit();
}
?>

<section class="form-section">
    <h2>Editar Animal: <?php echo htmlspecialchars($animal['nome']); ?></h2>
    <form method="POST" action="editar_animal.php?id=<?php echo $animal['id']; ?>" enctype="multipart/form-data">
        <label for="nome">Nome do Animal:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($animal['nome']); ?>" required>

        <label for="especie">Espécie:</label>
        <select name="especie" id="especie" required>
            <?php foreach ($especies as $esp): ?>
                <option value="<?php echo $esp['id']; ?>" <?php if ($animal['id_especie'] == $esp['id']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($esp['nome']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="raca">Raça:</label>
        <input type="text" id="raca" name="raca" value="<?php echo htmlspecialchars($animal['raca'] ?? ''); ?>">

        <label for="idade">Idade (anos):</label>
        <input type="number" id="idade" name="idade" required value="<?php echo htmlspecialchars($animal['idade']); ?>">

        <label for="genero">Gênero:</label>
        <select name="genero" id="genero" required>
            <option value="Macho" <?php if ($animal['genero'] == 'Macho') echo 'selected'; ?>>Macho</option>
            <option value="Fêmea" <?php if ($animal['genero'] == 'Fêmea') echo 'selected'; ?>>Fêmea</option>
        </select>

        <label for="porte">Porte:</label>
        <select name="porte" id="porte" required>
            <option value="Pequeno" <?php if ($animal['porte'] == 'Pequeno') echo 'selected'; ?>>Pequeno</option>
            <option value="Medio" <?php if ($animal['porte'] == 'Medio') echo 'selected'; ?>>Médio</option>
            <option value="Grande" <?php if ($animal['porte'] == 'Grande') echo 'selected'; ?>>Grande</option>
        </select>

        <label for="disponivel">Disponibilidade:</label>
        <select name="disponivel" id="disponivel" required>
            <option value="1" <?php if ($animal['disponivel'] == 1) echo 'selected'; ?>>Disponível</option>
            <option value="0" <?php if ($animal['disponivel'] == 0) echo 'selected'; ?>>Adotado/Indisponível</option>
        </select>

        <div class="checkbox-group">
            <label><input type="checkbox" name="castrado" <?php if ($animal['castrado']) echo 'checked'; ?>> Castrado</label>
            <label><input type="checkbox" name="vacinado" <?php if ($animal['vacinado']) echo 'checked'; ?>> Vacinado</label>
            <label><input type="checkbox" name="vermifugado" <?php if ($animal['vermifugado']) echo 'checked'; ?>> Vermifugado</label>
        </div>

        <label for="descricao">Descrição e Personalidade:</label>
        <textarea id="descricao" name="descricao" rows="6" required><?php echo htmlspecialchars($animal['descricao']); ?></textarea>

        <label for="foto">Alterar Foto do Animal:</label>
        <?php if (!empty($animal['foto_url'])): ?>
            <img src="uploads/<?php echo htmlspecialchars($animal['foto_url']); ?>" alt="Foto atual" style="max-width: 150px; display: block; margin-bottom: 10px;">
        <?php endif; ?>
        <input type="file" id="foto" name="foto" accept="image/*">
        <small class="help-text">Deixe em branco para manter a foto atual.</small>

        <button type="submit" class="btn-primary">Atualizar Animal</button>
    </form>
    
    <hr style="margin-top: 40px;">
    <h3 style="color: #dc3545;">Zona de Perigo</h3>
    <p>A exclusão de um animal é uma ação permanente e não pode ser desfeita.</p>
    <form action="excluir_animal.php" method="POST" onsubmit="return confirm('Tem certeza ABSOLUTA que deseja excluir este animal? Esta ação não pode ser desfeita.');">
        <input type="hidden" name="id_animal" value="<?php echo $animal['id']; ?>">
        <button type="submit" style="background-color: #dc3545; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Excluir Animal</button>
    </form>
</section>

<?php 
if (isset($conn)) {
    $conn->close();
}
include 'templates/footer.php'; 
?>