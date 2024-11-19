<?php
header('Content-Type: application/json'); // Garantir que a resposta seja JSON

$data = json_decode(file_get_contents("items.json"), true);
$itemCode = $_GET['itemCode'] ?? null;
$playerCoins = $_GET['coins'] ?? null;

if (!$itemCode || !$playerCoins) {
    echo json_encode(["success" => false, "message" => "Parâmetros inválidos", "item" => null, "remainingCoins" => 0]);
    exit;
}

if (!isset($data['items'][$itemCode])) {
    echo json_encode(["success" => false, "message" => "Item não encontrado", "item" => null, "remainingCoins" => $playerCoins]);
    exit;
}

$item = $data['items'][$itemCode];
$price = $item['price'];

if ($playerCoins >= $price) {
    echo json_encode([
        "success" => true,
        "message" => "Compra realizada com sucesso",
        "item" => $item,
        "remainingCoins" => $playerCoins - $price
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Moedas insuficientes",
        "item" => null,
        "remainingCoins" => $playerCoins
    ]);
}
?>
