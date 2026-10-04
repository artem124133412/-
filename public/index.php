<?php
require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();
$brand = $request->query->get('brand');

$cars = [
    'BMW' => [
        ['model' => 'M3', 'hp' => 503, 'type' => 'Седан'],
        ['model' => 'X5', 'hp' => 335, 'type' => 'Кросовер'],
    ],
    'Toyota' => [
        ['model' => 'Camry', 'hp' => 204, 'type' => 'Седан'],
    ]
];

if ($brand === null) {
    $response = new JsonResponse(['brands' => array_keys($cars)]);
} elseif (isset($cars[$brand])) {
    $response = new JsonResponse(['brand' => $brand, 'models' => $cars[$brand]]);
} else {
    $response = new JsonResponse(['error' => "Марки «{$brand}» немає"], 404);
}

$response->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
$response->send();