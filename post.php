<?php include("head.php");  ?>
<?php

$stmt = $db->prepare('SELECT article_id,article_description,article_title, article_slug, article_content, postedon, tags,post_img FROM blog_article WHERE article_slug = :articleslug');
$stmt->execute(array(':articleslug' => $_GET['id']));
$row = $stmt->fetch();

//if post does not exists redirect user.
if ($row['article_id'] == '') {
    header('Location: ./not-found');
    exit;
}
//socia;l share
$baseurl = "https://qnastop.com/";
$slug = $row["article_slug"];
$articleid = $row["article_id"];

?>


<title><?php echo $row['article_title']; ?>-Qnastop</title>

<meta name="description" content="<?php echo $row['article_description']; ?>">

<meta name="keywords" content="<?php echo $row['tags']; ?>">
<meta property="og:url" content="<?php echo $baseurl;
                                    echo $slug; ?>" />

<meta property="og:type" content="Article" />

<meta property="og:title" content="<?php echo $row['article_title']; ?>" />

<meta property="og:description" content="<?php echo $row['article_description']; ?>" />
<meta property = "og:image" content="https://qnastop.com/upload/<?php echo $row['article_id']; echo "/"; echo $row['post_img']; ?>">
<link rel="canonical" href="<?php echo $baseurl; echo $slug; ?>" />
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BlogPosting",
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "<?php echo $baseurl; echo $slug; ?>"
  },
  "headline": "<?php echo $row['article_title']; ?>",
  "description": "<?php echo $row['article_description']; ?>",
  "image": "https://qnastop.com/upload/<?php echo $row['article_id']; echo "/"; echo $row['post_img']; ?>",  
  "author": {
    "@type": "Organization",
    "name": "qnastop.com"
  },  
  "publisher": {
    "@type": "Organization",
    "name": "qnastop.com",
    "logo": {
      "@type": "ImageObject",
      "url": "https://qnastop.com/asset/img/favicon.png"
    }
  },
  "datePublished": "<?php echo $row['postedon']; ?>",
  "dateModified": "<?php echo $row['postedon']; ?>"
}


</script>
<script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            {
                "@type": "ListItem",
                "position": 1,
                "item": {
                    "@type": "WebSite",
                    "@id": "https://qnastop.com/",
                    "name": "Home"
                }
            },
            {
                "@type": "ListItem",
                "position": 2,
                    "item": {
                    "@type": "WebPage",
                    "@id": "<?php echo $baseurl; echo $slug; ?>",
                    "name": "<?php echo $row['article_title']; ?>"                                
                }
            }    
        ] 
    }
</script>
<?php 
$stmt123 = $db->prepare('SELECT type,schema_data FROM schema_faq WHERE article_id = :articleid');
$stmt123->execute(array(':articleid' => $articleid));
while($row123 =$stmt123->fetch()){
    echo $row123['schema_data'];
};

?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
<?php include("header.php");  ?>

<?php $stmt2 = $db->prepare('SELECT article_title FROM blog_article WHERE article_slug = :articleslug');
$stmt2->execute(array(':articleslug' => $_GET['id']));
$row2 = $stmt2->fetch();

echo '<div class="post max-width1 ">
    
        <h1 class="font1 max-width2 m-auto ">'.$row2['article_title'].'</h1>
   
    
    </div>';
?>
<?php

$stmt3 = $db->prepare('SELECT * FROM blog_article WHERE article_slug = :articleslug');
$stmt3->execute(array(':articleslug' => $_GET['id']));
$row3 = $stmt3->fetch();




echo '

