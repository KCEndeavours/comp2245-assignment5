<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// Check if a country query is specified
if (isset($_GET['country'])) {
    $country = $_GET['country'];
    $searchTerm = "%$country%";

    // Use the country in your SQL query to get specific information
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    $stmt->bindParam(':country', $searchTerm, PDO::PARAM_STR);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // If no country is specified, get information about all countries
    $stmt = $conn->query("SELECT * FROM countries");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<table>
 <thead>
  <tr>
  <th>Name of Country</th>
  <th>Continent</th>
  <th>Independence</th>
  <th>Head of State</th>
  </tr>
</thead>
 <tbody>
  <?php foreach ($results as $row): ?>
  <tr>
  <td><?= $row['name']; ?></td>
  <td><?= $row['continent']; ?></td>
  <td><?= $row['independence_year']; ?></td>
  <td><?= $row['head_of_state']; ?></td>
  </tr>
  <?php endforeach; ?>
 </tbody>
</table>
