<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\User\PartyController;
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
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', [LoginController::class, 'logout']);

    Route::get('user', [UserController::class, 'current']);

    Route::patch('settings/profile', [ProfileController::class, 'update']);
    Route::patch('settings/password', [PasswordController::class, 'update']);

    Route::post('reserve', 'User\ReservationController@reserve');
    Route::post('books', 'User\ReservationController@books');
    Route::post('reserve/cancel', 'User\ReservationController@cancelReservation');

    Route::post('toggle/favorite', 'User\PartyController@toggleFavorite');
    Route::post('upload/avatar', [UserController::class, 'uploadAvatar']);
    
    Route::post('profileCommentUpdate', [ProfileController::class, 'profileCommentUpdate']);
    Route::post('profileDataUpdate', [ProfileController::class, 'profileDataUpdate']);
    
    Route::post('saveSearchCondition', 'User\SearchController@saveSearchCondition');
    Route::post('search/delete', 'User\SearchController@deleteSearch');
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('register', [RegisterController::class, 'register']);

    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('password/reset', [ResetPasswordController::class, 'reset']);

    Route::post('email/verify/{user}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [VerificationController::class, 'resend']);

    Route::post('oauth/{driver}', [OAuthController::class, 'redirect']);
    Route::get('oauth/{driver}/callback', [OAuthController::class, 'handleCallback'])->name('oauth.callback');
});

Route::post('getRecentPartys', [PartyController::class, 'getRecentPartys']);
Route::post('party/{id}', [PartyController::class, 'getDetail']);
Route::post('profileMainUpdate', [ProfileController::class, 'profileMainUpdate']);

Route::post('master/data', [ProfileController::class, 'getMasterData']);
Route::post('rooms', [ProfileController::class, 'getRooms']);
Route::post('search', 'User\SearchController@search');