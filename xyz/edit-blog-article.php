<?php 
require_once('../include/config.php'); 

if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<?php include("head.php");  ?>
    <title>Update Article</title>
    


    <?php include("header.php");  ?>

<div class="content">
 
<h2>Edit Post</h2>
<?php

try {

   $stmt1 = $db->prepare('SELECT article_id, article_title, article_slug, article_description, article_content, tags,category,post_img,article_image FROM blog_article WHERE article_id = :articleId') ;
  
    $stmt1->execute(array(':articleId' => $_GET['id']));
    $row = $stmt1->fetch(); 
} catch(PDOException $e) {
    echo $e->getMessage();
    //get content of post 
}

?>

    <?php
    // updating data of post
    if(isset($_POST['submit'])){
        //collect form data
        extract($_POST);

        //very basic validation
        if($articleId ==''){
            $error[] = 'This post is missing a valid id!.';
        }

        if($articleTitle ==''){
            $error[] = 'Please enter the title.';
        }

        if($articleDescrip ==''){
            $error[] = 'Please enter the description.';
        }

        if($articleContent ==''){
            $error[] = 'Please enter the content.';
        }
       
      if(!isset($error)){
        try {
     //insert into database
        $stmt = $db->prepare('UPDATE blog_article SET article_title = :articleTitle, article_slug = :articleSlug, article_description = :articleDescrip, article_content = :articleContent,tags = :articletags,category = :category WHERE article_id = :articleId') ;
        $stmt->execute(array(
        ':articleTitle' => $articleTitle,
        ':articleSlug' => $articleSlug,
        ':articleDescrip' => $articleDescrip,
        ':articleContent' => $articleContent,
        ':articleId' => $articleId,
        ':articletags' => $articletags,
        ':category' => $category,
        
      
        ));
         if(!($row['category'] == $category)){
            $stmt1 = $db->prepare('UPDATE category SET post = post - 1 WHERE categoryid = "'.$row['category'].'"');
            $stmt1->execute();
            $stmt1 = $db->prepare('UPDATE category SET post = post + 1 WHERE categoryid = "'.$category.'"');
            $stmt1->execute();
        }
     //redirect to index page
       header('Location: edit-blog-article.php?id='.$_GET['id'].'');
        exit;
   

    } catch(PDOException $e) {
                    echo $e->getMessage();
                }
    
            }//if isset !error
    
        }//post submit
    
        ?>
 


 
