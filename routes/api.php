<?php

use App\Http\Controllers\AchieveController;
use App\Http\Controllers\Body1Controller;
use App\Http\Controllers\Body2Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\HeaderController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\MobileMockUpController;
use App\Http\Controllers\UpdateController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/* sozib  */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
    Route::get('/hero', [HeroController::class, 'show']);
    Route::post('/hero', [HeroController::class, 'storeOrUpdate']);
});
Route::middleware('auth:api')->group(function () {
    Route::get('/body1', [Body1Controller::class, 'show']);
    Route::post('/body1', [Body1Controller::class, 'storeOrUpdate']);
});
Route::middleware('auth:api')->group(function () {
    Route::get('/body2', [Body2Controller::class, 'show']);
    Route::post('/body2', [Body2Controller::class, 'storeOrUpdate']);
});
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('me', [AuthController::class, 'me'])->middleware('auth:api');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');


//for headers 
Route::middleware('auth:api')->group(function () {
    Route::get('/header', [HeaderController::class, 'show']);
    Route::post('/header', [HeaderController::class, 'storeOrUpdate']);

});


//for banners 
Route::middleware('auth:api')->group(function () {
    Route::get('/banner', [BannerController::class, 'show']);
    Route::post('/banner', [BannerController::class, 'storeOrUpdate']);

});

//for features
Route::middleware('auth:api')->group(function () {
    Route::get('/feature', [FeatureController::class, 'show']);
    Route::post('/feature', [FeatureController::class, 'storeOrUpdate']);

});

//for footers
Route::middleware('auth:api')->group(function () {
    Route::get('/footer', [FooterController::class, 'show']);
    Route::post('/footer', [FooterController::class, 'storeOrUpdate']);

});

//for mobileMockUp
Route::middleware('auth:api')->group(function () {
    Route::get('/mobilemockup', [MobileMockUpController::class, 'show']);
    Route::post('/mobilemockup', [MobileMockUpController::class, 'storeOrUpdate']);

});

//for 
Route::middleware('auth:api')->group(function () {
    Route::get('/achieve', [AchieveController::class, 'show']);
    Route::post('/achieve', [AchieveController::class, 'storeOrUpdate']);

});

//for update email and password
Route::middleware('auth:api')->group(function () {
    Route::get('/updateEp', [UpdateController::class, 'show']);
    Route::post('/updateEp', [UpdateController::class, 'UpdateEP']);

});


Route::get('/frontend-data', [FrontendController::class, 'getAllData']);
Route::post('/contactMessage', [ContactMessageController::class, 'store']);
// Route::post('/Message', [ContactMessageController::class, 'store']);

Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);

