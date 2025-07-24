<?php
include_once('Config/loader.php');
?>

<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="./output.css">
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="./Assets/css/sign_up&in.css">
  <link rel="stylesheet" href="">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>sign_in</title>
</head>

<body>
  <div class="container" id="container">
    <!-- sign up fields section start-->
    <div class="form-container sign-up">
      <form method="POST" action="./Action/sign_up.php">
        <h1>Create Account</h1>
        <div class="social-icons">
          <a href="#" class="icons"><i
              class="fa-brands fa-google-plus-g"></i></a>
          <a href="#" class="icons"><i
              class="fa-brands fa-facebook-f"></i></a>
          <a href="#" class="icons"><i class="fa-brands fa-github"></i></a>
          <a href="#" class="icons"><i
              class="fa-brands fa-linkedin-in"></i></a>
        </div>
        <span>or use your email to registration</span>
        <input type="text" name="username" placeholder="username">
        <input type="email" name="email" placeholder="Email">
        <input type="text" name="phone" placeholder="phone number">
        <input type="password" name="password" placeholder="Password">
        <button type="submit" name="sign_up" class="cursor-pointer">Sign Up</button>
      </form>
    </div>
    <!-- sign up fields section end-->
    <!-- sign in fields section start-->
    <div class="form-container sign-in">
      <form method="POST" action="./Action/sign_in.php">
        <h1>Sign In</h1>
        <div class="social-icons">
          <a href="#" class="icons"><i
              class="fa-brands fa-google-plus-g"></i></a>
          <a href="#" class="icons"><i
              class="fa-brands fa-facebook-f"></i></a>
          <a href="#" class="icons"><i class="fa-brands fa-github"></i></a>
          <a href="#" class="icons"><i
              class="fa-brands fa-linkedin-in"></i></a>
        </div>
        <span>or use your Username / Phone / Email</span>
        <input type="text" name="key" placeholder="Username / Phone / Email">
        <input type="password" name="password" placeholder="Password">
        <a href="#">Forget your Password?</a>
        <a class="inline" href="./OTP.php">Login with OTP</a>
        <button type="submit" name="sign_in" class="cursor-pointer">Sign In</button>
        <!-- login atempt failed start -->
        <?php if (isset($_GET['notuser'])) {    ?>
          <p class="flex items-center p-4 mb-4 text-sm text-red-400 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800">user not found</p>
          <!-- login atempt failed start -->
          <!-- loginned successfully start -->
        <?php    } elseif (isset($_GET['loginned'])) {  ?>
          <p class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">loginned successfully</p>
        <?php    } ?>
        <!-- loginned successfully end -->
      </form>
    </div>
    <!-- sign in fields section end-->
    <div class="toggle-container">
      <div class="toggle">
        <div class="toggle-panel toggle-left">
          <h1>Welcome Back!</h1>
          <p>Enter your Personal details to use all of site features</p>
          <button class="" id="login">Sign In</button>
        </div>
        <div class="toggle-panel toggle-right">
          <h1>Hello, Friend!</h1>
          <p>Register with your Personal details to use all of site
            features</p>
          <button class="" id="register">Sign Up</button>
        </div>
      </div>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

</html>