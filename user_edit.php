<?php

include 'includes/database.php';
include 'includes/config.php';
include 'includes/functions.php';

secure();

include 'includes/header.php';


if(isset($_POST['username'])){
    if($stm = $connect -> prepare('UPDATE benimtablo set username=?, active=? WHERE id = ?') ){

        $hashed = SHA1($_POST['password']);
        $stm -> bind_param('ssi', $_POST['username'], $_POST['active'], $_GET['id']);
        $stm -> execute();   
        $stm -> close();

        if($_POST['password'] != '') {
            if($stm = $connect -> prepare('UPDATE benimtablo set password = ? WHERE id = ?') ){
                $hashed = SHA1($_POST['password']);
                $stm -> bind_param('si', $hashed, $_GET['id']);
                $stm -> execute();
                $stm -> close();
            }
        }
    
        else {
            echo 'Password update statement not prepared';
        }

        set_message('A user ' . $_GET['id'] . ' has been updated');
        header('Location: users.php');
        die();

    }   
    else {
                echo 'User update statement not prepared';
        }


    

    
        
    
}

if(isset($_GET['id'])){
    if($stm = $connect -> prepare('SELECT * FROM benimtablo WHERE id = ?') ){
        $stm -> bind_param('i', $_GET['id']);
        $stm -> execute();

        $result = $stm -> get_result();
        $user = $result -> fetch_assoc();

        if($user){

        


?>

<div class="container mt-5">
    <div class="row justify-content-center">
    
        <div class="col-md-6">
            <h1 class="display-1">Edit User</h1>
                <form method="post">
            <!-- Email input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="username" name="username" class="form-control active" value="<?php echo $user['username']?>" />
                    <label class="form-label" for="username">Username</label>
                </div>

                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control"/>
                    <label class="form-label" for="password">Password</label>
                </div>

                <!-- Active select -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <select name="active" class="form-select" id="active">
                        <option <?php echo ($user['active' ]) ? "selected" : "";?> value="1">Active</option>
                        <option <?php echo ($user['active' ]) ? "" : "selected";?> value="0">Passive</option>
                    </select>
                </div>
                

                <!-- Submit button -->
                <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Update User</button>
                </form>
                
        </div>
    </div>

</div>


<?php

        $stm -> close();
        
    }
    else {
        echo 'no user selected';
        die();  
    }
}
}

include 'includes/footer.php';

?>