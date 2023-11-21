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
$country = isset($_GET['country']) ? $_GET['country'] : '';
$searchTerm = "%$country%";

// Check if the lookup parameter is set to cities
$isCitiesLookup = isset($_GET['lookup']) && $_GET['lookup'] == 'cities';

// Query to get country or city information
$query = $isCitiesLookup
    ? "SELECT cities.name AS city, cities.district, cities.population FROM cities INNER JOIN countries ON cities.country_code = countries.code WHERE countries.name LIKE :country"
    : "SELECT * FROM countries WHERE name LIKE :country";

$stmt = $conn->prepare($query);
$stmt->bindParam(':country', $searchTerm, PDO::PARAM_STR);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table>
  <thead>
    <tr>
      <?php if ($isCitiesLookup): ?>
        <th>Name of City</th>
        <th>District</th>
        <th>Population</th>
      <?php else: ?>
        <th>Name</th>
        <th>Continent</th>
        <th>Independence</th>
        <th>Head of State</th>
      <?php endif; ?>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($results as $row): ?>
      <tr>
        <?php if ($isCitiesLookup): ?>
          <td><?= $row['city']; ?></td>
          <td><?= $row['district']; ?></td>
          <td><?= $row['population']; ?></td>
        <?php else: ?>
          <td><?= $row['name']; ?></td>
          <td><?= $row['continent']; ?></td>
          <td><?= $row['independence_year']; ?></td>
          <td><?= $row['head_of_state']; ?></td>
        <?php endif; ?>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
