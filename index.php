<!DOCTYPE html>
<html lang="en">
<head>
  <title>Практична робота №4</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
<div class="jumbotron">
 <h1>Практична робота №4</h1>
  <p>ІСА-301</p> 
</div>
  <div class="row">
  <div class="col-md-4">
  <div class="page-header">
    <h1 id="progress">Додати</h1>
  </div>
  <form method="post">
  <fieldset>
    <div class="form-group">
      <label>ПІБ:</label>
      <input type="text" name="fullname" class="form-control" placeholder="Заповніть поле">
    </div>
    <div class="form-group">
      <label>Стать</label>
      <input type="text" name="sex" class="form-control" placeholder="Заповніть поле">
    </div>
    <div class="form-group">
      <label>Сімейний стан</label>
      <input type="text" name="marital_status" class="form-control" placeholder="Заповніть поле">
    </div>
    <div class="form-group">
      <label>Освіта</label>
      <input type="text" name="education" class="form-control" placeholder="Заповніть поле">
    </div>
    <button type="submit" name="act" value="add" class="btn btn-primary">Відправити</button>
  </fieldset>
</form>
  </div>
  <div class="col-md-7 col-md-offset-1">
  <div class="page-header">
              <h1 id="progress">Перелік користувачів</h1>
            </div>
  </br>
      <table class="table table-striped table-hover table-bordered">
      <thead class="thead-dark">
        <tr>
          <th>ПІБ</th>
          <th>Стать</th>
          <th>Сімейний стан</th>
          <th>Освіта</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";

$conn = mysqli_connect($servername, $username, $password, $dbname);


if(isset($_GET['act'])) {
  if($_GET['act'] == "delete") {
    $result = $conn->query("DELETE FROM `mydb`.`users` WHERE  `id`='$_GET[id]'");

    echo '<div class="alert alert-dismissible alert-success">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  Дані <strong>Успішно</strong> видалені.
</div>';
  }
  if($_POST['act'] == "add") {
    $result = $conn->query("INSERT INTO `users` (`fullname`, `sex`, `marital_status`, `education`) VALUES ('$_POST[fullname]', '$_POST[sex]', '$_POST[marital_status]', '$_POST[education]')");

    echo '<div class="alert alert-dismissible alert-success">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  Дані <strong>Успішно</strong> додані.
</div>';
  }
  if($_GET['act'] == "edit") {
    $result = $conn->query("UPDATE `users` SET `fullname`='$_GET[fullname]', `sex`='$_GET[sex]', `marital_status`='$_GET[marital_status]', `education`='$_GET[education]' WHERE `id`='$_GET[id]'");

    echo '<div class="alert alert-dismissible alert-success">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  Дані <strong>Успішно</strong> змінені.
</div>';
  }
}


$result = $conn->query("SELECT id, fullname, sex, marital_status, education FROM users");

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc())
    {
      echo "<tr><td>".$row["fullname"]."</td><td>".$row["sex"]."</td><td>".$row["marital_status"]."</td><td>".$row["education"]."</td><td>
      <button type='button' class='btn btn-info btn-sm' data-toggle='modal' data-target='#modal".$row["id"]."'>
        <i class='fa fa-pencil' style='font-size:12px;'></i>
      </button>
      <a href='index.php?act=delete&id=".$row["id"]."' class='btn btn-danger btn-sm'>
        <i class='fa fa-times' style='font-size:12px;'></i>
      </a>
      
</td></tr>";
    }
}
else echo "Помилка";
$conn->close();
?>
</tbody></table>
  </div>
  <!-- Modal -->
<?php
$conn = mysqli_connect($servername, $username, $password, $dbname);

$result = $conn->query("SELECT id, fullname, sex, marital_status, education FROM users");

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc())
    {
      echo '<div class="modal fade" id="modal'.$row["id"].'" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Редагування</h4>
        </div>
      <div class="modal-body">
        <form>
          <fieldset>
            <div class="form-group">
              <label>ПІБ:</label>
              <input type="text" class="form-control" name="fullname" value='.$row["fullname"].' placeholder="Заповніть поле">
            </div>
            <div class="form-group">
              <label>Стать</label>
              <input type="text" class="form-control" name="sex" value='.$row["sex"].' placeholder="Заповніть поле">
            </div>
            <div class="form-group">
              <label>Сімейний стан</label>
              <input type="text" class="form-control" name="marital_status" value='.$row["marital_status"].' placeholder="Заповніть поле">
            </div>
            <div class="form-group">
              <label>Освіта</label>
              <input type="text" class="form-control" name="education" value='.$row["education"].' placeholder="Заповніть поле">
            </div>
            <input type="hidden" name="id" value="'.$row["id"].'">
            <button type="submit" name="act" value="edit" class="btn btn-primary">Відправити</button>
          </fieldset>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрити</button>
      </div>
    </div>
  </div>
</div>';
    }
}
else echo "Помилка";
$conn->close();
?>
</div>
<footer id="footer">
        <div class="row">
          <div class="col-lg-12">
</p>

          </div>
        </div>

      </footer>
</body>
</html>