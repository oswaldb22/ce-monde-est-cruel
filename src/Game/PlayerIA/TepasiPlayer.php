<?php

namespace Hackathon\PlayerIA;

use Hackathon\Game\Result;

/**
 * Class TepasiPlayers
 * @package Hackathon\PlayerIA
 * @author Oswald BLASSOU
 * Handling 3 case : 
 * - I'm losing I apply a strategy based on the most used choice by the opposents
 * - The opponents is scoring I apply another strategy
 * - or i'm just betting on the previous choice
 */
class TepasiPlayer extends Player
{
    protected $mySide;
    protected $opponentSide;
    protected $result;

    public function getChoice()
    {
        // -------------------------------------    -----------------------------------------------------
        // How to get my Last Choice           ?    $this->result->getLastChoiceFor($this->mySide) -- if 0 (first round)
        // How to get the opponent Last Choice ?    $this->result->getLastChoiceFor($this->opponentSide) -- if 0 (first round)
        // -------------------------------------    -----------------------------------------------------
        // How to get my Last Score            ?    $this->result->getLastScoreFor($this->mySide) -- if 0 (first round)
        // How to get the opponent Last Score  ?    $this->result->getLastScoreFor($this->opponentSide) -- if 0 (first round)
        // -------------------------------------    -----------------------------------------------------
        // How to get all the Choices          ?    $this->result->getChoicesFor($this->mySide)
        // How to get the opponent Last Choice ?    $this->result->getChoicesFor($this->opponentSide)
        // -------------------------------------    -----------------------------------------------------
        // How to get my Last Score            ?    $this->result->getLastScoreFor($this->mySide)
        // How to get the opponent Last Score  ?    $this->result->getLastScoreFor($this->opponentSide)
        // -------------------------------------    -----------------------------------------------------
        // How to get the stats                ?    $this->result->getStats()
        // How to get the stats for me         ?    $this->result->getStatsFor($this->mySide)
        //          array('name' => value, 'score' => value, 'friend' => value, 'foe' => value
        // How to get the stats for the oppo   ?    $this->result->getStatsFor($this->opponentSide)
        //          array('name' => value, 'score' => value, 'friend' => value, 'foe' => value
        // -------------------------------------    -----------------------------------------------------
        // How to get the number of round      ?    $this->result->getNbRound()
        // -------------------------------------    -----------------------------------------------------
        // How can i display the result of each round ? $this->prettyDisplay()
        // -------------------------------------    -----------------------------------------------------
        if($this->result->getNbRound() == 0){
            return parent::paperChoice();
        }

        if($this->result->getNbRound() == 1 && $this->result->getLastChoiceFor($this->mySide) == 0){
            if ($this->result->getLastChoiceFor($this->opponentSide)  == "scissors"){
                return parent::rockChoice();
            }
            if ($this->result->getLastChoiceFor($this->opponentSide)  == "paper"){
                return parent::scissorsChoice();
            }
            if ($this->result->getLastChoiceFor($this->opponentSide)  == "rock"){
                return parent::paperChoice();
            }
        }

        $ennemyStat = $this->result->getStatsFor($this->opponentSide);
        $myStat = $this->result->getStatsFor($this->mySide);

        if($ennemyStat["score"] > 0){
            $favoriteChoice = $this->getRecChoice($ennemyStat)["0"];
            if($favoriteChoice == "score"){
                return $this->getWinningChoice($this->result->getLastChoiceFor($this->opponentSide));
            }
            return $this->getWinningChoice($favoriteChoice);
        }

        if($myStat["score"] < $ennemyStat["score"]) {

            $favoriteChoice = $this->getRecChoice($ennemyStat)["0"];
            if($favoriteChoice == "score"){
                return $this->getWinningChoice($this->result->getLastChoiceFor($this->opponentSide));
            }
            return $this->getWinningChoice($favoriteChoice);
        }

        //print_r($this->result->getStats());
        
        // if($this->result->getLastChoiceFor($this->mySide) !== 0){
        //     $lastChoice = $this->result->getLastChoiceFor($this->mySide);
        //     if($lastChoice == parent::scissorsChoice()){
        //         return parent::rockChoice();
        //     }
        //     if($lastChoice == parent::paperChoice()){
        //         return  parent::scissorsChoice();
        //     }
        //     if($lastChoice == parent::rockChoice()){
        //         return parent::paperChoice();
        //     }
        // } 


        if ($this->result->getLastChoiceFor($this->opponentSide)  == "scissors"){
            return parent::rockChoice();
        }
        if ($this->result->getLastChoiceFor($this->opponentSide)  == "paper"){
            return parent::scissorsChoice();
        }
        if ($this->result->getLastChoiceFor($this->opponentSide)  == "rock"){
            return parent::paperChoice();
        }

        return parent::paperChoice();
    }

    public function getWinningChoice($choice) {
        if ($choice  == "scissors"){
            return parent::rockChoice();
        }
        if ($choice  == "paper"){
            return parent::scissorsChoice();
        }
        if ($choice  == "rock"){
            return parent::paperChoice();
        }
    }

    public function getMax($arr){
        $max = -1;
        foreach($arr as $value) {
            if(is_numeric($value) && $value > $max){
                $max = $value;
            }
        }
        return $max;
    }

    public function getRecChoice($arr){
        $max = $this->getMax($arr);
        $t = array_keys($arr, $max);
        return $t;
    }

    // public function getLastChoice($choice1, $choice2){
    //     if ($choice1  == "rock" && $choice2 == "scissors"){
    //         return parent::paperChoice();
    //     }
    //     if ($choice1  == "rock" && $choice2 == "scissors"){
    //         return parent::paperChoice();
    //     }
    // }
};
