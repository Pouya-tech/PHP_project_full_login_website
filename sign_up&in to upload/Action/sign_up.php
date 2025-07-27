<?php
require_once('../Config/loader.php');

if (isset($_POST['sign_up'])) {
  try {
    // parameters
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    // register SQL
    $query = "INSERT INTO users SET username=?, email=?, phone=?, password=?";
    // Register stmt
    $stmt = $conn->prepare($query);
    // bind
    $stmt->bindValue(1, $username);
    $stmt->bindValue(2, $email);
    $stmt->bindValue(3, $phone);
    $stmt->bindValue(4, $password);
    // execute
    $stmt->execute();
    // echo "Account Created successfully";
    header('Location: ../sign_up&in.php');
  } catch (PDOException $e) {
    echo "Your error message is :" . $e->getMessage();
  }
}
