<?php

$difficulty = $_GET['difficulty'];?>

<?php if($difficulty === null):?>
    <div id='menu'>
    <br/><br/>
    <h2><a href='?difficulty=easy'>		Easy  </a></h2>
    <h2><a href='?difficulty=normal'>	Normal</a></h2>
    <h2><a href='?difficulty=hard'>		Hard  </a></h2>
    <h2><a href='?difficulty=expert'>	Expert</a></h2>
    <br/>

<?php else:?>

    <div id='game'>

        <?php
        echo $_GET['difficulty'];
        $game = new \TestWork\Model\Game();

        if($_POST != null && !isset($_POST['game'])){
            $game->setPlayer($_POST['player']);
            $nextMove = $_POST['input'];
            unset($_POST['player']);
            unset($_POST['input']);
            $game->loadField($_POST);
            if(!$game->hasWinner()){
                $game->setMove(substr($nextMove, 1,1), substr($nextMove, 3, 1));
                $game->switchPlayer();
                if(!$game->hasWinner()){
                    if($difficulty==="easy"){
                        $game->makeRandomMove();
                    }elseif($difficulty==="normal"){
                        $game->makeNormalMove();
                    }elseif($difficulty==="hard"){
                        $game->makeNoviceMove();
                    }else{
                        $game->makeExpertMove();
                    }
                    $game->switchPlayer();
                }
            }
        } else {
            $game->init();
        }
        $game->showField();

        ?>
        <form method='post'>
            <div>
                <input type='submit' name='game'  class='resetButton'  value='NEW GAME'/>
            </div>
        </form>
    </div>
    <div>
        <input type='button' name='game'  value='cancel' class='cancelButton' onclick="window.location.href='index.php'"/>
<?php  endif;?>