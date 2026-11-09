<?php
define('DATA_FILE', 'alumnes.json');

// Inicialitza el fitxer JSON en format de llista buida si no existeix
if (!file_exists(DATA_FILE) || filesize(DATA_FILE) === 0) {
    file_put_contents(DATA_FILE, json_encode([], JSON_PRETTY_PRINT));
}

// LLEGIR DADES DEL FITXER
function llegirAlumnes() {
    $json = file_get_contents(DATA_FILE);
    return json_decode($json, true) ?: [];
}

// GUARDAR DADES AL FITXER
function guardarAlumnes($alumnes) {
    file_put_contents(DATA_FILE, json_encode(array_values($alumnes), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// Detectem quina acció ens demanen a través de la URL (?action=xxx)
$action = $_GET['action'] ?? '';

// GESTIÓ D'ELIMINACIÓ: index.php?action=eliminar&id=XXX
if ($action === 'eliminar') {
    $id_a_eliminar = $_GET['id'] ?? '';
    if ($id_a_eliminar !== '') {
        $alumnes = llegirAlumnes();
        $alumnes = array_filter($alumnes, function($a) use ($id_a_eliminar) {
            return strval($a['id']) !== strval($id_a_eliminar);
        });
        guardarAlumnes($alumnes);
    }
    header('Location: index.php', true, 303);
    exit;
}

// GESTIÓ D'ACTUALITZACIÓ DE NOTA: index.php?action=actualitzar-nota (via POST)
if ($action === 'actualitzar-nota' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_alumne = $_POST['id'] ?? '';
    $nota = $_POST['nota'] ?? '';
    
    if ($id_alumne !== '') {
        $alumnes = llegirAlumnes();
        foreach ($alumnes as &$a) {
            if (strval($a['id']) === strval($id_alumne)) {
                $a['nota'] = ($nota === '') ? null : floatval($nota);
                break;
            }
        }
        guardarAlumnes($alumnes);
    }
    header('Location: index.php', true, 303);
    exit;
}

// GESTIÓ DE REGISTRE: index.php?action=afegir (via POST)
if ($action === 'afegir' && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nom'])) {
    $id_unic = round(microtime(true) * 1000); 
    
    $nou_alumne = [
        "id" => $id_unic,
        "nom" => $_POST['nom'] ?? '',
        "email" => $_POST['email'] ?? '',
        "nota" => null
    ];

    $alumnes = llegirAlumnes();
    $alumnes[] = $nou_alumne;
    guardarAlumnes($alumnes);

    header('Location: index.php', true, 303);
    exit;
}

// RUTA PRINCIPAL: Carrega i mostra la llista d'alumnes
$alumnes = llegirAlumnes();
$files_taula = "";

foreach ($alumnes as $a) {
    $a_id = $a['id'] ?? '';
    $a_nom = htmlspecialchars($a['nom'] ?? '', ENT_QUOTES, 'UTF-8');
    $a_email = htmlspecialchars($a['email'] ?? '', ENT_QUOTES, 'UTF-8');
    $a_nota = $a['nota'] !== null ? $a['nota'] : '';

    $files_taula .= "<tr>
        <td>{$a_nom}</td>
        <td>{$a_email}</td>
        <td>
            <form method='POST' action='index.php?action=actualitzar-nota' style='background:none; padding:0; margin:0; display:inline-flex; width:100%; gap:5px;'>
                <input type='hidden' name='id' value='{$a_id}'>
                <input type='number' name='nota' value='{$a_nota}' min='0' max='10' step='0.1' placeholder='N/A' style='width:60px; margin:0; padding:4px;'>
                <button type='submit' style='width:auto; padding:4px 8px; font-size:12px; background:#28a745;'>Desar</button>
            </form>
        </td>
        <td>
            <a href='index.php?action=eliminar&id={$a_id}' class='btn-delete'>Eliminar</a>
        </td>
    </tr>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Introducció al núvol</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 40px auto; padding: 20px; }
        form { background: #f4f4f9; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        input { width: 95%; padding: 8px; margin: 8px 0; }
        button { background: #007bff; color: white; padding: 10px; border: none; width: 100%; border-radius: 4px; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #f2f2f2; }
        .btn-delete { color: #dc3545; text-decoration: none; font-weight: bold; }
        .btn-delete:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>Seminari: Introducció al núvol</h1>
    
    <!-- Enviem l'alta a index.php?action=afegir -->
    <form method="POST" action="index.php?action=afegir">
        <h3>Registrar nou alumne</h3>
        <label>Nom:</label>
        <input type="text" name="nom" required>
        <label>Email:</label>
        <input type="email" name="email" required>
        <button type="submit">Enviar</button>
    </form>

    <h2>Alumnes Inscrits</h2>
    <table>
        <tr>
            <th>Nom</th>
            <th>Email</th>
            <th style="width:140px;">Nota</th>
            <th>Accions</th>
        </tr>
        <?php if (empty($alumnes)): ?>
            <tr><td colspan="4" style="text-align: center; color: #888;">No hi ha cap alumne inscrit hores d'ara.</td></tr>
        <?php else: ?>
            <?= $files_taula ?>
        <?php endif; ?>
    </table>
</body>
</html>
