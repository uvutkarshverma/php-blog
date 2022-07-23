

<?php
//include head file for language preference 
include("../head.php");  ?>
 <?php $keyword = $_GET['query']; ?>
<title>Search Result for <?php echo $keyword; ?> - Qnastop</title>
<meta name="description" content="">

<meta name="keywords" content="">
<meta property="og:url" content="https://qnastop.com<?php echo $_SERVER['REQUEST_URI']; ?>" />

<meta property="og:type" content="website" />

<meta property="og:title" content="Search Result for <?php echo $keyword; ?> - Qnastop" />

<meta property="og:description" content="" />


<?php
//header content //navbar 
include("../header.php");  ?>


<?php
// pagination

$limit = 10;
if (isset($_GET['page']) == 0 || empty($_GET['page']))
{
    $page=1;
}
elseif (isset($_GET['page'])) {
    $page = $_GET['page'];
}
else{
    $page=1;
}


$offset = ($page - 1)*$limit;
?>


<!--articles list start-->
<?php

if (isset($_GET['query'])&& !empty($_GET['query'])) {
   


    echo '<div class="home-articles max-width2 m-auto">
    <h1 class="font1 align-c">Search Result for Query "' . $keyword . '"</h1>';

    try {

        $stmt = $db->query('SELECT * FROM blog_article WHERE article_title LIKE "%' . $keyword . '%" OR article_description LIKE "%' . $keyword . '%" OR tags LIKE  "%' . $keyword . '%" OR article_content LIKE "%' . $keyword . '%" ORDER BY article_id DESC LIMIT 10');


        while ($row = $stmt->fetch()) {
            echo '<div class="home-article">
                <div class="home-article-image">
                    <img src="/upload/'.$row['article_id'].'/'.$row['post_img'].'" alt="'.$row['post_img'].'">
                </div>
        
                <div class="home-articles-content">
                    <a href="/' . $row['article_slug'] . '">
                        <h3>' . $row['article_title'] . '</h3>
                    </a>
                    <p>' . $row['article_description'] . '</p>
                 
                    
                    <span>Posted on ' . date('jS M Y', strtotime($row['postedon'])) . '</span>
                    <p><button class = "btn-blue home-post-button"> <a href="/' . $row['article_slug'] . '">Read More</a></button></p>';

            echo '<span>tags - ';
            $link = array();
            $part = explode(',', $row['tags']);
            foreach ($part as $tags) {
                //$link[]="<a href='tag/".$tags."'>".$tags."</a>";
                $link[] = "<a href='#'>" . $tags . "</a>";
            }
            echo implode(",", $link);
            echo "</span>";

            echo '</div>';

            echo '</div>';
              echo '<div class="hr"></div>';
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
else{
    echo "<div class= 'message max-width1 font1 fail'>Error : Search something</div>";
}
?>
</div>
<!--div for home articles-->
<?php
if (isset($_GET['query'])&& !empty($_GET['query'])) {
$stmt2 = $db->query("SELECT * FROM blog_article");
$total_record = $stmt->rowCount();
if ($total_record > 0) {
    
    $total_page = ceil($total_record / $limit);
    echo '<div class="pagination max-width2 m-auto">';
    echo '<ul>';
    if($page > 1){
        echo '<a href="/search.php?cid='.$keyword.'&page='.($page - 1).'">Previous</a>';
    }
    for ($i = 1; $i <= $total_page; $i++) {
        if($i == $page){
            $active= "active";
        }else{
            $active="";
        }
        
        echo '<a class = "'.$active.'" href = "/search.php?cid='.$keyword.'&page='.$i.'">'.$i.'</a>';
       
        
    }
     if($total_page > $page){
            echo '<a href="/search.php?cid='.$keyword.'&page='.($page + 1).'">Next</a>';
        }
    echo '</ul>';
    echo '</div>';
}
}
?>

<?php //footer content 
include("../footer.php");  ?>