<?php

require_once 'Player.class.php';

class ScoreBoard
{
    private $players = [];
    private $currentPlayer = 0;

    public function addPlayer($player)
    {
        $this->players[] = $player;
    } 

    public function getCurrentPlayer()
    {
        $player = $this->players[$this->currentPlayer];
        return $player;
    }

    public function nextPlayer()
    {
        $this->currentPlayer++;
        if ($this->currentPlayer >= $this->getPlayerNumber()) {
            $this->currentPlayer = 0;
        }
    }
    
    public function getPlayerNumber()
    {
        return count($this->players);
    }

    public function calculatePlayerScore($firstPins, $secondPins)
    {
        $player = $this->getCurrentPlayer();
        $lastTwoThrows = $player->getLastTwoThrows();
        $roundScore = $firstPins + $secondPins;

        if ($lastTwoThrows !== null) {
            if (isset($lastTwoThrows[0]) && isset($lastTwoThrows[1])) {
                if ($lastTwoThrows[0] === 10) {
                    $roundScore += $roundScore;
                } else if ($lastTwoThrows[0] + $lastTwoThrows[1] === 10) {
                    $roundScore += $firstPins;
                }
            }
        }

        $player->setScore($player->getScore() + $roundScore);
    }
    
    public function calculatePlayerScoreLastRound($pins)
    {
        $player = $this->getCurrentPlayer();
        $player->setScore($player->getScore() + $pins);
    }

    public function displayScores()
    {
        foreach ($this->players as $player) {
            echo "Name: " . $player->getName() . ", Score: " . $player->getScore() . PHP_EOL;
        }
    }

    public function displayWinner()
    {
        $max = 0;
        foreach ($this->players as $player) {
            if ($max < (float)$player->getScore()) {
                $max = $player->getScore();
                $final_player = $player;
            }
        }
        return $final_player;
    }
}