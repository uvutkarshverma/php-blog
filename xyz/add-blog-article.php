<?php
require_once('../include/config.php');


if (!$user->is_logged_in()) {
    header('Location: login.php');
}
?>

<?php include("head.php");  ?>
<!-- On page head area-->
<title>Add New Article - Qnastop Blog</title>


<?php include("header.php");

?>

<div class="content">

    <h1>Add New Article</h1>

    <?php

    //if form has been submitted process it
    if (isset($_POST['submit'])) {



        //collect form data
        extract($_POST);

        //very basic validations
        if ($articleTitle == '') {
            $error[] = 'Please enter the title.';
        }

        if ($articleDescrip == '') {
            $error[] = 'Please enter the description.';
        }

        if ($articleContent == '') {
            $error[] = 'Please enter the content.';
        }
        $articleSlug = slug($articleTitle);
        
        if($_FILES['image']){
           
         $stmt = $db->query('SELECT MAX(article_id) FROM blog_article');
              $row = $stmt->fetch();
              $id1 = $row['MAX(article_id)'] + 1;
           
               

            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_type = $_FILES['image']['type'];
            $text = explode('.',$file_name);
            $file_ext = strtolower(end($text));
            $extension = array("jpeg","jpg","png","svg");
            $filename=$text[0];

            if(in_array($file_ext,$extension) === false){
                $error[] = "please upload a valid image type error";
            }
            if(empty($error) == true){
                $root = $_SERVER["DOCUMENT_ROOT"];
                $dir = $root . '/upload/'.$id1;
                mkdir($dir);
                $dir .= "/".$file_name;
                
                move_uploaded_file($file_tmp,$dir);
                $file_handle = fopen("$root/upload/$id1/index.html","w");
                fclose($file_handle);
            }else{
                print_r($error);
                die();
            }
            
        }
        
        if (!isset($error)) {

            try {

               

                //insert into database
                $stmt = $db->prepare('INSERT INTO blog_article (article_id,article_title,article_slug,article_Description,article_content,postedon,tags,category,post_img) VALUES (:articleId,:articleTitle, :articleSlug, :articleDescrip, :articleContent, :articleDate,:articletags,:category,:postimg)');




                $stmt->execute(array(
                    ':articleId' => $id1,
                    ':articleTitle' => $articleTitle,
                    ':articleSlug' => $articleSlug,
                    ':articleDescrip' => $articleDescrip,
                    ':articleContent' => $articleContent,
                    ':articleDate' => date('Y-m-d H:i:s'),
                    ':articletags' => $articletags,
                    ':category' => $category,
                    ':postimg' => $file_name,


                ));

                $stmt1 = $db->prepare('UPDATE category SET post = post + 1 WHERE categoryid = "'.$category.'"');
                $stmt1->execute();
                //redirect to index page
                header('Location: index.php?action=added');
                exit;
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }

    //check for any errors
    if (isset($error)) {
        foreach ($error as $error) {
            echo '<p class="message">' . $error . '</p>';
        }
    }
    ?>
    <form action="" method="post" enctype="multipart/form-data">

        <h2><label>Article Title</label><br>
            <input type="text" name="articleTitle" style="width:100%;height:40px" value="<?php if (isset($error)) {
            echo $_POST['articleTitle'];
            } ?>">
        </h2>

        <h2><label>Short Description(Meta Description) </label><br></h2>
            <textarea name="articleDescrip" cols="120" rows="6"><?php if (isset($error)) {
        echo $_POST['articleDescrip'];} ?>
        </textarea>
        

        <h2><label>Long Description(Body Content)</label><br> </h2>
 <textarea name="articleContent" cols="120" rows="10"><?php if (isset($error)) {
            echo $_POST['articleContent'];} ?></textarea>
       
        
    

        <h2>Article tags</h2>
        <input type="text" style="width:100%;height:40px" name="articletags" value="<?php if (isset($error)) {
        echo $_POST['articletags'];} ?>">
        <br>


        <h2>Categories</h2>
        <select name="category" style="width:100%;height:40px">
        <?php //update
        $stmt2 = $db->query("SELECT * FROM category");
        $total_record = $stmt2->rowCount();
        if ($total_record > 0) {
      while($row=$stmt2->fetch()){ 
          
          echo'<option value = "'.$row["categoryid"].'">'.$row["categoryname"].'</option>';
       }
        }
        
        ?>
        </select>
        <br>
        <h2>image</h2>
        <input type="file" name="image">

        <br>





        <button name="submit" class="subbtn">Submit</button>


    </form>



</div>

<?php include("footer.php");  ?>