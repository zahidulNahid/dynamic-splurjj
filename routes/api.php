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
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\MobileMockUpController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SubCategoryController;
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




Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('me', [AuthController::class, 'me'])->middleware('auth:api');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');





Route::post('password/email', [AuthController::class, 'sendResetOTP']);
Route::post('password/verify-otp', [AuthController::class, 'verifyResetOTP'])->name('password.verify-otp');
Route::post('password/reset', [AuthController::class, 'passwordReset'])->name('password.reset');


// //settings(backend) which is namely settings
Route::middleware('auth:api')->group(function () {
    Route::put('settings/password', [SettingController::class, 'storeOrUpdatePassword']);
    Route::post('settings/info', [SettingController::class, 'storeOrUpdate']);
});


Route::middleware('auth:api','cors')->group(function () {

    // Videos API resource

    /*shows all data as subcategory */


    Route::get('contents/', [ContentController::class, 'index']);

    //when single content is given in dashboard(edit single content)
    Route::get('contents/{cat_id}/{sub_id}/{id}', [ContentController::class, 'index']);


    //when all content is shown in dashboard for every subcategory
    Route::get('contents/{cat_id}/{sub_id}', [ContentController::class, 'indexForSubCategory']);




    Route::post('contents/', [ContentController::class, 'store']);
    Route::put('contents/{id}', [ContentController::class, 'update']);
    Route::delete('contents/{id}', [ContentController::class, 'destroy']);


    // Categories API resource
    Route::apiResource('categories', CategoryController::class);

    // Subcategories API resource
    Route::apiResource('subcategories', SubCategoryController::class);
});



//get latest 4 content is shown in frontend
Route::get('contents/{cat_id}', [ContentController::class, 'indexFrontend']);


// Go to Frontend and Backend API routes
Route::get('categories', [CategoryController::class, 'index']);
Route::get('subcategories', [SubCategoryController::class, 'index']);




/* create by abu sayed (end)*/



Route::options('{any}', function () {
    return response()->json([], 204);
})->where('any', '.*');