<?php
require_once('../include/config.php');

if (!$user->is_logged_in()) {
    header('Location: login.php');
}
?>

<?php include("head.php");  ?>
<title>Update category</title>


<?php include("header.php");  ?>

<div class="content">

    <h2>Edit category</h2>


    <?php
  

    if (isset($_POST['submit'])) {


        //collect form data
        extract($_POST);

        //very basic validation
        if ($categoryid == '') {
            $error[] = 'This post is missing a valid id.';
        }

        if ($categoryname == '') {
            $error[] = 'Please enter the name.';
        }


        if (!isset($error)) {
            try {

                $categoryslug = slug($categoryname);

                //insert into database
                $stmt = $db->prepare('UPDATE category SET categoryname = :categoryname, categoryslug = :categoryslug WHERE categoryid = :categoryid');


                $stmt->execute(array(
                    ':categoryid' => $categoryid,
                    ':categoryslug' => $categoryslug,
                    ':categoryname' => $categoryname
                ));

                //redirect to index page
                header('Location: category-blog.php?action=updated');
                exit;
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }

    ?>


    <?php
    //check for any errors
    if (isset($error)) {
        foreach ($error as $error) {
            echo $error . '<br>';
        }
    }

    try {

        $stmt = $db->prepare('SELECT categoryid, categoryname FROM category WHERE categoryid = :categoryid');
        $stmt->execute(array(':categoryid' => $_GET['id']));
        $row = $stmt->fetch();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    ?>

    <form action='' method='post'>
        <input type='hidden' name='categoryid' value="<?php echo $row['categoryid']; ?>">

        <h2><label>Category name</label><br>
            <input type='text' name='categoryname' style="width:100%;height:40px" value="<?php echo $row['categoryname']; ?>">
        </h2>

    



        <button name='submit' class="subbtn"> Update</button>

    </form>

</div>




<?php include("footer.php");  ?>