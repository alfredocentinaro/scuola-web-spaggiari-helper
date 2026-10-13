<?php
ini_set('session.use_cookies', '0');
header_remove('Set-Cookie');

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');

$dir = "./";

// Funzione per raccogliere i file da una specifica directory
function scansionaCartella($path) {
    $files = glob($path . "*.{pdf,doc,docx,xls,xlsx}", GLOB_BRACE);
    $lista = [];

    foreach ($files as $filePath) {
        $nomeFile = basename($filePath);
        $estensione = strtolower(pathinfo($nomeFile, PATHINFO_EXTENSION));
        $dimensioneBytes = filesize($filePath);
        $timestamp = filemtime($filePath);

        // Formattazione dimensione
        if ($dimensioneBytes >= 1048576) {
            $dimensione = number_format($dimensioneBytes / 1048576, 1) . ' MB';
        } elseif ($dimensioneBytes >= 1024) {
            $dimensione = number_format($dimensioneBytes / 1024, 0) . ' KB';
        } else {
            $dimensione = $dimensioneBytes . ' B';
        }

        $lista[] = [
            'nome' => $nomeFile,
            'percorso' => str_replace('./', '', $filePath),
            'estensione' => $estensione,
            'dimensione' => $dimensione,
            'timestamp' => $timestamp,
            'data' => date("d/m/Y", $timestamp)
        ];
    }

    // Ordina i file della cartella dal più recente al meno recente
    usort($lista, function($a, $b) {
        return $b['timestamp'] - $a['timestamp'];
    });

    return $lista;
}

$risultato = [];

// 1. Scansiona la cartella PRINCIPALE (file sfusi nella radice)
$filePrincipali = scansionaCartella($dir);
if (!empty($filePrincipali)) {
    $risultato[] = [
        'titolo' => 'Documenti Generali',
        'timestamp_recente' => $filePrincipali[0]['timestamp'], // Il timestamp del file più recente
        'file' => $filePrincipali
    ];
}

// 2. Cerca tutte le SOTTOCARTELLE e le scansiona
$sottocartelle = array_filter(glob($dir . '*'), 'is_dir');

foreach ($sottocartelle as $cartellaPath) {
    $nomeCartella = basename($cartellaPath);
    if (strpos($nomeCartella, '.') === 0) continue; // Ignora cartelle nascoste

    $fileSottocartella = scansionaCartella($cartellaPath . '/');

    if (!empty($fileSottocartella)) {
        $titoloPulito = ucwords(str_replace(['_', '-'], ' ', $nomeCartella));
        
        $risultato[] = [
            'titolo' => $titoloPulito,
            'timestamp_recente' => $fileSottocartella[0]['timestamp'], // Data del file più recente della cartella
            'file' => $fileSottocartella
        ];
    }
}

// 3. ORDINA LE TABELLE/CARTELLE: la cartella con il file più recente appare per PRIMA
usort($risultato, function($a, $b) {
    return $b['timestamp_recente'] - $a['timestamp_recente'];
});

echo json_encode($risultato);
?>
