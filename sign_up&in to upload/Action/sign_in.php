<?php
session_start();
require_once('../Config/loader.php');

if (isset($_POST['sign_in'])) {
  try {
    // parameters
    $key = $_POST['key'];
    $password = $_POST['password'];
    // register SQL
    $query = "SELECT * FROM `users` WHERE (Username = :key OR phone = :key OR email = :key) AND (Password = :password) LIMIT 1";
    // Register stmt
    $stmt = $conn->prepare($query);
    // bind
    $stmt->bindValue(":key", $key);
    $stmt->bindValue(":password", $password);
    // execute
    $stmt->execute();

    $result = $stmt->rowCount();
    $Userdata = $stmt->fetch(PDO::FETCH_ASSOC);

    // $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // echo "<pre>";
    // var_dump($result);
    // echo "</pre>";

    if ($result) {
      // echo "you're loginned into website";
      $_SESSION['Username'] = $Userdata['Username'];
      $_SESSION['User_id'] = $Userdata['id'];
      $_SESSION['logged_in'] = true;
      header('Location: ../Upload.php?loginned=ok');
    } else {
      header('Location: ../sign_up&in.php?notuser=ok');
    }
    // echo "Account Created successfully";
    // header('Location: ../sign_up&in.php');
  } catch (PDOException $e) {
    echo "Your error message is : " . $e->getMessage();
  }
}
