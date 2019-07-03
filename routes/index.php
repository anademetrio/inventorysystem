<?php
use function src\{ slimConfiguration, basicAuth };
use App\Controllers\ProductController;
use App\Controllers\CategoryController;
use App\Controllers\InventoryController;
use App\Controllers\StoreController;
use App\Controllers\TransferController;
use App\Controllers\UserController;


$app = new \Slim\App(slimConfiguration());

// =================================================================

$app->group('', function() use ($app) {
    // Products
    $app->get('/products', ProductController::class . ':getProducts');

    $app->get('/products/{id}', ProductController::class . ':getByID');
    $app->post('/products', ProductController::class . ':insertProduct');
    $app->put('/products/{id}', ProductController::class . ':updateProduct');
    $app->delete('/products/{id}', ProductController::class . ':deleteProduct');

    //Categories
    $app->get('/categories', CategoryController::class . ':getCategories');
    $app->post('/categories', CategoryController::class . ':insertCategory');
    $app->put('/categories/{id}', CategoryController::class . ':updateCategory');
    $app->delete('/categories/{id}', CategoryController::class . ':deleteCategory');

    //Inventories
    $app->get('/inventories', InventoryController::class . ':getInventories');
    $app->get('/inventories/stock/{id}', InventoryController::class . ':getInventoryStock');
    $app->get('/inventories/store/{store_id}/stock/{product_id}', InventoryController::class . ':getInventoryStoreStock');
    $app->post('/inventories', InventoryController::class . ':insertInventory');
    $app->put('/inventories/{id}', InventoryController::class . ':updateInventory');
    $app->delete('/inventories/{id}/product/{product_id}', InventoryController::class . ':deleteInventory');


    //Stores
    $app->get('/stores', StoreController::class . ':getStores');
    $app->post('/stores', StoreController::class . ':insertStore');
    $app->put('/stores/{id}', StoreController::class . ':updateStore');
    $app->delete('/stores/{id}', StoreController::class . ':deleteStore');

    //Transfers
    $app->get('/transfers', TransferController::class . ':getTranfers');
    $app->post('/transfers', TransferController::class . ':insertTranfer');
    $app->put('/transfers/{id}', TransferController::class . ':updateTranfer');
    $app->delete('/transfers/{id}', TransferController::class . ':deleteTranfer');

    //Users
    $app->get('/users', UserController::class . ':getUsers');
    $app->post('/users', UserController::class . ':insertUser');
    $app->post('/users/login', UserController::class . ':loginUser');
    $app->put('/users/{id}', UserController::class . ':updateUser');
    $app->delete('/users/{id}', UserController::class . ':deleteUser');
});/* ->add(basicAuth() )*/



// =================================================================

$app->run();