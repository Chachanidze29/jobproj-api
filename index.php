<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");
header('Content-type: application/json');

include ('./utils/DBConnect.php');
include ('./services/ProductService.php');

use services\ProductService;
use utils\DBConnect;

$db = new DBConnect();
$conn = $db->connect();

$service = new ProductService($conn);

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        echo $service->getProducts();
        break;

    case "POST":
        $product = json_decode((file_get_contents('php://input')));
        $res = $service->insert($product,$product->type);
        if(is_string($res)) {
            http_response_code(409);
            echo $res;
        }
        break;

    case "DELETE":
        $skus = explode(',',explode('/', $_SERVER['REQUEST_URI'])[3]);
        $service->deleteProducts($skus);
        break;
}