<?php //fetured image  
 if(isset($_POST['submit1'])){
     extract($_POST);


            $root = $_SERVER["DOCUMENT_ROOT"];
            $filename = $row['post_img'];
            $delimg= $root."/upload/".$_GET['id']."/".$filename;
            unlink("$delimg");

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
                
                $dir = $root . '/upload/'.$_GET['id'];
                $dir .= "/".$file_name;
                
                
                move_uploaded_file($file_tmp,$dir);
            }else{
                print_r($error);
                die();
            }
            
            if(!isset($error)){
        try {
     //insert into database
        $stmt = $db->prepare('UPDATE blog_article SET post_img = :postimg WHERE article_id = :articleId') ;
        $stmt->execute(array(
        ':postimg' => $file_name,
        ':articleId' => $_GET['id'],
        ));
        
     //redirect to index page
        header('Location: edit-blog-article.php?id='.$_GET['id'].'');
        exit;
    } catch(PDOException $e) {
                    echo $e->getMessage();
                }
    
            }//if isset !error
    
        }//if isset post submit 1

 ?>
 

 
 
 
 <?php // image for post 
 if(isset($_POST['submit3'])){
     extract($_POST);


            $root = $_SERVER["DOCUMENT_ROOT"];
            //$filename = $row['post_img'];
            //$delimg= $root."/upload/".$_GET['id']."/".$filename;
            //unlink("$delimg");

            $file_name = $_FILES['image1']['name'];
            $file_size = $_FILES['image1']['size'];
            $file_tmp = $_FILES['image1']['tmp_name'];
            $file_type = $_FILES['image1']['type'];
            $text = explode('.',$file_name);
            $file_ext = strtolower(end($text));
            $extension = array("jpeg","jpg","png","svg");
            $filename=$text[0];
            
            if(in_array($file_ext,$extension) === false){
                $error[] = "please upload a valid image type error";
            }
            if(empty($error) == true){
                
                $dir = $root . '/upload/'.$_GET['id'];
                $dir .= "/".$file_name;
                
                
                move_uploaded_file($file_tmp,$dir);
            }else{
                print_r($error);
                die();
            }
            
            if(!isset($error)){
        try {
     //insert into database
        $slashfile_name = "{$file_name}/";
        $existingfilename = "{$row["article_image"]}{$slashfile_name}";
        $stmt = $db->prepare('UPDATE blog_article SET article_image= :postimg WHERE article_id = :articleId') ;
        $stmt->execute(array(
        ':postimg' => $existingfilename,
        ':articleId' => $_GET['id'],
        ));
        
     //redirect to index page
        header('Location: edit-blog-article.php?id='.$_GET['id'].'');
        exit;
    } catch(PDOException $e) {
                    echo $e->getMessage();
                }
    
            }//if isset !error
    
        }//if isset post submit 1

 ?>
 
 

 <?php //schema
 if(isset($_POST['submit2'])){
     extract($_POST);
             if($schema_data ==''){
            $error[] = 'Please enter the schema data.';
        }

          if(!isset($error)){
              
          
        try {
     //insert into database
        $stmt3 = $db->prepare('INSERT INTO schema_faq (article_id,type,schema_data) VALUES (:arid, :type, :data)');
       
                $stmt3->execute(array(
                    ':arid' => $_GET['id'],
                    ':type' => $schematype,
                    ':data' => $schema_data
            
                ));

        
     //redirect to index page
        header('Location: edit-blog-article.php?id='.$_GET['id'].'');
        exit;
    } catch(PDOException $e) {
                    echo $e->getMessage();
                }
    
           }
    
        }//if isset post submit 2
 ?>
 
  <?php
    //check for any errors
    if(isset($error)){
        foreach($error as $error){
            echo $error.'<br>';
        }
    }
    ?>
   
    <form action='' method='post'>
        <input type='hidden' name='articleId' value="<?php echo $row['article_id'];?>">

           <h2><label>Article Title</label><br>
        <input type='text' name='articleTitle' style="width:100%;height:40px" value="<?php echo $row['article_title'];?>"></h2>
        
        <h2><label>Article slug</label><br></h2>
        <input type='text' name='articleSlug' style="width:100%;height:40px" value="<?php echo $row['article_slug'];?>">
        
 <h2><label>Short Description(Meta Description) </label><br></h2>
        <textarea name='articleDescrip' cols='120' rows='6'><?php echo $row['article_description'];?></textarea>

        <h2><label>Long Description(Body Content)</label><br> </h2>
 <textarea id="" name="articleContent" cols='120' rows='10'><?php echo $row['article_content'];?></textarea>
       
            <script>
        $(document).ready(function() {
            $('#summernote').summernote({
             height: 120
            });
            
        });
      </script>

      

     
    
        <h2>Article tags</h2>
        <input type="text" style="width:100%;height:40px" name="articletags" value="<?php echo $row['tags'];?>">

        <h2>Categories</h2>
        <select name="category" style="width:100%;height:40px">
        <?php //update
        $stmt2 = $db->query("SELECT * FROM category");
        $total_record = $stmt2->rowCount();
        if ($total_record > 0) {
      while($row2=$stmt2->fetch()){ 
          if ($row2['categoryid'] == $row['category']){
              $select = "selected";
          }else{
              $select="";
          }
          echo'<option value = "'.$row2['categoryid'].'" '.$select.'>'.$row2["categoryname"].'</option>';
          
       }
        }
        
        ?>
        </select>
        <br>
      
       <p></p>


       
        <button name='submit' class="subbtn"> Update</button>

    </form>
    <form action='' method='POST'>
      <h2>schema type qna</h2>
      type
        <input type="text" style="width:100%;height:40px" name="schematype">
        schema Data<br>
        <textarea type="text"name="schema_data" rows="10" cols="100"></textarea>
        <br>
        
   <button name='submit2' class="subbtn"> Add faq</button>
    
</form>
<form action='' method='post' enctype="multipart/form-data">
      <h2>image</h2>
      <p>Current file is :</p><?php echo $row['post_img']; ?>
        <input type="file" name="image" value="<?php echo $row['post_img']; ?>">
        
   <button name='submit1' class="subbtn"> Update- Img - featured image </button>
    
</form>

<form action='' method='post' enctype="multipart/form-data">
      <h2>image</h2>
      
<?php
$allfilename = $row["article_image"];
$onefilename = explode('/',$allfilename);
echo "<p>Current file is https://qnastop.com/upload/{$_GET['id']}/{$row['post_img']}</p>";
foreach ($onefilename as &$value) {
    echo "<p>Current file is https://qnastop.com/upload/{$_GET['id']}/{$value}</p>";
}
?>

        <input type="file" name="image1">
        
   <button name='submit3' class="subbtn"> add img </button>
    
</form>
</div>

<?php include("footer.php");  ?>
