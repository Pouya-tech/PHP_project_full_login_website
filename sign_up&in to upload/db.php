<?php
// کانکت شدن به سرور دیتا بیس
$conn = mysqli_connect('localhost' , 'root' , '' , 'english-class');
// بررسی اتصال به دیتا بیس
if (!$conn) {
  die("❌خطا در برقراری ارتباط با دیس بیس" . mysqli_connect_error($conn));
}
?>