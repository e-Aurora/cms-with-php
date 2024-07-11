<?php

include 'includes/database.php';
include 'includes/config.php';
include 'includes/functions.php';

secure();

include 'includes/header.php';

if(isset($_GET['delete'])){
    if($stm = $connect -> prepare('DELETE FROM benimtablo WHERE id = ?') ){
        $stm -> bind_param('i', $_GET['delete']);
        $stm -> execute();
        $stm -> close();
        set_message('A user ' . $_GET['delete'] . ' has been deleted');
        header('Location: users.php');
        die();
    }
    else {
        echo 'Delete statement not prepared';
    }
}

if($stm = $connect -> prepare('SELECT * FROM benimtablo') )
        $stm -> execute();

        $result = $stm -> get_result();

        if($result -> num_rows > 0){
        

?>

<div class="container mt-5">
    <div class="row justify-content-center">
    
        <div class="col-md-6">
            <h1 class="display-1">Users Management</h1>
            <table class="table table-striped table-hover">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Status</th>
                <th>Edit | Delete</th>
            </tr>
            

            <?php 
                while($record = mysqli_fetch_assoc ($result)){ ?>
                    <tr>
                        <td><?php echo $record['id']; ?></td>
                        <td><?php echo $record['username']; ?></td>
                        <td><?php echo $record['active']; ?></td>
                        <td><a href="user_edit.php?id=<?php echo $record['id']; ?>">Edit</a> | <a href="users.php?delete=<?php echo $record['id']; ?>">Delete</a></td>
                    </tr>

            <?php    }?>  

            </table>

            <a href="user_add.php"> Add User</a> 
            
        </div>
    </div>

</div>


<?php


}else
echo 'no user found';
$stm -> close();

include 'includes/footer.php';

?>