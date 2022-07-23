<link defer rel="stylesheet"
        href="//fonts.googleapis.com/css?family=Roboto:100,300,400,500,700|Google+Sans:400,500|Product+Sans:400&amp;lang=en">
        
<link defer href="https://fonts.googleapis.com/css2?family=Akaya+Kanadaka&display=swap" rel="stylesheet">
    <link defer rel="stylesheet" href="/asset/css/stylemain.css">
    

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-KDJXY45TRY"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-KDJXY45TRY');
</script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6021755091211240"
     crossorigin="anonymous"></script>
</head>

<body>
    <!--desktop menu header-->
    <nav class="navigation max-width1">

        <div class="nav-left">
            <span class="m-auto"><a href="/" >Qnastop</a></span>
            <div class="burger m-auto">
                    <div class="line"></div>
                    <div class="line"></div>
                    <div class="line"></div>
                </div>
        </div> 
       
        <div class="nav-list show">
            <ul>
                <li class="m-auto"><a href="/">Home</a></li>
              <?php 
              try{
                    $stmt3 = $db->query('SELECT * FROM category WHERE post > 0 LIMIT 5');
                    
                    while ($row = $stmt3->fetch()) {
                        echo '<li class="m-auto"><a href="/category/'.$row['categoryslug'].'/">'.$row['categoryname'].'</a></li>';
                    }
                    
              }catch (PDOException $e) {
                echo $e->getMessage();
            }
            ?>
                

            </ul>
        </div>
        <div class="nav-right show">
            <form action="/search/search.php" method="GET">
                <input class="" name="query" type="text" placeholder="Find an Article">
                <button class="btn-blue">Search</button>
            </form>

        </div>

    </nav>
  