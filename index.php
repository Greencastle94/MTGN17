   <?php
    //Load header
    include_once ('inc_header.php');
  ?>
    <title>Mottagningen</title>
  </head>

  <body>

    <?php
      //Load top content
      include_once ('inc_top_content.php');
    ?>

    <div class="content-wrapper">
      <!-- Content -->
<?php
      if (isset($_GET['page'])) {
          $page = floatval($_GET['page']);
          if ($page >= 1) {
            $pageoffset = $page * 10 - 10;
          }
        } else {
          $page = 1;
          $pageoffset = 0;
        }

        if (isset($_GET['category'])) {
          $getcategory = $_GET['category'];
          $getcategoryquery = "WHERE category = '$getcategory'";
        } else {
          $getcategory = "";
          $getcategoryquery = "";
        }
        ?>
        <?php
        $query = "SELECT title, body, newsdate, author, category, id FROM news $getcategoryquery ORDER BY newsdate DESC LIMIT 10 OFFSET $pageoffset";
        $result = execQuery($link, $query);
        setlocale(LC_ALL, 'sv_SE.ISO8859-1');

        while ($news = $result->fetch_object()) {
          $body = $news->body;
          $body = nl2br($body);

          // get name
          $author = $news->author;
          if ($stmt = $link->prepare("SELECT name, username FROM users WHERE username = ? LIMIT 1")) {
            $stmt->bind_param('s', $author);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($name, $currusername);
            $stmt->fetch();
          } else {
            $name = "Odefinierad";
          }

          $username = $_SESSION['username'];
          $newsid = $news->id;

          echo "<div class='news clearfix'>";
          echo "<div class='news-content'>";
          echo "<h2><a class='news-title' href=\"newspage.php?id=$newsid\">$news->title</a></h2>";
          if (strlen($body) > 700) {
            echo "<p class=\"long\">$body</p>";
          } else {
            echo "<p>$body</p>";
          }

          if ($username === $currusername || $admin) {
            echo "<a class='news-edit button' href=\"newspage_edit.php?id=$newsid\">Redigera inlägg</a>";
          }
          echo "<div class='post-footer clearfix'>";
          echo "<a class='news-category' href=\"/index.php?category=$news->category\">$news->category</a>";
          echo "<div class='news-writtenby'>";
          echo "<span>Skrivet av: </span>$name";

          echo "</div>";
          echo "<div class='news-timestamp'>" . utf8_encode(strftime("%A %d %B %H:%M", strtotime($news->newsdate))) . "</div>";
          echo "</div>"; //post-footer
          //echo "<div class='white'></div>";
          echo "</div>"; //news-content
          echo "<div class='news-symbol_wrap'><img class='news-symbol' src='/images/newsSymbol.png'></div>";
          echo "<svg class='news-divider-line'>";
          echo "<line x1='0' y1='0' x2='100%'' y2='0'/>";
          echo "</svg>";
          echo "</div>"; //news
        }

        //Count how many newsarticles there is
        $query = "SELECT COUNT(*) AS c FROM news $getcategoryquery";
        $result = execQuery($link, $query);
        $count = $result->fetch_object();
        $count = $count->c;

        $numofpages = floor($count / 10);


        // Max 10 news per page
        if($count % 10 != 0) {
          $numofpages++;
        }

        echo "<div class=\"news pagelinks-wrap\">";
        if($page > 1) {
          $prevpage = $page - 1;
          echo "<a class=\"pagelinks button\" href=\"/index.php?page=$prevpage\"><span class=\"ion-ios-arrow-thin-left\"> Föregående</a> ";
        }

        for($i = 0; $i < $numofpages; $i++) {
          $counter = $i + 1;

          if ($page == $counter)
          {
              echo "<span class=\"pagelinks pagelinks_current button\">$counter</span>";
          }
          else {
              echo "<a class=\"pagelinks$currentpageclass button\" href=\"/index.php?page=$counter\">$counter</a>";
          }

          if ($counter < $numofpages)
          {
              echo " ";
          }

        }

        if($page < $numofpages) {
          $nextpage = $page + 1;
          echo " <a class=\"pagelinks button \" href=\"/index.php?page=$nextpage\">Nästa <span class=\"ion-ios-arrow-thin-right\"></a>";
        }
        echo "</div>";
?>
    </div>

    <?php
      //Load footer
      include_once ('inc_footer.php');
    ?>

<script type="text/javascript">
  $(window).load(function() {

    // Hide super long submissions
    $(".news").each( function() {
      var capHeight = $( this ).find("p.long").innerHeight();
      var maxHeight = 270;

      if(capHeight > maxHeight) {                 // om inlägget är för långt
        $( this ).find("p.long").css("height", maxHeight);
        $( this ).find("p.long").after( "<p class='read-more closed fake-link button'>Läs mer</p>" ); // lägg till 'läs mer'
        $( ".read-more" ).text( "Läs mer" );
        $( this ).find( ".read-more" ).click(function() {     // om 'läs mer' klickas på
          if( $( this ).hasClass("closed")) {           // om klick + stängd
            $( this ).prev("p.long").animate({height: capHeight}, 500);
            $( this ).text( "Läs mindre" );
            $( this ).toggleClass("closed open");
          } else if( $(this).hasClass("open")) {          // om klick + öppen
            $( this ).prev("p.long").animate({height: maxHeight}, 500);
            $( this ).text( "Läs mer" );
            $( this ).toggleClass("open closed");
          }
        });
      }
    });
  });

    </script>
  </body>
</html>
