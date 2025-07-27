<?php
require_once('./Config/loader.php');
// If for Valid phone number and OTP Action
if (isset($_POST['send-phone'])) {
  $phone = $_POST['phone'];
  // $phone_number = mysqli_real_escape_string($conn, $_POST['phone']);
  // کد 4 رقمی تصادفی
  $token = mt_rand(1000, 9000);
  //  ذخیره کد در سشن
  // $_SESSION['verification_code'] = $token;
  // $_SESSION['phone_number'] = $phone_number;
  // محاصبه تاریخ ارسال کد
  // $expires_at = date('Y-m-d H:i:s', time() + 60);
  // ذخیره در دیتا بیس
  // $query = "INSERT INTO users (OTP) VALUES ()";
  // mysqli_query($conn , $query);
  // ارسال پیامک
  require './vendor/autoload.php';
  $sender = "100075752";
  $receptor = $_POST['phone'];
  $message = "!سلام";
  // register SQL
  $query = "SELECT * FROM `users` WHERE (phone = :key OR email = :key) LIMIT 1";
  // Register stmt
  $stmt = $conn->prepare($query);
  // bind
  $stmt->bindValue(":key", $phone);
  // execute
  $stmt->execute();
  // rowCount
  $hasuser = $stmt->rowCount();
  //  شرط نبودن کاربر
  if (!$hasuser) {
    header('Location: ./OTP.php?error=notuser');
  } else {
    try {
      // API KEY  اتصال به کاوه نگار با
      $api = new \Kavenegar\KavenegarApi("443356757A61733733714957497159692B48343061544F4E76355655676F384165374C547875576D4358513D");
      //  استفاده از کلاس های کاوه نگار
      $api->VerifyLookup($receptor, $token, null, null, "login");
      // $api->Send($sender , $receptor , $message);
      // پیام با موفقیت ارسال شد

    } catch (\Kavenegar\Exceptions\ApiException $e) {
      //  نباشد این خطا را میدهد 200 درصورتی که خروجی وب سرویس
      echo  " API خطای " . $e->errormessage();
    } catch (\Kavenegar\Exceptions\HttpException $e) {
      //  نباشد این خطا را میدهد 200 درصورتی که خروجی وب سرویس
      echo  "اتصال خطای " . $e->errormessage();
    };
    $query = "UPDATE `users` SET OTP =:otp WHERE (phone = :key OR email = :key) LIMIT 1";
    // Register stmt
    $stmt = $conn->prepare($query);
    // bind
    $stmt->bindValue(":otp", $token);
    $stmt->bindValue(":key", $phone);

    // execute
    $stmt->execute();

    header('Location: ./OTP.php?success=sendOTP&phone=' . $phone);
  }
}
// If For Checking the Sent OTP With Input OTP
if (isset($_POST['check-otp'])) {
  $otp = $_POST['OTP'];
  $phone = $_GET['phone'];

  // register SQL
  $query = "SELECT * FROM `users` WHERE (phone = :key OR email = :key) AND OTP = :otp LIMIT 1";
  // Register stmt
  $stmt = $conn->prepare($query);
  // bind
  $stmt->bindValue(":key", $phone);
  $stmt->bindValue(":otp", $otp);
  // execute
  $stmt->execute();
  // rowCount
  $hasuser = $stmt->rowCount();
  //  If User Does Not Exists
  if (!$hasuser) {
    header('Location: ./OTP.php?error=Incorrect_OTP');
  } else {

    // Save Phone And Verify if user is loginned ( $_SESSION['login'] == true;)
    $_SESSION['phone'] = $phone;
    $_SESSION['login'] = true;

    header('Location: ./OTP.php?success=loginned');
  }
}
?>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="./Assets/css/sign_up&in.css">
  <link rel="stylesheet" href="./output.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login With OTP</title>
</head>

<body>
  <div class="container " id="container">
    <div class="form-container sign-in">
      <form method="POST">
        <h1>Login With OTP</h1>
        <span></span>
        <!-- if user found show otp field start -->
        <?php if (isset($_GET['success'])) { ?>
          <input type="number" name="OTP" placeholder="Enter Your OTP">
        <?php    } else {   ?>
          <!-- if user found show otp field end -->
          <!-- if user not found show Phone Or Email field start -->
          <input type="text" name="phone" placeholder="Enter Your Phone Or Email">
        <?php   } ?>
        <!-- if user not found show Phone Or Email field end -->
        <a href="#">Forget your Password?</a>
        <!-- if user found show otp field start -->
        <?php if (isset($_GET['success'])) { ?>

          <button class="" type="submit" name="check-otp">Check OTP</button>
          <a href="./OTP.php">Back</a>

        <?php    } else {   ?>
          <!-- if user found show Check OTP end -->
          <!-- if user not found show Send To Phone & Send To Email field start -->
          <button class="" type="submit" name="send-phone">Send To Phone</button>
          <button class="mt-4">Send To Email</button>
        <?php   } ?>
        <!-- if user not found show Send To Phone & Send To Email field start -->

        <!-- if user not found show (user not found error) start-->
        <?php if (isset($_GET['error'])) { ?>
          <?php if ($_GET['error'] == "notuser") {  ?>
            <p class="flex items-center p-4 mb-4 text-sm text-red-400 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800">user not found</p>
          <?php   } else if ($_GET['error'] == "incorrect_OTP") { ?>
            <p class="flex items-center p-4 mb-4 text-sm text-red-400 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800">Incorrect OTP</p>
          <?php    } ?>
        <?php    } ?>
        <!-- if user not found show (user not found error) end-->
        <!-- if user found notify the user that OTP has been sent start -->
        <?php if (isset($_GET['success'])) { ?>
          <?php if ($_GET['success'] == "sendOTP") { ?>
            <p class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">OTP has been sent</p>
          <?php } else if ($_GET['success'] == "loginned") { ?>
            <p class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">Loginned Into Account</p>
          <?php    } ?>
        <?php    } ?>
        <!-- if user found notify the user that OTP has been sent start -->
      </form>
    </div>
  </div>
</body>
<script>
  const container = document.getElementById('container');
  const registerBtn = document.getElementById('register');
  const loginBtn = document.getElementById('login')

  registerBtn.addEventListener('click', () => {
    container.classList.add('active');
  });

  loginBtn.addEventListener('click', () => {
    container.classList.remove('active');
  });
</script>

</html>