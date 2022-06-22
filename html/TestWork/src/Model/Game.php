<?php

namespace TestWork\Model;

class Game{

    private $size    = "3";
    private $empty   = "E";
    private $player1 = "X";
    private $player2 = "O";
    private $field;
    public  $player;
    private $winner;

    function init(){
        $this->field = array(array());
        for($i=0;$i<$this->size;$i++){
            for($j=0;$j<$this->size;$j++){
                $this->field[$i][$j] = $this->empty;
            }
        }
        $this->player = $this->player1;
    }

    /**
     * Prints the field as hidden post data
     * Prints the field as buttons for next move
     * Prints status of Game
     */
    function showField(){
        echo "<form method='post'>\n<div>\n\t<input type='hidden' name='player' value='".$this->player."'/>\n";

        for($i=0;$i<$this->size;$i++){
            for($j=0;$j<$this->size;$j++){
                echo "	<input type='hidden' name='(" . $i . "," . $j . ")' value='" . $this->field[$i][$j] . "'/>\n";
            }
        }
        echo "</div>\n<div class='field'>\n";
        for($i=0;$i<$this->size;$i++){
            echo "<div class='column'>\n";
            for($j=0;$j<$this->size;$j++){
                if($this->field[$i][$j] !== $this->empty || $this->hasWinner()){
                    echo "	<input type='button' class='row " . $this->field[$i][$j] . "'/>";
                }else{
                    echo "	<input type='submit' name='input'  class='row " . $this->field[$i][$j] . "'  value='(".$i.",".$j.")'/>";
                }
                if($j<$this->size -1){
                    echo "<br>\n";
                }
            }
            echo "\n</div>\n";
        }
        echo "</div>\n</form>\n";
        if(!$this->hasWinner()){
            if(!$this->fullBoard())
                echo "<div class='text'>PLAYER ". $this->player . "'S TURN</div>\n";
            else
                echo "<div class='text'>DRAW!</div>\n";
        }else{
            echo "<div class='text'>PLAYER ". $this->winner . " HAS WON!</div>\n";
        }

    }

    /**
     * Make move for player <code>$this->player</code> by choosing first free
     */
    function makeNextFreeMove(){
        for($i=0;$i<$this->size;$i++){
            for($j=0;$j<$this->size;$j++){
                if($this->field[$j][$i] === $this->empty){
                    $this->field[$j][$i] = $this->player;
                    return;
                }
            }
        }
        return $this->field;
    }

    /**
     * Checks if there is a move that makes player <code>$player</code> win
     * and makes it if found
     */
    function makeWinningMove($player){
        $f = $this->field;
        $p = $player;
        for($i=0;$i<$this->size;$i++){
            if($f[$i][0]===$p && $f[$i][1]===$p && $f[$i][2]===$this->empty){
                $this->field[$i][2] = $this->player;
                return true;
            }if($f[$i][0]===$p && $f[$i][1]===$this->empty && $f[$i][2]===$p){
                $this->field[$i][1] = $this->player;
                return true;
            }if($f[$i][0]===$this->empty && $f[$i][1]===$p && $f[$i][2]===$p){
                $this->field[$i][0] = $this->player;
                return true;
            }
        }
        for($i=0;$i<$this->size;$i++){
            if($f[0][$i]===$p && $f[1][$i]===$p && $f[2][$i]===$this->empty){
                $this->field[2][$i] = $this->player;
                return true;
            }if($f[0][$i]===$p && $f[1][$i]===$this->empty && $f[2][$i]===$p){
                $this->field[1][$i] = $this->player;
                return true;
            }if($f[0][$i]===$this->empty && $f[1][$i]===$p && $f[2][$i]===$p){
                $this->field[0][$i] = $this->player;
                return true;
            }
        }
        if($f[0][0]===$p && $f[1][1]===$p && $f[2][2]===$this->empty){
            $this->field[2][2] = $this->player;
            return true;
        }if($f[0][0]===$p && $f[1][1]===$this->empty && $f[2][2]===$p){
            $this->field[1][1] = $this->player;
            return true;
        }if($f[0][0]===$this->empty && $f[1][1]===$p && $f[2][2]===$p){
            $this->field[0][0] = $this->player;
            return true;
        }
        if($f[0][2]===$p && $f[1][1]===$p && $f[2][0]===$this->empty){
            $this->field[2][0] = $this->player;
            return true;
        }if($f[0][2]===$p && $f[1][1]===$this->empty && $f[2][0]===$p){
            $this->field[1][1] = $this->player;
            return true;
        }if($f[0][2]===$this->empty && $f[1][1]===$p && $f[2][0]===$p){
            $this->field[0][2] = $this->player;
            return true;
        }
        return false;
    }

