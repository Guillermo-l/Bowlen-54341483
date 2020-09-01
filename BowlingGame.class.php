<?php

require_once 'ScoreBoard.class.php';
require_once 'Player.class.php';

class BowlingGame
{
    private $scoreboard;

    function __construct($scoreboard)
    {
        $this->scoreboard = $scoreboard;
    }

    public function start()
    {
        for ($round = 1; $round <= 10; $round++) {
            echo "Round: $round" . PHP_EOL;
            for ($x = 0; $x < $this->scoreboard->getPlayerNumber(); $x++) {
                $player = $this->scoreboard->getCurrentPlayer();

                echo $player->getName() . " It's your turn! what was your first throw?" . PHP_EOL;
                $first_throw = intval(readline());
                while ($first_throw > 10 || $first_throw < 0) {
                    echo "$first_throw is not a correct number of pins" . PHP_EOL;
                    echo $player->getName() . " It's your turn! what was your first throw?" . PHP_EOL;
                    $first_throw = intval(readline());
                }

                $second_throw = 0;
                if ($first_throw !== 10) {
                    echo $player->getName() . " It's your turn what was your second throw?" . PHP_EOL;
                    $second_throw = intval(readline());
                    while ($second_throw > 10 - $first_throw || $second_throw < 0) {
                        echo "$second_throw is not a correct pin number" . PHP_EOL;
                        echo $player->getName() . " It's your turn what was your second throw?" . PHP_EOL;
                        $second_throw = intval(readline());
                    }

                    $throws = [$first_throw, $second_throw];

                    if ($first_throw + $second_throw >= 10) {
                        echo "Spare!" . PHP_EOL;
                    }
                } else {
                    echo "Strike!" . PHP_EOL;
                    $throws = [$first_throw, 0];
                    $pins = $first_throw;
                }
                $this->scoreboard->calculatePlayerScore($first_throw, $second_throw);
                $player->setLastTwoThrows($throws);

                $third_throw = 0;
                if ($round === 10 && $first_throw === 10) {
                    echo $player->getName() . " It's your turn what was your second throw?" . PHP_EOL;
                    $second_throw = intval(readline());
                    while ($second_throw > 10 || $second_throw < 0) {
                        echo "$second_throw is not a correct pin number" . PHP_EOL;
                        echo $player->getName() . " It's your turn what was your second throw?" . PHP_EOL;
                        $second_throw = intval(readline());
                    }

                    if ($second_throw === 10) {
                        echo $player->getName() . " It's your turn what was your third throw?" . PHP_EOL;
                        $third_throw = intval(readline());
                        while ($third_throw > 10 || $third_throw < 0) {
                            echo "$third_throw is not a correct pin number" . PHP_EOL;
                            echo $player->getName() . "It's your turn what was your third throw?" . PHP_EOL;
                            $third_throw = intval(readline());
                        }
                    }
                    $this->scoreboard->calculatePlayerScoreLastRound($second_throw + $third_throw);
                } else if ($round === 10 && $first_throw + $second_throw === 10) {
                    echo $player->getName() . " It's your turn what was your third throw?" . PHP_EOL;
                    $third_throw = intval(readline());
                    while ($third_throw > 10 || $third_throw < 0) {
                        echo "$third_throw is not a correct pin number" . PHP_EOL;
                        echo "It's your turn " . $player->getName() . ": what was your third throw?" . PHP_EOL;
                        $third_throw = intval(readline());
                    }
                    $this->scoreboard->calculatePlayerScoreLastRound($third_throw);
                }

                $this->scoreboard->nextPlayer();
            }
            $this->scoreboard->displayScores();
        }
    }
}
