<?php
echo '<?xml version="1.0" encoding="UTF-8" ?>';
require_once("../include//config.php");
$article = $db->query("SELECT article_slug FROM blog_article ORDER BY article_id ASC");


?>
<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>
    <url>
        <loc>https://qnastop.com/</loc>
        <changefreq>Daily</changefreq>
        <priority>1.00</priority>
    </url>
<?php
header("Content-type: application/xml");
 while($row = $article->fetch()){
     echo "<url>";
        echo "<loc>https://qnastop.com/".$row["article_slug"]."</loc>";
         echo "<changefreq>monthly</changefreq>";
           echo "<priority>1.00</priority>";
    echo "</url>";
        
 }
 ?>
 </urlset>