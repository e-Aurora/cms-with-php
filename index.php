<?php

include 'includes/database.php';
include 'includes/config.php';
include 'includes/functions.php';
include 'includes/header.php';



if(isset($_SESSION['id'])){
    header('Location: dashboard.php');
    die();
}

if(isset($_POST['username'])){
    if($stm = $connect -> prepare('SELECT * FROM benimtablo WHERE username = ? AND password = ? AND active = 1') ){

        $hashed = SHA1($_POST['password']);
        $stm -> bind_param('ss', $_POST['username'], $hashed);
        $stm -> execute();

        $result = $stm -> get_result();
        $user = $result -> fetch_assoc();

        if($user){
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            set_message('Welcome ' . $user['username']);
            header('Location: dashboard.php');
            die();

            
        }

        $stm -> close();
    }
        else {
            echo 'Statement not prepared';
        }
}

?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
        <form method="post">
        <!-- Email input -->
        <div data-mdb-input-init class="form-outline mb-4">
            <input type="text" id="username" name="username" class="form-control" />
            <label class="form-label" for="username">Username</label>
        </div>

        <!-- Password input -->
        <div data-mdb-input-init class="form-outline mb-4">
            <input type="password" id="password" name="password" class="form-control" />
            <label class="form-label" for="password">Password</label>
        </div>

        

        <!-- Submit button -->
        <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Sign in</button>
        </form>
        </div>
    </div>

</div>


<?php

include 'includes/footer.php';

?>