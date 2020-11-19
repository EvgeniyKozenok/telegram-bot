<?php


namespace App\Telegram\Classes;

class Quotes extends TelegramBase
{
    private $characterId;

    public function __construct($chatId, $characterId)
    {
        parent::__construct($chatId);
        $this->characterId = $characterId;
    }

    public function handle()
    {
        $this->sendChatAction();

        $this->get(sprintf('quotes/characters/%s', $this->characterId));

        $res = '';
        foreach ($this->apiResponse['data'] as $i => $quote) {
            $res .= sprintf('%s - %s', PHP_EOL . ($i + 1), $quote['quote']);
        }

        $this->sendMessage($res);
    }

}
