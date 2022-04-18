<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment3";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    $sql = "SELECT `id`, `name`, `cardnumber`, `month`, `year` FROM `cards`";
    $result = $conn->query($sql);
?>
<html>

<head>
    <title>View Cards</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid" style="background: rgba(200, 201, 207, 1); height: 100%; top: 0; position: fixed;">
        <div class="mx-auto my-sm-5 p-sm-4" style="width: 600px; background: rgba(255, 255, 255, 0.9);">
            <div class="mx-auto" style="text-align: center;"><span style="font-weight: bold; font-size: 20;">Saved cards</span></div>
            <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
            ?>
            <div class="mx-auto my-sm-3 px-sm-5 py-sm-2" style=" background: rgba(200, 201, 207, 1); border-radius: 5px;">
                <div class="row">
                    <div class="col-sm-6">Card Number</div>
                    <div class="col-sm-6"><?php echo $row['cardnumber'];?></div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col-sm-6">Month</div>
                            <div class="col-sm-6"><?php echo $row['month'];?></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col-sm-6">Year</div>
                            <div class="col-sm-6"><?php echo $row['year'];?></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">Name</div>
                    <div class="col-sm-6"><?php echo $row['name'];?></div>
                </div>
            </div>
            <?php
                    }
                } else {
                    echo '<div class="mx-auto" style="text-align: center;"><span font-size: 16;">No saved cards</span></div>';
                }
            }
                $conn->close();
            ?>
            <div class="row">
                <a class="form-group btn btn-danger col mx-sm-3" href='index.php'>Back</a>
            </div>
        </div>


    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>