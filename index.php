<?php

use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
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
    public $quantity;
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
    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }
    public function getQuantity() {
        return $this->quantity;
    }
}

$bot = new User($botToken, $config);


/*
** Commands of the bot starts from this section
**
** firstStep - Enter Name
** secondStep - Choose items from menu
** thirdStep - Enter Delivery Address
** fourthStep - send QR
*/
$bot->onCommand('start', 'firstStep');

function firstStep(User $bot) {

    $bot->setName("NA");
    $bot->setDeliveryAddress("NA");
    $bot->setTotalPrice(0);
    $bot->setQuantity(0);

$msg = "
How to use the bot?
Here are the few instructions that will help you to use the bot:

1- Send your name to the bot in the form of 'My name is your name'.

2- Select the categories of items you want to purchase. As of now we have three categories - Household items, Medicine and Food items.

3- Select the items you want to purchase and give the quantity. How many of that particular product you want?

4- The bot will display the total price of items you want from that category. If you want to purchase more items from some other category again give /categories command.

5- At last when you are done shopping from store reply 'DONE'.

6- Then choose the type of delivery you want 'Walk in' or 'Deliver at home'.

7- On choosing Deliver at home bot will send you a QR code. Do the payment and shopkeeper will deliver at your home.

8- Thanks for shopping with us. Hope you enjoyed our service.
";

    $bot->sendMessage("$msg");
}

/*
**  Main Category choosing menu
**  Choose between:
**  1. Food Items
**  2. Household Items
**  3. Medicines
**  4. Electronics Items
*/

$bot->onCommand('categories', 'mainCatMenu');

function mainCatMenu(User $bot)
{
    $bot->sendMessage('Choose Category:', [
        'reply_markup' => InlineKeyboardMarkup::make()
            ->addRow(
                InlineKeyboardButton::make(
                    'Food items',
                callback_data: 'type:a'
                ),
            )
            ->addRow(
                InlineKeyboardButton::make(
                    'Household items',
                callback_data: 'type:b'
                ),
            )
            ->addRow(
                InlineKeyboardButton::make(
                    'Medicines',
                callback_data: 'type:c'
                ),
            )
    ]);
}

$bot->onCallbackQueryData('type:a', function (User $bot) {
    $bot->answerCallbackQuery([
        'text' => 'You selected Food items'
    ]);
    foodMenu($bot);
});

$bot->onCallbackQueryData('type:b', function (User $bot) {
    $bot->answerCallbackQuery([
        'text' => 'You selected Household items'
    ]);
    householdMenu($bot);
});

$bot->onCallbackQueryData('type:c', function (User $bot) {
    $bot->answerCallbackQuery([
        'text' => 'You selected Medicines'
    ]);
    medicineMenu($bot);
});


/*
** Main Category Menu Ends
** 
** Now the food menu, choose from:
** 1. Natkhat
** 2. Lays
** 3. Maggie
** 4. Oats
** 5. Pepsi
*/

function foodMenu(User $bot)
{
    $bot->sendMessage('Choose Food Item from this list:', [
        'reply_markup' => InlineKeyboardMarkup::make()
            ->addRow(
                InlineKeyboardButton::make(
                    'Natkhat',
                callback_data: 'food:a'
                ),
            )
            ->addRow(
                InlineKeyboardButton::make(
                    'Lays',
                callback_data: 'food:b'
                ),
            )
            ->addRow(
                InlineKeyboardButton::make(
                    'Maggie',
                callback_data: 'food:c'
                ),
            )
            ->addRow(
                InlineKeyboardButton::make(
                    'Oats',
                callback_data: 'food:d'
                ),
            )
            ->addRow(
                InlineKeyboardButton::make(
                    'Pepsi',
                callback_data: 'food:e'
                ),
            )
    ]);
}

$bot->onCallbackQueryData('food:a', function (User $bot) {
    $bot->answerCallbackQuery([
        'text' => 'You selected Natkhat'
    ]);
});

$bot->onCallbackQueryData('food:b', function (User $bot) {
    $bot->answerCallbackQuery([
        'text' => 'You selected Lays'
    ]);
});

$bot->onCallbackQueryData('food:c', function (User $bot) {
    $bot->answerCallbackQuery([
        'text' => 'You selected Maggie'
    ]);
});

$bot->onCallbackQueryData('food:d', function (User $bot) {
    $bot->answerCallbackQuery([
        'text' => 'You selected Oats'
    ]);
});

$bot->onCallbackQueryData('food:e', function (User $bot) {
    $bot->answerCallbackQuery([
        'text' => 'You selected Pepsi'
    ]);
});


/*
** Food Menu Ends
** 
** Now the Houshold Items menu, choose from:
** 1. Harpic
** 2. Vim Bar
** 3. Rin Bar
** 4. Bathing Soap
** 5. Surf Excel
*/

