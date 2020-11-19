<?php


namespace App\Telegram\Classes;


use App\Telegram\ApiCredentialsTrait;
use Telegram\Bot\Actions;
use Telegram\Bot\Laravel\Facades\Telegram;

abstract class TelegramBase
{
    use ApiCredentialsTrait;

    private $chatId;

    protected $apiResponse;

    public function __construct($chatId)
    {
        $this->chatId = $chatId;
    }

    abstract function handle();

    protected function get($path)
    {
        try {
            $this->apiResponse = $this->testApiGetRequest($path);
        } catch (\Exception $e) {
            // todo handle exception
            exit;
        }

        if (!$this->apiResponse['success']) {
            $this->sendMessage($this->apiResponse['error']['message']);
            exit;
        }
    }

    protected function sendChatAction($action = Actions::TYPING)
    {
        Telegram::sendChatAction([
            'chat_id' => $this->chatId,
            'action' => $action
        ]);
    }

    protected function sendMessage(string $msg, $replyMarkup = null)
    {
        $response = [
            'chat_id' => $this->chatId,
            'text' => $msg
        ];

        if ($replyMarkup) {
            $response['reply_markup'] = $replyMarkup;
        }

        Telegram::sendMessage($response);
    }
}
