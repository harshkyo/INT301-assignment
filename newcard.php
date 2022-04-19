<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment3";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} else {
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function clean_input($field)
    {
      $field = trim($field);
      $field = stripslashes($field);
      $field = htmlspecialchars($field);
      return $field;
    }
    function validate_name()
    {
      $pattern = '/^[a-zA-Z ]*$/';
      $name = clean_input($_POST['name']);
      if (strlen($name) == 0) {
        echo "<p style='color:red;'>Field cannot be empty</p>";
        return false;
      }
      else if (!preg_match($pattern, $name)) {
        echo "<p style='color:red;'>Name should only have alphabets and spaces</p>";
        return false;
      }
      return true;
    }

    function validate_cardnum()
    {
      $cardnum = clean_input($_POST['cardnum']);
      $pattern = '/^[0-9]*$/';
      if (strlen($cardnum) == 0) {
        echo "<p style='color:red;'>Field cannot be empty</p>";
        return false;
        return;
      } else if (!preg_match($pattern, $cardnum)) {
        echo "<p style='color:red;'>Only numbers are allowed</p>";
        return false;
      } else if (strlen($cardnum) != 16) {
        echo "<p style='color:red;'>16 digit card number required</p>";
        return false;
      }
      return true;
    }
    function validate_cvv()
    {
      $cvv = clean_input($_POST['cvv']);
      $pattern = '/^[0-9]*$/';
      if (strlen($cvv) == 0) {
        echo "<p style='color:red;'>Field cannot be empty</p>";
        return false;
      } else if (!preg_match($pattern, $cvv)) {
        echo "<p style='color:red;'>Only numbers are allowed</p>";
        return false;
      }
      else if (strlen($cvv) != 3) {
        echo "<p style='color:red;'>CVV should be of 3 digit</p>";
        return false;
      }
      return true;
    }
    if (validate_name() && validate_cardnum() && validate_cvv()) {
      $name = clean_input($_POST['name']);
      $cardnum = clean_input($_POST['cardnum']);
      $month = $_POST['month'];
      $year = $_POST['year'];
      $statement = $conn->prepare("insert into cards(name, cardnumber, month, year) values(?, ?, ?, ?)");
      $statement->bind_param("siii", $name, $cardnum, $month, $year);
      $execval = $statement->execute();
      $statement->close();
      $conn->close();
      if ($execval) header("Location: index.php");
    }
    else $conn->close();
  }
}

?>
<html>

<head>
  <title>Card Details</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>

  <div class="container-fluid" style="background: rgba(200, 201, 207, 1); height: 100%; top: 0; position: fixed;">
    <form class="mx-auto my-sm-5 p-sm-4" style="width: 600px; background: rgba(255, 255, 255, 0.9);" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <div class="mx-auto" style="text-align: center;"><span style="font-weight: bold; font-size: 20;">Card Details:</span></div>
      </br>
      <div class="form-group">
        <label for="cardnum">Card Number</label>
        <input type="text" class="form-control" name="cardnum" placeholder="Enter Card Number" value="<?php echo isset($_POST["cardnum"]) ? htmlentities($_POST["cardnum"]) : ''; ?>">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          validate_cardnum();
        }
        ?>
      </div>
      <div class="row">
        <div class="form-group col-sm-6">
          <label for="month">Month</label>
          <select class="custom-select" class="form-control" name="month">
            <option selected>Select month</option>
            <?php
            for ($i = 1; $i < 13; $i++) {
              echo "<option value=$i ";
              echo ((isset($_POST["month"]) && $_POST["month"] == "$i") ? "selected >" : " >") . (($i < 10) ? "0$i" : $i);
              echo "</option>";
            }
            ?>
          </select>
        </div>
        <div class="form-group col-sm-6">
          <label for="year">Year</label>
          <select class="custom-select" class="form-control" name="year">
            <option selected>Select Year</option>
            <?php
            $currentyear = date("y");
            for ($i = $currentyear; $i < $currentyear + 20; $i++) {
              echo "<option value=$i ";
              echo ((isset($_POST["year"]) && $_POST["year"] == "$i") ? "selected >" : " >") . (($i < 10) ? "0$i" : $i);
              echo "</option>";
            }
            ?>
          </select>
        </div>
      </div>
      <div class="row">
        <div class="form-group col-sm-9">
          <label for="Entername">Name On Card</label>
          <input type="text" class="form-control" name="name" placeholder="Enter Name" value="<?php echo isset($_POST["name"]) ? htmlentities($_POST["name"]) : ''; ?>">
          <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST") {
            validate_name();
          }
          ?>
        </div>
        <div class="form-group col-sm-3">
          <label for="cvv">CVV</label>
          <input type="password" class="form-control" name="cvv" placeholder="***">
          <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST") {
            validate_cvv();
          }
          ?>
        </div>
      </div>
      </br>
      <div class="row">
        <a class="form-group btn btn-danger col mx-sm-3" href='index.php'>Cancel</a>
        <button type="submit" class="form-group btn btn-success col mx-sm-3">Save</button>
      </div>
    </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>