function householdMenu(User $bot)
{
    $bot->sendMessage('Choose Food Item from this list:', [
        'reply_markup' => InlineKeyboardMarkup::make()
            ->addRow(
                InlineKeyboardButton::make(
                    'Harpic',
                callback_data: 'house:a'
                ),
            )
            ->addRow(
                InlineKeyboardButton::make(
                    'Vim Bar',
                callback_data: 'house:b'
                ),
            )
            ->addRow(
                InlineKeyboardButton::make(
                    'Rin Bar',
                callback_data: 'house:c'
                ),
            )
            ->addRow(
                InlineKeyboardButton::make(
                    'Bathing Soap',
                callback_data: 'house:d'
                ),
            )
            ->addRow(
                InlineKeyboardButton::make(
                    'Surf Excel',
                callback_data: 'house:e'
                ),
            )
    ]);
}

$bot->onCallbackQueryData('house:a', function (User $bot) {
    $bot->answerCallbackQuery([
        'text' => 'You selected Harpic'
    ]);
});

$bot->onCallbackQueryData('house:b', function (User $bot) {
    $bot->answerCallbackQuery([
        'text' => 'You selected Vim Bar'
    ]);
});

$bot->onCallbackQueryData('house:c', function (User $bot) {
    $bot->answerCallbackQuery([
        'text' => 'You selected Rin Bar'
    ]);
});

$bot->onCallbackQueryData('house:d', function (User $bot) {
    $bot->answerCallbackQuery([
        'text' => 'You selected Bathing Soap'
    ]);
});

$bot->onCallbackQueryData('house:e', function (User $bot) {
    $bot->answerCallbackQuery([
        'text' => 'You selected Surf Excel'
    ]);
});


/*
** Household Menu Ends
** 
** Now the Medicine menu, choose from:
** 1. Combiflam
** 2. Paracetamol
** 3. Betadine
** 4. Whisper
** 5. Vicks
*/

function medicineMenu(User $bot)
{
    $bot->sendMessage('Choose Medicine from this list:', [
        'reply_markup' => InlineKeyboardMarkup::make()
            ->addRow(
                InlineKeyboardButton::make(
                    'Combiflam',
                callback_data: 'medi:a'
                ),
            )
            ->addRow(
                InlineKeyboardButton::make(
                    'Paracetamol',
                callback_data: 'medi:b'
                ),
            )
            ->addRow(
                InlineKeyboardButton::make(
                    'Betadine',
                callback_data: 'medi:c'
                ),
            )
            ->addRow(
                InlineKeyboardButton::make(
                    'Whisper',
                callback_data: 'medi:d'
                ),
            )
            ->addRow(
                InlineKeyboardButton::make(
                    'Vicks',
                callback_data: 'medi:e'
                ),
            )
    ]);
}

$bot->onCallbackQueryData('medi:a', function (User $bot) {
    $bot->answerCallbackQuery([
        'text' => 'You selected Combiflam'
    ]);
});

$bot->onCallbackQueryData('medi:b', function (User $bot) {
    $bot->answerCallbackQuery([
        'text' => 'You selected Paracetamol'
    ]);
});

$bot->onCallbackQueryData('medi:c', function (User $bot) {
    $bot->answerCallbackQuery([
        'text' => 'You selected Betadine'
    ]);
});

$bot->onCallbackQueryData('medi:d', function (User $bot) {
    $bot->answerCallbackQuery([
        'text' => 'You selected Whisper'
    ]);
});

$bot->onCallbackQueryData('medi:e', function (User $bot) {
    $bot->answerCallbackQuery([
        'text' => 'You selected Vicks'
    ]);
});


/*
**  
*/
// $bot->onCommand('categories', function (Nutgram $bot) {

//     class AskIceCreamConversation extends Conversation {

//         protected ?string $step = 'askCupSize';
    
//         public $cupSize;
    
//         public function askCupSize(Nutgram $bot)
//         {
//             $bot->sendMessage('How big should be you ice cream cup?', [
//                 'reply_markup' => InlineKeyboardMarkup::make()
//                     ->addRow(InlineKeyboardButton::make('Small', callback_data: 'S'), InlineKeyboardButton::make('Medium', callback_data: 'M'))
//                     ->addRow(InlineKeyboardButton::make('Big', callback_data: 'L'), InlineKeyboardButton::make('Super Big', callback_data: 'XL')),
//             ]);
//             $this->next('askFlavors');
//         }
    
//         public function askFlavors(Nutgram $bot)
//         {
//             // if is not a callback query, ask again!
//             if (!$bot->isCallbackQuery()) {
//                 $this->askCupSize($bot);
//                 return;
//             }
    
//             $this->cupSize = $bot->callbackQuery()->data;
    
//             $bot->sendMessage('What flavors do you like?');
//             $this->next('recap');
//         }
    
//         public function recap(Nutgram $bot)
//         {
//             $flavors = $bot->message()->text;
//             $bot->sendMessage("You want an $this->cupSize cup with this flavors: $flavors");
//             $this->end();
//         }
//     }

// });




$bot->onText('My name is {name}', function (User $bot, string $name) {
    $bot->sendMessage("Hi $name");
    $bot->sendMessage("Let me store your name in my database.");

    $bot->setName($name);
    $naam = $bot->getName();
    $bot->sendMessage("$naam is stored in my database. You can now proceed with your shopping!");

    $bot->sendMessage("Here's the categories of product we have. Reply /categories to know more");
});


/*
** Let's run the bot now!
** Let this bot listen to your needs!
*/
$bot->run();
?>