<div class="post-content max-width2 m-auto">
    <div class="postmeta">
        <div class="author font3">
            <b>BY ADMIN</b>
            
            <div>Posted on ' . date('jS M Y', strtotime($row3['postedon'])) . '</div>
        </div>
        <div class="social">

         <a target = "blank" href="https://twitter.com/share?text=' . $row3['article_title'] . '&url=' . $baseurl . '' . $slug . '&hastags=' . $row3['tags'] . '"><svg width="29" height="29" class="gc" >
                <path d="M22.05 7.54a4.47 4.47 0 0 0-3.3-1.46 4.53 4.53 0 0 0-4.53 4.53c0 .35.04.7.08 1.05A12.9 12.9 0 0 1 5 6.89a5.1 5.1 0 0 0-.65 2.26c.03 1.6.83 2.99 2.02 3.79a4.3 4.3 0 0 1-2.02-.57v.08a4.55 4.55 0 0 0 3.63 4.44c-.4.08-.8.13-1.21.16l-.81-.08a4.54 4.54 0 0 0 4.2 3.15 9.56 9.56 0 0 1-5.66 1.94l-1.05-.08c2 1.27 4.38 2.02 6.94 2.02 8.3 0 12.86-6.9 12.84-12.85.02-.24 0-.43 0-.65a8.68 8.68 0 0 0 2.26-2.34c-.82.38-1.7.62-2.6.72a4.37 4.37 0 0 0 1.95-2.51c-.84.53-1.81.9-2.83 1.13z"></path>
            </svg></a>
         
            <a target = "blank" href="https://facebook.com/share.php?u=' . $baseurl . '' . $slug . '"><svg width="29" height="29" class="gc">
                <path d="M23.2 5H5.8a.8.8 0 0 0-.8.8V23.2c0 .44.35.8.8.8h9.3v-7.13h-2.38V13.9h2.38v-2.38c0-2.45 1.55-3.66 3.74-3.66 1.05 0 1.95.08 2.2.11v2.57h-1.5c-1.2 0-1.48.57-1.48 1.4v1.96h2.97l-.6 2.97h-2.37l.05 7.12h5.1a.8.8 0 0 0 .79-.8V5.8a.8.8 0 0 0-.8-.79"></path>
            </svg></a>

            <a target = "blank" href="https://linkedin.com/sharearticle?mini=true&url=' . $baseurl . '' . $slug . '"><svg width="29" height="29" viewBox="0 0 29 29" fill="none" class="gc">
                <path d="M5 6.36C5 5.61 5.63 5 6.4 5h16.2c.77 0 1.4.61 1.4 1.36v16.28c0 .75-.63 1.36-1.4 1.36H6.4c-.77 0-1.4-.6-1.4-1.36V6.36z"></path>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.76 20.9v-8.57H7.89v8.58h2.87zm-1.44-9.75c1 0 1.63-.65 1.63-1.48-.02-.84-.62-1.48-1.6-1.48-.99 0-1.63.64-1.63 1.48 0 .83.62 1.48 1.59 1.48h.01zM12.35 20.9h2.87v-4.79c0-.25.02-.5.1-.7.2-.5.67-1.04 1.46-1.04 1.04 0 1.46.8 1.46 1.95v4.59h2.87v-4.92c0-2.64-1.42-3.87-3.3-3.87-1.55 0-2.23.86-2.61 1.45h.02v-1.24h-2.87c.04.8 0 8.58 0 8.58z" fill="#000"></path>
            </svg></a>
        </div>

    </div>

    <div class="para m-auto">
    ' . $row3['article_content'] .'
    </div>
</div>';
//comment start 
?>
 <p class="font1 align-c heading-p">COMMENTS AND DISCUSSION :</p>

<div class="message max-width2 success m-auto font1">Available Soon</div>




<div class="home-articles max-width1 m-auto">
    <p class="font1 align-c heading-p">People who Read also Read :</p>
    <div class="row">

        <?php
        try {
            //selecting data by id 
            $stmt = $db->query('SELECT article_id, article_title,article_slug, article_description, postedon, tags,post_img FROM blog_article WHERE article_id > ' . $articleid . ' ORDER BY article_id DESC LIMIT 1');
            $stmt2 = $db->query('SELECT article_id, article_title,article_slug, article_description, postedon, tags,post_img FROM blog_article WHERE article_id < ' . $articleid . ' ORDER BY article_id DESC LIMIT 2');

            while ($row = $stmt->fetch()) {
                echo '<div class="home-article more-post">
                <div class="home-article-image">
                    <img src="upload/'.$row['article_id'].'/'.$row['post_img'].'" alt="' . $row['article_title'] . '">
                </div>
        
                <div class="home-articles-content">
                    <a href="' . $row['article_slug'] . '">
                        <h3>' . $row['article_title'] . '</h3>
                    </a>
                    <p>' . $row['article_description'] . '</p>
                
                    
                    <span>Posted on ' . date('jS M Y', strtotime($row['postedon'])) . '</span>
                    <p><button class = "btn-blue home-post-button"> <a href="' . $row['article_slug'] . '">Read More</a></button></p>
                </div>
            
                </div>';
            }
            while ($row = $stmt2->fetch()) {
                echo '<div class="home-article more-post">
                <div class="home-article-image">
                    <img src="upload/'.$row['article_id'].'/'.$row['post_img'].'" alt="' . $row['article_title'] . '">
                </div>
        
                <div class="home-articles-content">
                    <a href="' . $row['article_slug'] . '">
                        <h3>' . $row['article_title'] . '</h3>
                    </a>
                    <p>' . $row['article_description'] . '</p>
                
                    
                    <span>Posted on ' . date('jS M Y', strtotime($row['postedon'])) . '</span>
                    <p><button class = "btn-blue home-post-button"> <a href="' . $row['article_slug'] . '">Read More</a></button></p>
                </div>
            
                </div>';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        ?>

    </div>
</div>

<?php include("footer.php");  ?>



