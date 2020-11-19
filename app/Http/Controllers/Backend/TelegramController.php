<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Telegram\Classes\Characters;
use App\Telegram\Classes\Quotes;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function webhook()
    {
        Telegram::commandsHandler(true);
        $updates = Telegram::getWebhookUpdates();

        if ($updates && $updates->isType('callback_query')) {
            $query = $updates->getCallbackQuery();
            $data = $query->getData();

            $pagePrefix = Characters::getPageCallbackDataPrefix();
            $quotePrefix = Characters::getQuoteCallbackDataPrefix();
            $chatId = $query['message']['chat']['id'];
            if (strpos($data, $pagePrefix) === 0) {
                $requestPage = str_replace($pagePrefix, '', $data);
                (new Characters($chatId, $requestPage))->handle();
            }
            if (strpos($data, $quotePrefix) === 0) {
                $characterName = str_replace($quotePrefix, '', $data);
                (new Quotes($chatId, $characterName))->handle();
            }
        }
    }
}
