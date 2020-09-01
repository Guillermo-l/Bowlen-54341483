<?php
require_once 'Player.class.php';
require_once 'BowlingGame.class.php';
require_once 'ScoreBoard.class.php';

echo "> Welcome to the bowling game!" . PHP_EOL . "> How many people are going to bowl?" . PHP_EOL;
$total_players = readline() . PHP_EOL;

for ($i = 0; $i < $total_players; $i++) {
    echo "What is your name?" . PHP_EOL;
    $player_names[] = readline();
}

$scoreboard = new ScoreBoard();

foreach ($player_names as $name) {
    $player = new Speler($name);
    $scoreboard->addPlayer($player);
}

$game = new BowlingGame($scoreboard);
$game->start();
$winner = $scoreboard->displayWinner();
echo "The winner is: " . $winner->getName() . ", with a score of: " . $winner->getScore();
