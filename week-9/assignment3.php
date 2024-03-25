<?php

class Card {
    private $suit;
    private $rank;

    public function __construct($suit, $rank) {
        // Create a card with a suit and rank
        $this->suit = $suit;
        $this->rank = $rank;
    }

    public function getRank() {
        // Get the rank of the card
        return $this->rank;
    }

    public function displayCard() {
        // Display the card
        echo $this->rank . " of " . $this->suit;
    }

    public function getCardValue() {
        // Get the value of the card
        if (is_numeric($this->rank)) {
            return intval($this->rank);

        } else if ($this->rank === "Ace") {
            return 11;

        } else {
            return 10;
        }
    }
}


function calculateHandValue($cards) {
    $handValue = 0;
    $aceCount = 0;

    // Go through each of the cards and add up the value
    foreach ($cards as $card) {
        $handValue += $card->getCardValue();
        if ($card->getRank() === "Ace") {
            $aceCount++;
        }
    }

    // If the hand value is over 21 and there are aces, change the value of the aces to 1
    while ($handValue > 21 && $aceCount > 0) {
        $handValue -= 10;
        $aceCount--;
    }

    return $handValue;
}

function displayCards($cards) {
    // Go through each of the cards and display them
    foreach ($cards as $card) {
        $card->displayCard();
        echo ", ";
    }
    echo "(value: ";
    echo calculateHandValue($cards);
    echo ")\n";
}

function playRound($money) {
    // Create deck of cards
    $deck = array();
    $suits = array("Hearts", "Diamonds", "Clubs", "Spades");
    $ranks = array("2", "3", "4", "5", "6", "7", "8", "9", "10", "Jack", "Queen", "King", "Ace");

    // Create deck of cards
    foreach ($suits as $suit) {
        foreach ($ranks as $rank) {
            $deck[] = new Card($suit, $rank);
        }
    }

    // Shuffle deck
    shuffle($deck);

    // Draw two cards for the player
    $playerCards = array();
    array_push($playerCards, array_pop($deck));
    array_push($playerCards, array_pop($deck));

    // Draw two cards for the dealer
    $dealerCards = array();
    array_push($dealerCards, array_pop($deck));
    array_push($dealerCards, array_pop($deck));

    // Display player's cards
    echo "Player's cards: ";
    displayCards($playerCards);

    // Display dealer's first card
    echo "Dealer's card: ";
    displayCards(array($dealerCards[0]));


    // Check if player has Blackjack
    if (calculateHandValue($playerCards) === 21) {
        echo "Blackjack! You win!\n";
        $money *= 2;
        return $money;
    }

    // Ask player if they want to hit or stand
    // Until either they bust or they stand
    echo "\nDo you want to hit or stand?\n(hit/stand): ";
    $input = strtolower(readline());

    while ($input === "hit") {
        array_push($playerCards, array_pop($deck));
        echo "Player's cards: ";
        displayCards($playerCards);

        if (calculateHandValue($playerCards) > 21) {
            echo "Bust! You lose!\n";
            return 0;
        }

        echo "Do you want to hit or stand? ";
        $input = strtolower(readline());
    }

    // Dealer's turn
    echo "\nDealers turn\n\n";

    // Display dealer's cards
    echo "Dealer's cards: ";
    displayCards($dealerCards);

    // Dealer's turn
    while (calculateHandValue($dealerCards) < 17) {
        echo "Dealer hits\n\n";
        array_push($dealerCards, array_pop($deck));
        
        // Display dealer's cards
        echo "Dealer's cards: ";
        displayCards($dealerCards);
    }
    echo "Dealer stands\n\n";

    // Display each players hand
    echo "Player's hand: ";
    displayCards($playerCards);
    echo "Dealer's hand: ";
    displayCards($dealerCards);
    echo "\n";

    // Determine the winner
    $playerHandValue = calculateHandValue($playerCards);
    $dealerHandValue = calculateHandValue($dealerCards);

    if ($playerHandValue > 21) {
        echo "Bust! You lose!\n";
        $money = 0;

    } else if ($dealerHandValue > 21) {
        echo "Dealer busts! You win!\n";
        $money *= 2;

    } else if ($playerHandValue > $dealerHandValue) {
        echo "You win!\n";
        $money *= 2;

    } else if ($playerHandValue < $dealerHandValue) {
        echo "You lose!\n";
        $money = 0;

    } else {
        echo "It's a tie!\n";

    }

    return $money;
}

function askToPlayAgain($money) {
    // Display money
    echo "You won $" . $money . "!\n";

    // Ask user if they want to play again
    echo "Do you want to play again?\n(yes/no): ";
    $input = strtolower(readline());
    if ($input === "no") {
        return false;
        
    } else {
        return true;
    }
}

// Start of user interaction
echo "Welcome to blackjack!\n";

// Ask user how much money they want to start with
echo "How much money do you have to start with? ";
$money = intval(readline());

// Start of game loop
$run = true;
while ($run) {
    // Find out how much they want to bet
    echo "How much would you like to bet?\n$";
    $bet = intval(readline());

    //Check their input
    while ($bet > $money || $bet < 1) {
        echo "Invalid amount enter a valid bet between 1 - ". $money .".\n$";
        $bet = intval(readline());
    }

    // Get the result of the round
    $moneyReturned = playRound($bet);
    echo "\n";

    // Update the money
    if ($moneyReturned > 0){
        $money += $moneyReturned;

    } else {
        $money -= $bet;
    }

    // Check if they can play again or not
    if ($money === 0) {
        echo "You have no money left to bet.\nPlease have a good day.\n";
        $run = false;
        break;
    } else {
        // Ask if they want to play again
        if (!askToPlayAgain($moneyReturned)) {
            $run = false;
            echo "Thank you for playing!\n";
            echo "You are leaving with $" . $money . "\n";

        } else {
            echo "Your current balance is $" . $money . "\n";
        }
    }
}

?>