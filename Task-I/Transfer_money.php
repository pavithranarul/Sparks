<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transfer Money</title>
  <link rel="stylesheet" href="transfer.css">
</head>
<body>
<nav>
  <ul class="navbar">
    <li><a href="view_all_customers.php"><b> Back </b></a></li></ul></nav>
  <h2>Transfer Money</h2>

  <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $senderId = $_POST['senderId'];
      $receiverId = $_POST['receiverId'];
      $amount = $_POST['amount'];

      // Perform necessary database operations to transfer the money
      $connection = mysqli_connect("localhost", "root", "", "banking system");

      // Retrieve sender and receiver details
      $query = "SELECT * FROM customer WHERE c_id IN ($senderId, $receiverId)";
      $result = mysqli_query($connection, $query);

      $customers = array();
      while ($row = mysqli_fetch_assoc($result)) {
        $customers[$row['c_id']] = $row;
      }

      // Check if sender has sufficient balance
      $sender = $customers[$senderId];
      if ($sender['balance'] >= $amount) {
        // Perform the money transfer
        $sender['balance'] -= $amount;
        $receiver = $customers[$receiverId];
        $receiver['balance'] += $amount;

        // Update sender and receiver balances in the database
        $query = "UPDATE customer SET balance = ".$sender['balance']." WHERE c_id = $senderId";
        mysqli_query($connection, $query);

        $query = "UPDATE customer SET balance = ".$receiver['balance']." WHERE c_id = $receiverId";
        mysqli_query($connection, $query);
        echo '<script type="text/Javascript">alert("Successfully Transferred")</script>';

        // Redirect back to the view all customers page
        header("refresh:2;url=view_all_customers.php");
        exit();
      } else {
        echo '<script type="text/Javascript">alert("Insufficient balance.")</script>';
        header("refresh:3;url=view_all_customers.php");
      }

      mysqli_close($connection);
    }
  ?>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="hidden" name="senderId" value="<?php echo $_GET['sender']; ?>">
    <label for="receiver">Select Receiver:</label>
    <select id="receiver" name="receiverId">
      <?php
        // Retrieve all customers except the sender from the database
        $connection = mysqli_connect("localhost", "root", "", "banking system");
        $query = "SELECT * FROM customer WHERE c_id != ".$_GET['sender'];
        $result = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($result)) {
          echo "<option value='".$row['c_id']."'>".$row['name']."</option>";
        }

        mysqli_close($connection);
      ?>
    </select>
    <br>
    <label for="amount">Amount:</label>
    <input type="number" id="amount" name="amount" min="0" step="0.01" required>
    <br>
    <input type="submit" value="Transfer" class="t">
  </form>
</body>
</html>
