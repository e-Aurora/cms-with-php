<?php

include 'includes/database.php';
include 'includes/config.php';
include 'includes/functions.php';

secure();

include 'includes/header.php';


if(isset($_POST['username'])){
    if($stm = $connect -> prepare('INSERT INTO benimtablo (username, password, active) VALUES (?, ?, ?)') ){

        $hashed = SHA1($_POST['password']);
        $stm -> bind_param('sss', $_POST['username'], $hashed, $_POST['active']);
        $stm -> execute();

        set_message('A new user ' . $user['username'] . ' has been added');
        header('Location: users.php');
        $stm -> close();
        die();
    }   
        
    else {
            echo 'Statement not prepared';
        }
}


?>

<div class="container mt-5">
    <div class="row justify-content-center">
    
        <div class="col-md-6">
            <h1 class="display-1">Add User</h1>
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

                <!-- Active select -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <select name="active" class="form-select" id="active">
                        <option value="1">Active</option>
                        <option value="0">Passive</option>
                    </select>
                </div>
                

                <!-- Submit button -->
                <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Add User</button>
                </form>
                
        </div>
    </div>

</div>


<?php

include 'includes/footer.php';

?>