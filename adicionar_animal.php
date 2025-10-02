<?php
// AdoPET/adicionar_animal.php
require_once 'db.php';
require_once 'helpers.php';
session_start();
header('Content-Type: text/html; charset=utf-8');
$page_title = 'Adicionar Novo Animal';

if (!isset($_SESSION['user_id'])) {
    set_flash_message('Faça login para adicionar um animal.', 'warning');
    header('Location: login.php');
    exit();
}

$conn = get_db_connection();

$especies = [];
$especie_query = "SELECT id, nome FROM especies ORDER BY nome ASC";
$result_especie = $conn->query($especie_query);
if ($result_especie) {
    $especies = $result_especie->fetch_all(MYSQLI_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $foto_url = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        if (!is_dir('uploads')) {
            mkdir('uploads', 0755, true);
        }
        $foto_tmp_name = $_FILES['foto']['tmp_name'];
        $foto_name = basename($_FILES['foto']['name']);
        $file_extension = strtolower(pathinfo($foto_name, PATHINFO_EXTENSION));
        $allowed_extensions = ['png', 'jpg', 'jpeg', 'gif'];

        if (in_array($file_extension, $allowed_extensions)) {
            $filename = uniqid('animal_', true) . '.' . $file_extension;
            $upload_path = 'uploads/' . $filename;

            if (move_uploaded_file($foto_tmp_name, $upload_path)) {
                $foto_url = $filename;
            } else {
                set_flash_message('Erro ao mover o arquivo de imagem.', 'danger');
            }
        } else {
            set_flash_message('Tipo de arquivo de imagem não permitido.', 'danger');
        }
    }

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
    $id_usuario = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO animais (nome, id_especie, raca, idade, genero, porte, castrado, vacinado, vermifugado, descricao, foto_url, id_usuario, disponivel) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");
    $stmt->bind_param("sissssiiissi", $nome, $id_especie, $raca, $idade, $genero, $porte, $castrado, $vacinado, $vermifugado, $descricao, $foto_url, $id_usuario);

    if ($stmt->execute()) {
        set_flash_message('Animal cadastrado com sucesso!', 'success');
        header('Location: dashboard.php');
        exit();
    } else {
        set_flash_message('Erro ao cadastrar animal: ' . $stmt->error, 'danger');
    }
}

include 'templates/header.php';
?>

<section class="form-section">
    <h2>Adicionar Novo Animal</h2>
    <form method="POST" action="adicionar_animal.php" enctype="multipart/form-data">
        <label for="nome">Nome do Animal:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="especie">Espécie:</label>
        <select name="especie" id="especie" required>
            <option value="">Selecione</option>
            <?php foreach ($especies as $esp): ?>
                <option value="<?php echo $esp['id']; ?>"><?php echo htmlspecialchars($esp['nome']); ?></option>
            <?php endforeach; ?>
        </select>

        <label for="raca">Raça:</label>
        <input type="text" id="raca" name="raca" placeholder="Ex: SRD (Sem Raça Definida)">

        <label for="idade">Idade:</label>
        <input type="number" id="idade" name="idade" required min="0">

        <label for="genero">Gênero:</label>
        <select name="genero" id="genero" required>
            <option value="">Selecione</option>
            <option value="Macho">Macho</option>
            <option value="Fêmea">Fêmea</option>
        </select>

        <label for="porte">Porte:</label>
        <select name="porte" id="porte" required>
            <option value="">Selecione</option>
            <option value="Pequeno">Pequeno</option>
            <option value="Medio">Médio</option>
            <option value="Grande">Grande</option>
        </select>

        <div class="checkbox-group">
            <label><input type="checkbox" name="castrado"> Castrado</label>
            <label><input type="checkbox" name="vacinado"> Vacinado</label>
            <label><input type="checkbox"name="vermifugado"> Vermifugado</label>
        </div>

        <label for="descricao">Descrição e Personalidade:</label>
        <textarea id="descricao" name="descricao" rows="6" required></textarea>

        <label for="foto">Foto do Animal:</label>
        <input type="file" id="foto" name="foto" accept="image/*">
        <small class="help-text">Tipos permitidos: PNG, JPG, JPEG, GIF.</small>

        <button type="submit" class="btn-primary">Cadastrar Animal</button>
    </form>
</section>

<?php 
$conn->close(); // Fechar a conexão aqui se ela não foi fechada no POST
include 'templates/footer.php'; 
?>