    /**
     * Beginner AI
     *
     * Makes random move
     */
    function makeRandomMove(){
        $empty_fields = $this->getEmptyFields();
        $move = $empty_fields[rand(0,count($empty_fields)-1)];
        $this->field[$move[0]][$move[1]] = $this->player;
        return;
    }

    /**
     * Normal AI:
     *
     * - Checks for winning/blocking moves
     * else takes random field
     */
    function makeNormalMove(){
        if(!$this->makeWinningMove($this->player)){
            if(!$this->makeWinningMove($this->getEnemy($this->player))){
                $this->makeRandomMove();
            }
        }
    }

    /**
     * Novice AI:
     *
     * - Takes middle field
     * - Checks for winning/blocking moves
     * - Checks for empty corners
     * else takes random field
     */
    function makeNoviceMove(){
        if($this->field[1][1] === $this->empty){
            $this->field[1][1] = $this->player;
            return;
        }
        if(!$this->makeWinningMove($this->player)){
            if(!$this->makeWinningMove($this->getEnemy($this->player))){

                $empty_corners = $this->getEmptyCorners();
                if(count($empty_corners) > 0){
                    $move = $empty_corners[rand(0,count($empty_corners)-1)];
                    $this->field[$move[0]][$move[1]] = $this->player;
                    return;
                }
                $this->makeRandomMove();
            }
        }
    }

    /**
     * Expert AI:
     *
     * - Makes smart first move
     * - Checks for winning/blocking moves
     * - Checks for empty corners
     * else takes random field
     */
    function makeExpertMove(){
        //If player takes edge, take corner next to it
        if(count($this->getEmptyFields()) === 8 && count($this->getEmptyCorners()) === 4 && $this->field[1][1] === $this->empty){
            $field = array();
            if($this->field[0][1] === $this->getEnemy($this->player)){
                $field[] = array(0,0);
                $field[] = array(0,2);
            }elseif($this->field[1][0] === $this->getEnemy($this->player)){
                $field[] = array(0,0);
                $field[] = array(2,0);
            }elseif($this->field[1][2] === $this->getEnemy($this->player)){
                $field[] = array(0,2);
                $field[] = array(2,2);
            }elseif($this->field[2][1] === $this->getEnemy($this->player)){
                $field[] = array(2,0);
                $field[] = array(2,2);
            }
            $move = $field[rand(0,1)];
            $this->field[$move[0]][$move[1]] = $this->player;
            return;
        }

        if(!$this->makeWinningMove($this->player)){
            if(!$this->makeWinningMove($this->getEnemy($this->player))){

                if($this->field[1][1] === $this->empty){
                    $this->field[1][1] = $this->player;
                    return;
                }
                //If opponent has 2 corners and you have middle field, dont take another corner
                if(count($this->getEmptyFields()) === 6 && count($this->getEmptyCorners()) === 2 && $this->field[1][1] === $this->player){
                    $field = array();
                    $field[] = array(0,1);
                    $field[] = array(1,0);
                    $field[] = array(2,1);
                    $field[] = array(1,2);
                    $move = $field[rand(0,3)];
                    $this->field[$move[0]][$move[1]] = $this->player;
                    return;
                }

                $empty_corners = $this->getEmptyCorners();
                if(count($empty_corners) > 0){
                    $move = $empty_corners[rand(0,count($empty_corners)-1)];
                    $this->field[$move[0]][$move[1]] = $this->player;
                    return;
                }
                $this->makeRandomMove();
            }
        }
    }

