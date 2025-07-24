 <?php
  require_once("./loader.php");

  if (isset($_POST['submit'])) {

    $Name = $_POST['Name'];
    $Phone = $_POST['Phone'];
    $Email = $_POST['Email'];
    $Explains = $_POST['Explains'];

    $sql = "INSERT INTO Contacts SET Name=? , Phone=? , Email=? , Explains=?";

    $result = $conn->prepare($sql);

    $result->bindValue(1, $Name);
    $result->bindValue(2, $Phone);
    $result->bindValue(3, $Email);
    $result->bindValue(4, $Explains);

    $result->execute();
  }
  // شرط ارسال پیام برای ارسال شدن یا نشدن فرم تماس با ما
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($result))
      echo '<p class="alert alert-success">فرم با موفقیت ارسال شد✔</p>';
    elseif (!isset($result)) {
      echo '<p class="alert alert-danger">فرم شما ارسال نشد⛔</p>';

      //   echo '<p class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"> Your Link is: !  <a href="' . $Custom . '"> ' . $Custom . '</a></p>';
      // } else echo '<p class="flex items-center p-4 mb-4 text-sm text-red-400 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800">"Link Already exists!:"</p>';
    }
  }
  ?>
 <!DOCTYPE html>
 <html lang="fr" dir="rtl">

 <head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

   <link rel="stylesheet" href="/src/output.css">
   <link rel="stylesheet"
     href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
     integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
     crossorigin="anonymous" referrerpolicy="no-referrer" />
   <title>تماس با ما</title>
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

   <h2>تماس با ما</h2>
   <hr>
   <form id="shorten-form" method="POST">
     <input name="Name" type="text" style="text-align: right" id="shorten-input" placeholder="نام" required>
     <input name="Phone" type="tel" style="text-align: right" id="shorten-input" maxlength="11" placeholder="موبایل" required>
     <input name="Email" type="email" style="text-align: right" id="shorten-input" placeholder="ایمیل" required>

     <textarea name="Explains" cols="79" rows="10" id="Explains" class="text-right" placeholder="توضیحات:" required></textarea>
     <br>

     <button type="submit" name="submit" id="shorten-button" class="mt-2">ارسال</button>
   </form>
   <hr>



   <footer>
     <br><br>
     <br><br>
     <a href="#">ساخت لینک</a>
   </footer>
 </body>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

 </html>