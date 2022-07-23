<?php
//include connection file 
require_once('../include/config.php');
//check logged in or not 
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>

<?php include("head.php");  ?>
<title>Add new category</title>
<?php include("header.php");  ?>

<div class="content">

<h2>Add Category</h2>


<?php

//if form has been submitted process it
if(isset($_POST['submit'])){



    //collect form data
    extract($_POST);

    //very basic validations
    if($categoryname ==''){
        $error[] = 'Please enter the category.';
    }

    if(!isset($error)){

      try {

        $categoryslug = slug($categoryname);

//insert into database
$stmt = $db->prepare('INSERT INTO category (categoryname,categoryslug) VALUES (:categoryname, :categoryslug)') ;




$stmt->execute(array(
':categoryname' => $categoryname,
':categoryslug' => $categoryslug,


));
//add categories



//redirect to index page
header('Location: category-blog.php?action=added');
exit;

}catch(PDOException $e) {
            echo $e->getMessage();
        }

    }

}

//check for any errors
if(isset($error)){
    foreach($error as $error){
        echo '<p class="message">'.$error.'</p>';
    }
}
?>
<form action="" method="post">

    <h2><label>Category name</label><br>
    <input type="text" name="categoryname" style="width:100%;height:40px" value="<?php if(isset($error)){ echo $_POST['categoryname'];}?>"></h2>


   
    <button name="submit" class="subbtn">Submit</button>


</form>



</div>

<?php include("footer.php");  ?>
