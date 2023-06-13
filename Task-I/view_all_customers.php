<!DOCTYPE html>
<html>
<head>
  <title>View All Customers</title>
  <link rel="stylesheet" href="vac.css">
</head>
<body>
<nav>
  <ul class="navbar">
    <li><a href="index.php"><b> Main </b></a></li></ul></nav>
  <h2>View All Customers</h2>

  <table>
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>View Details</th>
    </tr>
    <?php
      // Retrieve customer data from the database and display it in the table
      $connection = mysqli_connect("localhost", "root", "", "banking system");
      $query = "SELECT * FROM customer";
      $result = mysqli_query($connection, $query);
      
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['mail']."</td>";
        echo "<td><a href='view_customer.php?id=".$row['c_id']."'>View</a></td>";
        echo "</tr>";
      }
      
      mysqli_close($connection);
      // if($connection){
      //   echo "connection successful";
      // }
      // else{
      //   echo "connection unsuccessful";
      // }
    ?>
  </table>
</body>
</html>
