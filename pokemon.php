<?php

session_start();
var_dump($_POST);

// Vérification des champs POST
if (!isset($_POST['Nom']) || empty($_POST['Nom'])) {
    header("Location: index.php?message=Veuillez remplir l'une des deux champs !");
    exit();
} 

$nomRecherche = strtolower($_POST['Nom']); // Utiliser minuscule pour éviter les problèmes de casse
$result = 0;

// Connexion à l'API
$curl_request = curl_init();
$api_url = 'https://tyradex.vercel.app/api/v1/pokemon';
$connectionTimeout = 15;

curl_setopt_array($curl_request, [
    CURLOPT_URL            => $api_url,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_CONNECTTIMEOUT => $connectionTimeout,
]);

$response = curl_exec($curl_request);
curl_close($curl_request);

if (!$response) {
    header("Location: index.php?message=Erreur lors de la connexion à l'API");
    exit();
}

// Conversion en tableau PHP
$response = json_decode($response, true);

if (!is_array($response)) {
    header("Location: index.php?message=Erreur de format des données renvoyées par l'API");
    exit();
}

// Tableau simplifié pour les pokémons
$pokemons = [];
$idCorrespondant = null;

foreach ($response as $pokemon) {
    // Vérifier que l'ID et le nom (au moins en français ou anglais) existent
    if (isset($pokemon['pokedex_id']) && isset($pokemon['name']['fr'])) {
        $pokemons[$pokemon['pokedex_id']] = [
            'id'         => $pokemon['pokedex_id'],
            'generation' => $pokemon['generation'] ?? 'Inconnue',
            'category'   => $pokemon['category'] ?? 'Inconnue',
            'name'       => $pokemon['name']['fr'], // Utilise le nom en français
            'image'      => $pokemon['sprites']['regular'] ?? '', // Image régulière
            'types'      => !empty($pokemon['types']) ? array_map(function ($type) {
                return [
                    'name'  => $type['name'] ?? '',
                    'image' => $type['image'] ?? '',
                ];
            }, $pokemon['types']) : [], // Si vide, un tableau vide
        ];
    } 
}

// Recherche du Pokémon correspondant au nom entré
foreach ($pokemons as $pokemon) {
    if (strtolower($pokemon['name']) === $nomRecherche) { 
        $idCorrespondant = $pokemon['id'];
        break; 
    }
}

// Stockage dans la session
$_SESSION['pokemons'] = $pokemons;

if ($idCorrespondant !== null) {
    // Récupérer l'image, la génération, etc.
    $image = urlencode($pokemon['sprites']['regular']);
    $generation = urlencode($pokemon['generation']);
    $category = urlencode($pokemon['category']);
    $name = urlencode($pokemon['name']);
    
    // Concaterner les types en une seule chaîne séparée par des virgules
    $types = [];
    foreach ($pokemon['types'] as $type) {
        $types[] = urlencode($type['name'] ?? 'Inconnu');
    }
    $typesStr = implode(',', $types); // Concaténer tous les types dans une chaîne

    header("Location: index.php?id=$idCorrespondant&gen=$generation&cat=$category&name=$name&img=$image&type=$typesStr");
} else {
    header("Location: index.php?message=Nom introuvable");
}
exit();

?>
