<?php
require_once("./loader.php");
// check if user has logged in
if (isset($_SESSION['User_id'])) {
  echo "<p class = 'alert alert-primary'> سلام " . htmlspecialchars($_SESSION['Username']) . " خوش آمدید</p>";
  $User_id = $_SESSION['User_id'];

  // var_dump($_SESSION);

  $sql = "SELECT * FROM files WHERE User_id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$User_id]);

  $files = $stmt->fetchALL(PDO::FETCH_ASSOC);
} else {
  echo "⛔لطفا ابتدا لاگین کنید";
  exit;
}

if (isset($_POST["submit"])) {

  $target_dir = "Uploads/";
  $File_name = "format-" . time() . "-" . basename($_FILES["fileToUpload"]["name"]);
  $target_file = $target_dir . $File_name;
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
      $User_id = $_SESSION['User_id'];

      $sql = "INSERT INTO files SET User_id=?,  name= ? , Create_Time=?";

      $result = $conn->prepare($sql);

      $result->bindValue(1, $User_id);
      $result->bindValue(2, $File_name);
      $result->bindValue(3, time());

      $result->execute();
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
}
// delete a file
if (isset($_GET['delete'])) {

  $sql = "DELETE FROM files WHERE id=?";

  $result = $conn->prepare($sql);

  $result->bindValue(1, $_GET['delete']);

  $result->execute();

  header("Location: ./Upload.php");
}

?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

  <link rel="stylesheet" href="/src/output.css">
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <title>آپلود فایل</title>

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

    #shorten-button[type=submit] {
      background-color: #4CAF50;
      color: white;
      padding: 10px 15px;
      border: none;
      cursor: pointer;
    }

    #shorten-result {
      margin-top: 10px;
      font-weight: bold;
    }

    [type="file"]::file-selector-button {
      width: 5%;
    }

    [type="file"] {
      width: 30%;
      min-width: 10%;
    }

    [type="file"]::file-selector-button {
      width: 55%;
      margin-inline-end: 0;
      padding: 0.6rem;
      background-color: lawngreen;
      color: smoke;
      border: none;
      border-radius: 0;
      text-transform: uppercase;
    }
  </style>
  <div id=".alert">
  </div>
</head>

<body>
  <div>
    <form action="./Upload.php" method="post" enctype="multipart/form-data">
      تصویر خود را انتخاب کنید:
      <input class="cursor-pointer" type="file" name="fileToUpload" id="fileToUpload">
      <br>
      <input class="mt-5" type="submit" id="shorten-button" value="آپلود تصویر" name="submit">
    </form>
    <br><br><br>

    <table class="table caption-top">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">تصویر / اسم فایل</th>
          <th scope="col">عملیات</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($files as $key => $Item):
          $check = getimagesize(filename: "Uploads/" . $Item["name"]);
          // var_dump($check);
        ?>
          <tr>
            <th scope="row"><?= ++$key ?></th>

            <?php if ($check) {   ?>
              <td> <img src="Uploads/<?= $Item["name"] ?>" height="80px" style="border-radius: 5px;" alt=""></td>
            <?php } else {  ?>
              <td><?= $Item["name"] ?></td>
            <?php  } ?>
            <td><a href="Uploads/<?= $Item["name"] ?>" download class="btn btn-primary">دانلود</a><a href="?delete=<?= $Item["id"] ?>" class="btn btn-danger">حذف</a></td>
          </tr>
        <?php endforeach;  ?>

      </tbody>
    </table>

  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
<script>
  setInterval(function() {
    $(".alert").fadeOut();
  }, 3000);
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</html>