    /**
     * Makes move for human player
     */
    function setMove($i, $j){
        if($this->field[$i][$j] === $this->empty){
            $this->field[$i][$j] = $this->player;
        }
    }

    function hasWinner(){
        if(!isset($this->winner))
            return $this->isWinner($this->player) || $this->isWinner($this->getEnemy($this->player));
        else
            return true;
    }

    function isWinner($player){
        $found = false;

        for($i=0;$i<$this->size;$i++){
            //CHECK EACH COLUMN
            $found = true;
            for($j=0;$j<$this->size;$j++){
                if($this->field[$i][$j] !== $player) $found = false;
            }
            if ($found){
                $this->winner =$player;
                return true;
            }
        }

        for($i=0;$i<$this->size;$i++){
            //CHECK EACH ROW
            $found = true;
            for($j=0;$j<$this->size;$j++){
                if($this->field[$j][$i] !== $player) $found = false;
            }
            if ($found){
                $this->winner =$player;
                return true;
            }
        }

        //CHECK FIRST DIAGONAL
        $found = true;
        for($i=0;$i<$this->size;$i++){
            if($this->field[$i][$i] !== $player) $found = false;
        }
        if ($found){
            $this->winner =$player;
            return true;
        }

        $found = true;

        //CHECK SECOND DIAGONAL
        $i=$this->size -1;
        $j=0;
        while($i>=0 && $j<$this->size){
            if($this->field[$i][$j] !== $player) $found = false;
            $j++;
            $i--;
        }
        if ($found){
            $this->winner =$player;
            return true;
        }

        return false;
    }

    /**
     * Creates a field from an array that has the structure
     * '(x,y)' => 'X'
     */
    function loadField($field){
        foreach($field as $position => $value){
            $i=substr($position, 1, 1);
            $j=substr($position, 3, 1);
            $this->field[$i][$j] = $value;
        }
    }

    function getField(){
        return $this->field;
    }

    /**
     * Returns an array with indexes of the empty fields
     * array[] = array[i][j]
     */
    function getEmptyFields(){
        $field = array();
        for($i=0;$i<$this->size;$i++){
            for($j=0;$j<$this->size;$j++){
                if ($this->field[$i][$j] === $this->empty){
                    $field[]= array($i, $j);
                }
            }
        }
        return $field;
    }

    function getEmptyCorners(){
        $field = array();
        if($this->field[0][0] === $this->empty){
            $field[] = array(0,0);
        }if($this->field[$this->size-1][$this->size-1] === $this->empty){
            $field[] = array($this->size-1,$this->size-1);
        }if($this->field[0][$this->size-1] === $this->empty){
            $field[] = array(0,$this->size-1);
        }if($this->field[$this->size-1][0] === $this->empty){
            $field[] = array($this->size-1,0);
        }
        return $field;
    }

    function setField($field){
        $this->field = $field;
    }

    /**
     * Changes size of board to <code>$size</code>x<code>$size</code>
     * WARNING: makeMove methods only work on 3x3!
     */
    function setSize($size){
        $this->size = $size;
    }

    function setPlayer($player){
        $this->player = $player;
    }

    /**
     * @return opponent of <code>$player</code>
     */
    function getEnemy($player){
        $player === $this->player1 ? $enemy = $this->player2 : $enemy = $this->player1;
        return $enemy;
    }

    /**
     * Changes the player that will make the next move
     */
    function switchPlayer(){
        $this->player = $this->getEnemy($this->player);
    }

    /**
     * Checks if board is filled yet
     * @return true if full, else false
     */
    function fullBoard(){
        for($i=0;$i<$this->size;$i++){
            for($j=0;$j<$this->size;$j++){
                if($this->field[$j][$i] === $this->empty){
                    return false;
                }
            }
        }
        return true;
    }
}
?>