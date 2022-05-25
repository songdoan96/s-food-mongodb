<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CheckoutController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\UserOrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('/', function () {
    return 'FOOD APP';
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});


Route::apiResource('/product', ProductController::class);

Route::post("/checkout", [CheckoutController::class, 'checkout']);

// Admin
Route::get("/orders", [CheckoutController::class, 'orders'])->middleware('admin');
Route::get("/order/{id}", [CheckoutController::class, 'order'])->middleware('admin');
Route::post("/order-success", [CheckoutController::class, 'orderSuccess'])->middleware('admin');

// User
Route::get("/user-orders", [UserOrderController::class, 'getOrdersUser'])->middleware(['auth:api']);
Route::get("/user-order-detail/{id}", [UserOrderController::class, 'userOrderDetail'])->middleware(['auth:api']);


Route::get("/get-products", [HomeController::class, 'geProducts']);
