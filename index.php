<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

<table>
    <tr>
        <th>ID</th>
        <th>Kép</th>
        <th>Megnevezés</th>
        <th>Hozzáadva</th>
        <th>Ugrás</th>
    </tr>
<?php

require_once "con.php";

$result = $mysqli->query("SELECT * FROM data ORDER by id DESC");
$rows = $result->fetch_assoc();

foreach ($result as $key => $a) {
    echo '
        <tr>
            <td>'.$a['id'].'</td>
            <td><img src="'.$a['image'].'" /></td>
            <td>'.$a['name'].'</td>
            <td>'.$a['created_at'].'</td>
            <td><a href="'.$a['url'].'" target="_blank">UGRÁS</a></td>
        </tr>
    ';
}
    
?>

</body>
</html>
