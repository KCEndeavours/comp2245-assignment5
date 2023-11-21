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

    // Check if the lookup parameter is set to cities
    if (isset($_GET['lookup']) && $_GET['lookup'] == 'cities') {
        // Query to get cities in the specified country
        $stmt = $conn->prepare("SELECT cities.name AS city, cities.district, cities.population FROM cities INNER JOIN countries ON cities.country_code = countries.code WHERE countries.name LIKE :country");
    } else {
        // Default query to get country information
        $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    }

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
  <?php if (isset($_GET['lookup']) && $_GET['lookup'] == 'cities'): ?>
    <tr>
      <th>Name of City</th>
      <th>District</th>
      <th>Population</th>
    </tr>
  <?php else: ?>
    <tr>
      <th>Name</th>
      <th>Continent</th>
      <th>Independence</th>
      <th>Head of State</th>
    </tr>
  <?php endif; ?>
</thead>
 <tbody>
  <?php foreach ($results as $row): ?>
    <tr>
      <?php if (isset($_GET['lookup']) && $_GET['lookup'] == 'cities'): ?>
        <td><?= $row['city']; ?></td>
        <td><?= $row['district']; ?></td>
        <td><?= $row['population']; ?></td>
      <?php else: ?>
        <?php foreach ($results as $row): ?>
          <tr>
            <td><?= $row['name']; ?></td>
            <td><?= $row['continent']; ?></td>
            <td><?= $row['independence_year']; ?></td>
            <td><?= $row['head_of_state']; ?></td>
          </tr>
          <?php endforeach; ?>
      <?php endif; ?>
    </tr>
  <?php endforeach; ?>
 </tbody>
</table>