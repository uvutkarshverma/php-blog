

<?php
//include head file for language preference 
include("head.php");  ?>
<title>Qnastop.com Get Your question Answered by expert. - Qnastop.com</title>
<meta name="description" content="Welcome to Qnastop - OneStop For all Questions. Get your Question Answered Quickly">

<meta name="keywords" content="">
<meta property="og:url" content="https://qnastop.com<?php echo $_SERVER['REQUEST_URI']; ?>" />

<meta property="og:type" content="website" />

<meta property="og:title" content="Qnastop.com Get Your question Answered by expert. - Qnastop.com" />

<meta property="og:description" content="Welcome to Qnastop - OneStop For all Questions. Get your Question Answered Quickly" />
<link rel="canonical" href="https://qnastop.com/" />
<?php
//header content //navbar 
include("header.php");  ?>

<!--//content of page start  -->
<div class="content max-width1 ">
    <div class="content-left m-auto">
        <h1>WELCOME TO QNASTOP.com</h1>
        <p>Qnastop - OneStop For all Questions.
        </p>
    </div>
    

</div>

<div class="hr"></div>

<!--articles list start-->

<div class="home-articles max-width2 m-auto">
    <h1 class="font1 align-c">Featured article</h1>
<?php
// pagination
$limit = 5;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}else{
    $page=1;
}

$offset = ($page - 1)*$limit;
?>
    <?php
    try {
        //selecting data by id 
        $stmt = $db->query("SELECT article_id, article_title, article_slug, article_description, postedon, tags,post_img FROM blog_article ORDER BY article_id DESC LIMIT $offset, $limit");

        while ($row = $stmt->fetch()) {
            echo '<div class="home-article">
                <div class="home-article-image">
                    <img src="upload/'.$row['article_id'].'/'.$row['post_img'].'" alt="'.$row['post_img'].'">
                </div>
        
                <div class="home-articles-content">
                    <a href="' . $row['article_slug'] . '">
                        <h3>' . $row['article_title'] . '</h3>
                    </a>
                    <p>' . $row['article_description'] . '</p>
                 
                    
                    <span>Posted on ' . date('jS M Y', strtotime($row['postedon'])) . '</span>
                    <p><button class = "btn-blue home-post-button"> <a href="' . $row['article_slug'] . '">Read More</a></button></p>';

         

            echo '</div>';

            echo '</div>';
            echo '<div class="hr"></div>';
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    ?>
</div>

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



<?php //footer content 
include("footer.php");  ?>