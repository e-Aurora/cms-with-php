<?php

include 'includes/database.php';
include 'includes/config.php';
include 'includes/functions.php';

secure();

include 'includes/header.php';

if(isset($_GET['delete'])){
    if($stm = $connect -> prepare('DELETE FROM benimtabloposts WHERE id = ?') ){
        $stm -> bind_param('i', $_GET['delete']);
        $stm -> execute();
        $stm -> close();
        set_message('A post ' . $_GET['delete'] . ' has been deleted');
        header('Location: posts.php');
        die();
    }
    else {
        echo 'Delete statement not prepared';
    }
}

if($stm = $connect -> prepare('SELECT * FROM benimtabloposts') )
        $stm -> execute();

        $result = $stm -> get_result();

        if($result -> num_rows > 0){
        

?>

<div class="container mt-5">
    <div class="row justify-content-center">
    
        <div class="col-md-6">
            <h1 class="display-1">Posts Management</h1>
            <table class="table table-striped table-hover">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>Author's ID</th>
                <th>Edit | Delete</th>
            </tr>
            

            <?php 
                while($record = mysqli_fetch_assoc ($result)){ ?>
                    <tr>
                        <td><?php echo $record['id']; ?></td>
                        <td><?php echo $record['title']; ?></td>
                        <td><?php echo $record['content']; ?></td>
                        <td><?php echo $record['author']; ?></td>
                        <td><a href="post_edit.php?id=<?php echo $record['id']; ?>">Edit</a> | <a href="post.php?delete=<?php echo $record['id']; ?>">Delete</a></td>
                    </tr>

            <?php    }?>  

            </table>

            <a href="post_add.php"> Add Post</a> 
            
        </div>
    </div>

</div>


<?php


}else
echo 'no post found';
$stm -> close();

include 'includes/footer.php';

?>