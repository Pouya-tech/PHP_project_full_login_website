 <?php
    require_once("./Config/loader.php");

    $Create_Type = true;
    $EndpointRedirectLink = null;
    //    Condition for url And Check if its Direct Or Indirect
    if (isset($_GET['url'])) {
        $Create_Type = false;

        $Custom = "http://localhost/PHP_PROJECT_NUMBER3/Simple-Link-Shortener/Link-Shortener.php?url=" . $_GET['url'];

        $sql = "SELECT * FROM links WHERE Custom_Link=?";

        $Haslink = $conn->prepare($sql);

        $Haslink->bindValue(1, $Custom);

        $Haslink->execute();
        $EndpointRedirectLink = $Haslink->fetch(PDO::FETCH_ASSOC);

        if ($EndpointRedirectLink['Type'] == "Direct") header(header: "Location: " . $EndpointRedirectLink['Endpoint_Link']);

        $EndpointRedirectLink = $EndpointRedirectLink['Endpoint_Link'];

        // var_dump($EndpointRedirectLink['Endpoint_Link']);
    }
    //   Make sure there is an Custom_Link
    if (isset($_POST['submit'])) {

        $Custom = $_POST['Custom_Link'];
        $Endpoint = $_POST['Endpoint_Link'];
        $Type = $_POST['Type'];

        $sql = "SELECT * FROM links WHERE Custom_Link=?";

        $Haslink = $conn->prepare($sql);

        $Haslink->bindValue(1, $Custom);

        $Haslink->execute();
        // var_dump($Haslink);
        //   to check that the shortened link doesnt exists already
        if (!$Haslink->rowcount()) {
            $sql = "INSERT INTO links SET Custom_Link=? , Endpoint_Link=? , Type=?";

            $result = $conn->prepare($sql);

            $result->bindValue(1, $Custom);
            $result->bindValue(2, $Endpoint);
            $result->bindValue(3, $Type);


            $result->execute();

            echo '<p class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"> Your Link is: !  <a href="' . $Custom . '"> ' . $Custom . '</a></p>';
        } else echo '<p class="flex items-center p-4 mb-4 text-sm text-red-400 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800">"Link Already exists!:"</p>';
    }

    ?>
 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

     <link rel="stylesheet" href="/src/output.css">
     <link rel="stylesheet"
         href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
         integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
         crossorigin="anonymous" referrerpolicy="no-referrer" />
     <title>لینک کوتاه کننده</title>
     <style>
         @font-face {
             font-family: 'Vazir';
             src: url('./Vazirmatn-Regular.woff2') format('woff2');
             font-weight: normal;
             font-style: normal;
         }


         * {
             font-family: 'Vazir', sans-serif;
         }

         body {
             font-family: Arial, sans-serif;
             text-align: center;
             margin: 50px;
         }

         #shorten-form {
             max-width: 650px;
             margin: auto;
         }

         #shorten-input {
             width: 100%;
             padding: 10px;
             margin-bottom: 10px;
         }

         #shorten-button {
             background-color: #4CAF50;
             color: white;
             padding: 10px 15px;
             border: none;
             cursor: pointer;
         }

         #shorten-result {
             margin-top: 20px;
             font-weight: bold;
         }
     </style>
 </head>

 <body>
     <?php if ($Create_Type) {   ?>
         <h2>لینک کوتاه کننده</h2>

         <form id="shorten-form" method="POST">
             <input name="Endpoint_Link" type="url" style="text-align: right" id="shorten-input" placeholder="لینک خود را وارد کنید" required>
             <input name="Custom_Link" type="url" id="shorten-input" value="http://localhost/PHP_PROJECT_NUMBER3/Simple-Link-Shortener/Link-Shortener.php?url="
                 placeholder="لینک کوتاه شده خود را وارد کنید" required>

             <select name="Type" class="form-select">
                 <option value="Indirect" style="text-align: right;">غیر مستقیم</option>
                 <option value="Direct" style="text-align: right;">مستقیم</option>
             </select>

             <br>

             <button type="submit" name="submit" id="shorten-button">کوتاه کن</button>
         </form>
     <?php    } else {   ?>

         <div id="shorten-result">
             <div class="adds-box">
                 <img src="https://biz-cdn.varzesh3.com/banners/2025/07/22/B/mu50npnc.gif" alt="Varzesh">
                 <img style="margin-left:10px;" src="https://biz-cdn.varzesh3.com/banners/2025/07/08/C/xyf2kvjk.gif" alt="Varzesh">
             </div>

             <br>
             <div id="countdown"></div>
             <!-- <progress value="0" max="10" id="progressBar"></progress> -->

             <div class="link-box">
                 <button id="GotoLink" disabled type="button" data-link="<?php echo $EndpointRedirectLink;  ?>" target="_blank" class="btn btn-primary opacity-50 cursor-not-allowed">کلیک کن</ذ>
             </div>
         </div>
     <?php    } ?>
     <br><br>
     <br><br>
<footer>
   <a href="#">تماس با ما</a>
</footer>
 </body>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

 <script>
     setTimeout(function() {
         const btn = document.getElementById("GotoLink");
         const link = btn.getAttribute("data-link")

         btn.disabled = false;
         btn.classList.remove("opacity-50", "cursor-not-allowed", "disabled");

         btn.addEventListener("click", function() {
             window.open(link, "_blank");
         });
     }, 10000);
 </script>
 <!-- <script>
     var timeleft = 10;
     var downloadTimer = setInterval(function() {
         if (timeleft <= 0) {
             clearInterval(downloadTimer);
         }
         document.getElementById("progressBar").value = 10 - timeleft;
         timeleft -= 1;
     }, 900);
 </script> -->
 <script>
     var timeleft = 10;
     var downloadTimer = setInterval(function() {
         if (timeleft <= 0) {
             clearInterval(downloadTimer);
             document.getElementById("countdown").innerHTML = "Finished";
         } else {
             document.getElementById("countdown").innerHTML = timeleft + " seconds remaining";
         }
         timeleft -= 1;
     }, 1000);
 </script>

 </html>