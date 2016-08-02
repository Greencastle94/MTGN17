   <?php
    //Load header
    include_once ('inc_header.php');
  ?>
    <title>Schema</title>
    <link rel="stylesheet" href="css/swiper.min.css" />
    <script src="js/schedule.js"></script>
  </head>

  <body>

    <?php
      //Load top content
      include_once ('inc_top_content.php');
    ?>

    <div class="content-wrapper">
   <!--    <div class="buttons">
        <div class="button" id="button_week_back"><span class="ion-ios-arrow-thin-left"></span> Föregående vecka</div>
        <div class="button" id="button_week_forward">Nästa vecka <span class="ion-ios-arrow-thin-right"></span></div>
      </div> -->
        <div id="schedule">
          <table>
            <tr class="toprow">
              <th colspan="8">
                <h2 class="week-title">
                  <div class="button" id="button_week_back"><span class="ion-ios-arrow-thin-left"></span><</div>
                  Schema, <div id="week"></div>
                <div class="button" id="button_week_forward">><span class="ion-ios-arrow-thin-right"></span></div>
              </h2>
              <div class="toprow-bg"></div>
              </th>
            </tr>
            <tr class="toprow">
              <td class="week_container top-day0">
              </td>
              <td class="day_container">
                <p class="weekday">Mån<span class="complete_day">dag</span></p>
                <p id="date_0" class="date"></p>
              </td>
              <td class="day_container">
                <p class="weekday">Tis<span class="complete_day">dag</span></p>
                <p id="date_1" class="date"></p>
              </td>
              <td class="day_container">
                <p class="weekday">Ons<span class="complete_day">dag</span></p>
                <p id="date_2" class="date"></p>
              </td>
              <td class="day_container">
                <p class="weekday">Tor<span class="complete_day">sdag</span></p>
                <p id="date_3" class="date"></p>
              </td>
              <td class="day_container">
                <p class="weekday">Fre<span class="complete_day">dag</span></p>
                <p id="date_4" class="date"></p>
              </td>
              <td class="day_container">
                <p class="weekday">Lör<span class="complete_day">dag</span></p>
                <p id="date_5" class="date"></p>
              </td>
              <td class="day_container top-day7">
                <p class="weekday">Sön<span class="complete_day">dag</span></p>
                <p id="date_6" class="date"></p>
              </td>
            </tr>
            <tr>
              <td class="timecell">08:00</td>
              <td class="day day0" id="0" rowspan="20"></td>
              <td class="day day1" id="1" rowspan="20"></td>
              <td class="day day2" id="2" rowspan="20"></td>
              <td class="day day3" id="3" rowspan="20"></td>
              <td class="day day4" id="4" rowspan="20"></td>
              <td class="day day5" id="5" rowspan="20"></td>
              <td class="day day6" id="6" rowspan="20"></td>
            </tr>
            <?php // skriver ut resten av tiderna i tabellen
              $startHour = 9;
              for ($i = 0; $i < 19; $i++) {
                echo "<tr class='timerow'>";
                echo "<td class='timecell'>";
                if ($startHour < 10) {
                  echo "0$startHour:00";
                } elseif ($startHour >= 10 && $startHour < 24) {
                  echo "$startHour:00";
                } else {
                  $startHour -= 24;
                  echo "0$startHour:00";
                }

                echo "</td>";
                echo "</tr>";
                $startHour++;
              }
            ?>
          </table>
          <div id="popup_container"></div>
        </div>
        <div id="schedule_mobile">
          <!-- Slider main container -->
          <div class="swiper-container">
            <!-- Additional required wrapper -->
            <div id="slider" class="swiper-wrapper">
              <!-- Slides -->
            </div>
          </div>
        </div>
    </div>

    <?php
      //Load footer
      include_once ('inc_footer.php');
    ?>
  <script src="js/swiper.jquery.min.js"></script>

    </div> <!-- close push-wrap from inc_top_content -->
    </div> <!-- close site-wrap from inc_top_content -->
  
  </body>
</html>
