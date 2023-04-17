<?php

use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

require './vendor/autoload.php';

$botToken = '6227854714:AAGIOFybOQSqD1bx6diwd0qzwPmSz1LZ14k';

$bot = new Nutgram($botToken);

$bot->onCommand('start', function (Nutgram $bot) {
    $bot->sendMessage('Welcome to Ramu General Store!');
    $bot->sendMessage('What is your name?');
});

$bot->onText('My name is {name}', function (Nutgram $bot, string $name) {
    $bot->sendMessage("Hi $name");
    $bot->sendMessage("Thanks for visiting our store $name");
    $bot->sendMessage("Here's the categories of product we have. Reply /categories to know more");
});

$bot->onCommand('categories', function ($command) use ($bot) {
    $keyboard = $bot->inlineKeyboard([
        [
            $bot->inlineButton('Pizza', 'pizza'),
            $bot->inlineButton('Burger', 'burger')
        ],
        [
            $bot->inlineButton('Hot dog', 'hot_dog'),
            $bot->inlineButton('Sandwich', 'sandwich')
        ]
    ]);

    $bot->sendMessage('Please choose a food item:', [
        'reply_markup' => $keyboard
    ]);
});

$bot->onCallbackQuery(function ($query) use ($bot) {
    $food_item = $query->data;

    $bot->answerCallbackQuery([
        'callback_query_id' => $query->id,
        'text' => 'You have selected ' . $food_item . '. Please enter the quantity:'
    ]);

    // Save the selected food item to a database or use it in a function
    $bot->userStorage()->put($query->from->id, 'food_item', $food_item);
});

$bot->onMessage(function ($message) use ($bot) {
    $quantity = intval($message->text);

    if ($quantity > 0) {
        // Get the selected food item from the user storage
        $food_item = $bot->userStorage()->get($message->from->id, 'food_item');

        // Calculate the total price
        $price = $quantity * 10; // Replace 10 with the actual price of the selected food item

        $bot->sendMessage('Your order is: ' . $food_item . ' x ' . $quantity . ' = $' . $price);
    } else {
        $bot->sendMessage('Invalid quantity. Please enter a positive integer.');
    }
});



$bot->run();