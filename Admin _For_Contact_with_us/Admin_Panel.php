<?php
require_once("./loader.php");
$ShowList = true;
$Explains = "";

$sql = "SELECT * FROM Contacts";

$Haslink = $conn->prepare($sql);

$Haslink->execute();

$Data = $Haslink->fetchALL(PDO::FETCH_OBJ);

// var_dump($Data);
// var_dump($Haslink);

if (isset($_GET['ExplainId'])) {

  $sql = "SELECT * FROM Contacts WHERE Id=?";

  $Haslink = $conn->prepare($sql);

  $Haslink->bindValue(1, $_GET['ExplainId']);

  $Haslink->execute();

  $Data = $Haslink->fetch(PDO::FETCH_OBJ);


  $ShowList = false;
  $Explains = $Data->Explains;
  // var_dump($EndpointRedirectLink['Endpoint_Link']);
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <link rel="stylesheet" href="../src/output.css">
  <title>Support</title>
</head>

<body>
  <div class="bg-slate-950 h-screen text-right">
    <?php if (!$ShowList) {    ?>

      <div class="message-body text-white">

        <p><?= $Explains ?></p>
        <hr>
        <a href="./Admin_Panel.php" class="btn btn-primary">بازگشت</a>

      </div>

    <?php  } else {  ?>
      <table class="table caption-top">
        <caption class="text-white text-end">لیست فرم های ثبت شده</caption>
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">نام</th>
            <th scope="col">موبایل</th>
            <th scope="col">ایمیل</th>
            <th scope="col"> عملیات: مشاهده توضیحات </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($Data as $key => $Item):  ?>
            <tr>
              <th scope="row"><?= ++$key ?></th>
              <td><?= $Item->{'Name'}   ?></td>
              <td><?= $Item->{'Phone'}   ?></td>
              <td><?= $Item->{'Email'}   ?></td>
              <td><a href="?ExplainId=<?= $Item->Id ?>" class="btn btn-primary">عملیات</a></td>
            </tr>
          <?php endforeach;  ?>

        </tbody>
      </table>
    <?php  } ?>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

</html>