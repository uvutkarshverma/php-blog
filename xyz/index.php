<?php

require_once('../include/config.php');

if (!$user->is_logged_in()) {
    header('Location: login.php');
}


//article id to delete post
if (isset($_GET['delpost']) && $_GET['category']) {

    $stmt = $db->prepare('DELETE FROM blog_article WHERE article_id = :article_Id');
    $stmt->execute(array(':article_Id' => $_GET['delpost']));
    $stmt = $db->prepare('DELETE FROM schema_faq WHERE article_id = :article_Id');
    $stmt->execute(array(':article_Id' => $_GET['delpost']));
    $stmt1 = $db->prepare('UPDATE category SET post = post -1 WHERE categoryid = "'.$_GET['category'].'"');
    $stmt1->execute();
    $stmt3 = $db->prepare('SELECT post_img from blog_article WHERE article_id = "'.$_GET['delpost'].'"');
    $row34 = $stmt3->fetch();
    $del_img= $row34['post_img'];
    $root = $_SERVER["DOCUMENT_ROOT"];
    $dir = "{$root}/upload/{$_GET['delpost']}";
   //remove folder of deleted post
    
        $files = glob($dir.'/*'); 
     
   foreach($files as $file) {
   
    if(is_file($file)) 
    
        // Delete the given file
        unlink($file); 
    }
    rmdir($dir);
    header('Location: index.php?action=deleted');
    exit;
}
?>

<?php include("head.php");  ?>

<title>Admin Home page</title>
<script language="JavaScript" type="text/javascript">
    function delpost(id, title,category) {
        if (confirm("Are you sure you want to delete '" + title + "'")) {
            //window.location.href = 'index.php?delpost=' + id;
            window.location.href = 'index.php?delpost=' + id +'&category='+ category;
        }
    }
</script>


<?php include("header.php");  ?>

<?php
//pagination
$limit = 10;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}else{
    $page=1;
}

$offset = ($page - 1)*$limit;
?>

<div class="content">
    <?php
    //show message from add / edit page
    if (isset($_GET['action'])) {
        echo '<h3>Post ' . $_GET['action'] . '.</h3>';
    }
    ?>

    <table>
        <tr>
            <th>Article Title</th>
            <th>Posted Date</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>
        <?php
        try {

            $stmt = $db->query("SELECT article_id,article_slug, article_title, postedon, category FROM blog_article ORDER BY article_id DESC LIMIT $offset, $limit");
            while ($row = $stmt->fetch()) {

                echo '<tr>';
                echo '<td><a href = "/'.$row['article_slug'].'" target = "blank" style = "text-decoration:none; color: black;" >'. $row['article_title'] . '</a></td>';
                echo '<td>' . date('jS M Y', strtotime($row['postedon'])) . '</td>';
        ?>

                <td>
                    <button class="editbtn"> <a href="edit-blog-article.php?id=<?php echo $row['article_id']; ?>">Edit </a> </button>
                </td>
                <td>
                    <button class="delbtn"> <a href="javascript:delpost('<?php echo $row['article_id']; ?>','<?php echo $row['article_title']; ?>','<?php echo $row['category']; ?>')">Delete </a> </button>
                </td>

        <?php
                echo '</tr>';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        ?>
    </table>

    <p> <button class="editbtn"><a href='add-blog-article.php'>Add New Article</a></button></p>
    </p>
</div>
<br>
<?php

$stmt2 = $db->query("SELECT * FROM blog_article");
$total_record = $stmt2->rowCount();
if ($total_record > 0) {
    
    $total_page = ceil($total_record / $limit);
    echo '<div class="pagination max-width2 m-auto">';
    echo '<ul>';
    if($page > 1){
        echo '<a href="?page='.($page - 1).'">Previous</a>';
    }
    for ($i = 1; $i <= $total_page; $i++) {
        if($i == $page){
            $active= "active";
        }else{
            $active="";
        }
        
        echo '<a class = "'.$active.'" href = "?page='.$i.'">'.$i.'</a>';
       
        
    }
     if($total_page > $page){
            echo '<a href="?page='.($page + 1).'">Next</a>';
        }
    echo '</ul>';
    echo '</div>';
}

?>


<?php include("footer.php");  ?>