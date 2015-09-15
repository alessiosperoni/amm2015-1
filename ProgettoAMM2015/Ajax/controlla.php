<?php

require_once 'Classe.php';

$usr = false;
$pw = false;

$users = new Classe();

if (isset($_REQUEST['username'])) {
    if (!empty($_REQUEST['username'])) {
        echo "$('#username').removeClass('valido');";
        $checkUsername = $users->checkUsername($_REQUEST['username']);
        if ($checkUsername === true) {
            $usr = true;
            echo "$('#username').addClass('valido');";
            echo "$('#username').html('V - valida');";
        } else {
            echo "$('#username').html('$checkUsername');";
        }
    } else {
        echo "$('#username').html('! - campo obbligatorio');";
    }
}

if (isset($_REQUEST['password'])) {
    if (!empty($_REQUEST['password'])) {
        echo "$('#password').removeClass('valido');";
        $checkPassword = $users->checkPassword($_REQUEST['password']);
        if ($checkPassword === true) {
            $pw = true;
            echo "$('#password').addClass('valido');";
            echo "$('#password').html('V - valida');";
        } else {
            echo "$('#password').html('$checkPassword');";
        }
    } else {
        echo "$('#password').html('! - campo obbligatorio');";
    }
}

if ($usr == true && $pw == true) {
    echo "$('#submit').attr('disabled',false);";
} 

else {
    echo "$('#submit').attr('disabled',true);";
}
?>