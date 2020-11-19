<?php


namespace App\Telegram\Classes;


use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class Characters extends TelegramBase
{
    private $inlineKeyboard;
    private $requestPage;

    public function __construct($chatId, $requestPage = 1)
    {
        parent::__construct($chatId);
        $this->inlineKeyboard = [];
        $this->requestPage = $requestPage;
    }

    public static function getPageCallbackDataPrefix()
    {
        return 'page=';
    }

    public static function getQuoteCallbackDataPrefix()
    {
        return 'quotes&characterId=';
    }

    public function handle()
    {
        $requestPage = $this->requestPage;

        $this->sendChatAction();

        $this->get(sprintf('characters?%s&limit=3', self::getPageCallbackDataPrefix() . $requestPage));

        $pagination = $this->apiResponse['pagination'];

        $this->sendMessage("Characters list. Page $requestPage from " . $pagination['totalPages']);

        foreach ($this->apiResponse['data'] as $i => $character) {
            $this->addInlineKeyboardBtn(self::getQuoteCallbackDataPrefix() . $character['id'], 'Quotes');
            $this->sendMessage(sprintf('%s - %s', $i + 1, $character['name']), $this->generateInlineKeyboard());
            $this->inlineKeyboard = [];
        }

        if ($pagination['currentPage'] > 1) {
            $this->addInlineKeyboardBtn(self::getPageCallbackDataPrefix() . ($requestPage - 1), 'prev');
        }

        if ($pagination['currentPage'] != $pagination['totalPages']) {
            $this->addInlineKeyboardBtn(self::getPageCallbackDataPrefix() . ($requestPage + 1), 'next');
        }

        $this->sendMessage('See more:', $this->generateInlineKeyboard());
    }

    private function addInlineKeyboardBtn(string $callBackData, string $btnText)
    {
        array_push(
            $this->inlineKeyboard,
            Keyboard::inlineButton([
                'callback_data' => $callBackData,
                'text' => $btnText
            ]));
    }

    private function generateInlineKeyboard()
    {
        return $this->inlineKeyboard
            ? Keyboard::make([
                'inline_keyboard' => [
                    $this->inlineKeyboard
                ],
                'resize_keyboard' => true,
                'one_time_keyboard' => false
            ])
            : Telegram::replyKeyboardHide();
    }

}
