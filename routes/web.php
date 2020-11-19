<?php

use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/' . Telegram::getBotConfig()['token'] . '/webhook', function () {
    app(App\Http\Controllers\Backend\TelegramController::class)->webhook();
});

Route::get('/', function () {
    $config = Telegram::getBotConfig();
    Telegram::setWebhook(['url' => $config['ngrok_url'] . $config['webhook_url']]);
    Telegram::getWebhookUpdates();
    echo 'ok';
});
