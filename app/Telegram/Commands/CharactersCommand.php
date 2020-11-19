<?php

namespace App\Telegram\Commands;

use App\Telegram\Classes\Characters;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class CharactersCommand extends Command
{

    /**
     * @var string Command Name
     */
    protected $name = 'characters';

    /**
     * @var string Command Description
     */
    protected $description = 'Displays a list of characters with pagination of 3 pieces';

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $updates = Telegram::getWebhookUpdates();
        (new Characters($updates['message']['chat']['id']))->handle();
    }
}
