<?php
//include head file for language preference 
include("../head.php");  ?>

<title><?php echo $_GET['cid']; ?>- Category</title>
<meta name="description" content="All the post of category <?php echo $_GET['cid']; ?>- Qnastop">

<meta name="keywords" content="">

<meta property="og:url" content="https://qnastop.com<?php echo $_SERVER['REQUEST_URI']; ?>
" />

<meta property="og:type" content="website" />

<meta property="og:title" content="<?php echo $_GET['cid']; ?>- Category" />

<meta property="og:description" content="All the post of category <?php echo $_GET['cid']; ?>- Qnastop" />


<?php
//header content //navbar 
include("../header.php");  ?>
<?php
// pagination
$limit = 5;
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

if (isset($_GET['cid'])&& !empty($_GET['cid'])) {
    $category= $_GET['cid'];
    $stmt = $db->query('SELECT categoryid FROM category WHERE categoryslug = "'.$category.'"');
    $row = $stmt->fetch();
    $value = $row['categoryid'];
   
    if (($value == 0)&& empty($value)) {
        echo '<div class="message fail"> This category does not exist</div>';
    }
    else{
         echo '<div class="home-articles max-width2 m-auto">
            <h1 class="font1 align-c">Category : "' . $category. '"</h1>';
        
            try {
        
                $stmt1 = $db->query("SELECT * FROM blog_article WHERE category = '".$value."' LIMIT $offset,$limit");
                
                
        
        
                while ($row1 = $stmt1->fetch()) {
                    echo '<div class="home-article">
                        <div class="home-article-image">
                            <img src="/upload/'.$row1['article_id'].'/'.$row1['post_img'].'" alt="'.$row1['post_img'].'">
                        </div>
                
                        <div class="home-articles-content">
                            <a href="/' . $row1['article_slug'] . '">
                                <h3>' . $row1['article_title'] . '</h3>
                            </a>
                            <p>' . $row1['article_description'] . '</p>
                         
                            
                            <span>Posted on ' . date('jS M Y', strtotime($row1['postedon'])) . '</span>
                            <p><button class = "btn-blue home-post-button"> <a href="/' . $row1['article_slug'] . '">Read More</a></button></p>';
        
                   
        
                    echo '</div>';
        
                    echo '</div>';
                      echo '<div class="hr"></div>';
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
                }
    }//else 
        


           
    }// first if
else{
    
       header('Location: ./');
        exit;
}

?>
</div>
<!--div for home articles-->
<?php

$stmt2 = $db->query('SELECT post FROM category WHERE categoryid = "'.$value.'"');
$row = $stmt2->fetch();
$total_record = $row['post'];

if ($total_record > 0) {
    
    $total_page = ceil($total_record / $limit);
    echo '<div class="pagination max-width2 m-auto">';
    echo '<ul>';
    if($page > 1){
        echo '<a href="/category/'.$category.'/'.($page - 1).'">Previous</a>';
    }
    for ($i = 1; $i <= $total_page; $i++) {
        if($i == $page){
            $active= "active";
        }else{
            $active="";
        }
        
        echo '<a class = "'.$active.'" href = "/category/'.$category.'/'.$i.'">'.$i.'</a>';
       
        
    }
     if($total_page > $page){
            echo '<a href="/category/'.$category.'/'.($page + 1).'">Next</a>';
        }
    echo '</ul>';
    echo '</div>';
}

?>
<?php //footer content 
include("../footer.php");  ?>

