<?php

use SergiX44\Nutgram\Nutgram;

require './vendor/autoload.php';


/*
** Bot configuration. This $botToken must not be copied, it is for this
** specific project only.
*/
$botToken = '6227854714:AAGIOFybOQSqD1bx6diwd0qzwPmSz1LZ14k';
$config = [
    'timeout' => 10,
];


/*
** Defining a new class with user extensions extending the Nutgram Bot Class
*/
class User extends Nutgram {
    public $name;
    public $deliveryAddress;
    public $totalPrice;
    public $household = array(0, 0, 0, 0, 0);
    public $medicine = array(0, 0, 0, 0, 0);
    public $food = array(0, 0, 0, 0, 0);

    public function setName($name) {
        $this->name = $name;
    }
    public function getName() {
        return $this->name;
    }
    public function setDeliveryAddress($deliveryAddress) {
        $this->deliveryAddress = $deliveryAddress;
    }
    public function getDeliveryAddress() {
        return $this->deliveryAddress;
    }
    public function setTotalPrice($totalPrice) {
        $this->totalPrice = $totalPrice;
    }
    public function getTotalPrice() {
        return $this->totalPrice;
    }
}

$bot = new User($botToken, $config);


$bot->onCommand('start', function (Nutgram $bot) {
    $bot->sendMessage('Welcome to Ramu General Store!');
    $bot->sendMessage('What is your name?');
    // $user->setName("Harsh");
    // $naam = $user->getName();
    $naam = 'harshit';
    $bot->sendMessage("$naam");
});


$bot->onText('My name is {name}', function (Nutgram $bot, string $name) {
    $bot->sendMessage("Hi $name");
    $bot->sendMessage("Thanks for visiting our store $name");
    $bot->sendMessage("Here's the categories of product we have. Reply /categories to know more");
});


$bot->onCommand('categories', function (Nutgram $bot) {
    $bot->sendMessage("Abe jaa lwde, du tujhe abhi categories");
});

$bot->run();