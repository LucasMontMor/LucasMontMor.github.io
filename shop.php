<?php
// Carregar os dados dos itens
$data = json_decode(file_get_contents("items.json"), true);

// Obter parâmetros da URL
$itemCode = $_GET['itemCode'] ?? null;
$playerCoins = $_GET['coins'] ?? null;

if (!$itemCode || !$playerCoins) {
    echo json_encode(["error" => "Parâmetros inválidos"]);
    exit;
}

// Verificar se o item existe
if (!isset($data['items'][$itemCode])) {
    echo json_encode(["error" => "Item não encontrado"]);
    exit;
}

$item = $data['items'][$itemCode];
$price = $item['price'];

// Verificar moedas do jogador
if ($playerCoins >= $price) {
    echo json_encode([
        "success" => true,
        "item" => $item,
        "remainingCoins" => $playerCoins - $price
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Moedas insuficientes"
    ]);
}
?>