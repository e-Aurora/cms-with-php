<?php

function secure(){
    if(!isset($_SESSION['id'])){
        echo 'please login first'; 
        //header('Location: /patos');
        die();
    }
}

function set_message($message){
    $_SESSION['message'] = $message;

}

function get_message(){
    if(isset($_SESSION['message'])){
        echo '<p>' . $_SESSION['message'] . '</p> <hr>';
        unset($_SESSION['message']);
    }
}



?>