<?php
// اتصال به دیتا بیس
// include('db.php');
// خالی نبودن فیلد ها
// if (!isset($_POST['phone']) || empty($_POST['phone'])) {
//   echo "شماره تلفن وارد نشده است: ";
//   exit;
// }
// $phone_number = mysqli_real_escape_string($conn, $_POST['phone']);
// کد 4 رقمی تصادفی
$token = mt_rand(1000, 9000);
//  ذخیره کد در سشن
$_SESSION['verification_code'] = $token;
// $_SESSION['phone_number'] = $phone_number;
// محاصبه تاریخ ارسال کد
// $expires_at = date('Y-m-d H:i:s', time() + 60);
// ذخیره در دیتا بیس
// // $query = "INSERT INTO otp_codes (phone_number , code , expires_at) VALUES ('$phone_number' ,'$token' , '$expires_at')";
// mysqli_query($conn , $query);
// ارسال پیامک
require './src/vendor/autoload.php';
$sender = "100075752";
$receptor = "09966270418";
$message = "!سلام";

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
