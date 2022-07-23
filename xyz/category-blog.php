<?php

require_once('../include//config.php');

if(!$user->is_logged_in()){header('location: login.php');}

if(isset($_GET['delcat'])){
    $stmt = $db->prepare('DELETE FROM category WHERE categoryid = :categoryId');
    
    $stmt->execute(array(':categoryId' => $_GET['delcat']));
    header('location: category-blog.php?action=deleted');
    exit;
}

?>

<?php include("head.php");?>

<title> Categories - Qnastop blog </title>
<script language="javascript" type="text/javascript">
function delcat(id, title){
    if (confirm("Are you sure want to delete "+ title + ""))  {
        window.location.href = 'category-blog.php?delcat=' + id;
        console.log(id);
    }
}
</script>
<?php include('header.php');?>

<div class="content">

<?php
    //show message from add / edit page
    if (isset($_GET['action'])) {
        echo '<h3>Category ' . $_GET['action'] . '.</h3>';
    }
    ?>

    <table>
        <tr>
            <th>Title</th>
            <th>Operation</th>
            <th>Delete</th>
            <th>Number of post</th>
           
        </tr>
        <?php
        try {

            $stmt = $db->query('SELECT categoryid, categoryname, categoryslug, post FROM category ORDER BY categoryname DESC');
            while ($row = $stmt->fetch()) {

                echo '<tr>';
                echo '<td>' . $row['categoryname'] . '</td>';
                
        ?>

                <td>
                    <button class="editbtn"> <a href="edit-blog-category.php?id=<?php echo $row['categoryid']; ?>">Edit </a> </button>
                </td>
                <td>
                    <button class="delbtn"> <a href="javascript:delcat('<?php echo $row['categoryid']; ?>','<?php echo $row['categoryslug']; ?>')">Delete </a> </button>
                </td>
                <td><?php echo $row['post']; ?></td>

        <?php
                echo '</tr>';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        ?>
    </table>

    <p> <button class="editbtn"><a href='add-blog-category.php'>Add New category</a></button></p>
    </p>
</div>




<?php include("footer.php");  ?>





