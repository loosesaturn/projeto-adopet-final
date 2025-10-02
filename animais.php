<?php
// AdoPET/animais.php
require_once 'helpers.php';
require_once 'db.php';
$page_title = 'Animais Disponíveis para Adoção';
include 'templates/header.php';

$conn = get_db_connection();

$query = "SELECT a.*, u.nome as nome_doador, e.nome as nome_especie 
          FROM animais a
          JOIN usuarios u ON a.id_usuario = u.id
          JOIN especies e ON a.id_especie = e.id";

$params = [];
$types = '';
$conditions = [];

$conditions[] = "a.disponivel = 1";

$search_term = $_GET['search'] ?? '';
if (!empty($search_term)) {
    $conditions[] = "(a.nome LIKE ? OR a.descricao LIKE ?)";
    $like_term = '%' . $search_term . '%';
    $params[] = $like_term;
    $params[] = $like_term;
    $types .= 'ss';
}

$especie_sel = $_GET['especie'] ?? '';
if ($especie_sel) {
    $conditions[] = "a.id_especie = ?";
    $params[] = $especie_sel;
    $types .= 'i';
}

$porte_sel = $_GET['porte'] ?? '';
if ($porte_sel) {
    $conditions[] = "a.porte = ?";
    $params[] = $porte_sel;
    $types .= 's';
}

$genero_sel = $_GET['genero'] ?? '';
if ($genero_sel) {
    $conditions[] = "a.genero = ?";
    $params[] = $genero_sel;
    $types .= 's';
}

$especies = [];
$especie_query = "SELECT id, nome FROM especies ORDER BY nome ASC";
$especie_result = $conn->query($especie_query);
if ($especie_result) {
    $especies = $especie_result->fetch_all(MYSQLI_ASSOC);
}

if (!empty($conditions)) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}
$query .= " ORDER BY a.data_cadastro DESC";

$stmt = $conn->prepare($query);
if ($stmt === false) { die("Erro ao preparar a consulta: " . $conn->error); }

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$todos_animais = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>

<section class="container" style="padding-top: 20px;">
    <h2 class="section-heading">Animais para Adoção</h2>

    <div class="filtros">
        <h3>Encontre seu novo amigo</h3>
        <form action="animais.php" method="GET">
            <div class="filter-group search-bar" style="grid-column: 1 / -1;">
                <label for="search" style="display: none;">Buscar</label>
                <input type="text" name="search" id="search" placeholder="Busque por nome ou palavra-chave..." value="<?php echo htmlspecialchars($search_term); ?>">
            </div>

            <div class="filter-group">
                <label for="especie">Espécie:</label>
                <select name="especie" id="especie">
                    <option value="">Todas</option>
                    <?php foreach ($especies as $esp): ?>
                        <option value="<?php echo $esp['id']; ?>" <?php echo ($especie_sel == $esp['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($esp['nome']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <label for="porte">Porte:</label>
                <select name="porte" id="porte">
                    <option value="">Todos</option>
                    <option value="Pequeno" <?php echo ($porte_sel == 'Pequeno') ? 'selected' : ''; ?>>Pequeno</option>
                    <option value="Medio" <?php echo ($porte_sel == 'Medio') ? 'selected' : ''; ?>>Médio</option>
                    <option value="Grande" <?php echo ($porte_sel == 'Grande') ? 'selected' : ''; ?>>Grande</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="genero">Gênero:</label>
                <select name="genero" id="genero">
                    <option value="">Ambos</option>
                    <option value="Macho" <?php echo ($genero_sel == 'Macho') ? 'selected' : ''; ?>>Macho</option>
                    <option value="Fêmea" <?php echo ($genero_sel == 'Fêmea') ? 'selected' : ''; ?>>Fêmea</option>
                </select>
            </div>
            
            <button type="submit" class="btn-secondary" style="grid-column: 1 / -1;">Filtrar e Buscar</button>
        </form>
    </div>

    <div class="galeria-animais">
        <?php if (!empty($todos_animais)): ?>
            <?php foreach ($todos_animais as $animal): ?>
                <div class="animal-card">
                    <img src="<?php echo $animal['foto_url'] 
                        ? 'uploads/' . htmlspecialchars($animal['foto_url']) 
                        : 'static/img/placeholder.png'; ?>" 
                        alt="Foto do <?php echo htmlspecialchars($animal['nome']); ?>">
                    <h3><?php echo htmlspecialchars($animal['nome']); ?></h3>
                    <p><?php echo htmlspecialchars($animal['nome_especie']); ?> - Idade: <?php echo htmlspecialchars($animal['idade']); ?></p>
                    <p>Doador(a): <?php echo htmlspecialchars($animal['nome_doador']); ?></p>
                    <div class="card-actions">
                        <a href="animal_detalhes.php?id=<?php echo $animal['id']; ?>" class="btn-primary btn-small">Ver Detalhes</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center; grid-column: 1 / -1;">Nenhum animal encontrado com os filtros selecionados.</p>
        <?php endif; ?>
    </div>
</section>

<?php include 'templates/footer.php'; ?>
