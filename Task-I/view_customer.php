<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Customer</title>
  <link rel="stylesheet" href="vc.css">
</head>
<body>
<nav>
  <ul class="navbar">
    <li><a href="view_all_customers.php"><b> Back </b></a></li></ul></nav>
  <h2>Customer Details</h2>
  <div>

  <?php
    if (isset($_GET['id'])) {
      $customerId = $_GET['id'];

      // Retrieve the customer's details from the database
      $connection = mysqli_connect("localhost", "root", "", "banking system");
      $query = "SELECT * FROM customer WHERE c_id = $customerId";
      $result = mysqli_query($connection, $query);
      $customer = mysqli_fetch_assoc($result);
      if ($customer) {
        echo "<p><span>Name:</span> ".$customer['name']."</p>";
        echo "<p><span>Email:</span> ".$customer['mail']."</p>";
        echo "<p><span>Balance:</span> ".$customer['balance']."</p>";
        echo "<p><a href='transfer_money.php?sender=".$customer['c_id']."'>Transfer Money</a></p>";
      } else {
        echo "Customer not found.";
      }

      mysqli_close($connection);
    } else {
      echo "Invalid customer ID.";
    }
  ?></div>
</body>
</html>
