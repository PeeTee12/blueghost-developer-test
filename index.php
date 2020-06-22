<?php
require_once 'config/config.php';
$info = '';
$url = '';
if (!empty($_GET['url']))
  $url = basename($_GET['url']);
$database = new mysqli(DATABASE, USERNAME, PASSWORD, DATABASE_NAME, PORT);
$database->set_charset('utf8');
if (isset($_POST['update'])) {
  $updateQuery = $database->prepare('UPDATE clients SET name = ?, phone = ?, email = ?, description = ? WHERE id = '.$_POST['id']);
  $updateQuery->bind_param('ssss', $name, $phone, $email, $description);
  $name = htmlspecialchars($_POST['name']);
  $phone = htmlspecialchars($_POST['phone']);
  $email = htmlspecialchars($_POST['email']);
  $description = htmlspecialchars($_POST['description']);
  if($updateQuery->execute())
    $info = 'Klient úspěšně upraven.';
  else
    $info = 'Klient nebyl úspěšně upraven.';
}
if (isset($_POST['create'])) {
  $createQuery = $database->prepare('INSERT INTO clients (name, phone, email, description) VALUES (?, ?, ?, ?)');
  $createQuery->bind_param('ssss', $name, $phone, $email, $description);
  $name = htmlspecialchars($_POST['name']);
  $phone = htmlspecialchars($_POST['phone']);
  $email = htmlspecialchars($_POST['email']);
  $description = htmlspecialchars($_POST['description']);
  if($createQuery->execute())
    $info = 'Klient úspěšně vytvořen.';
  else
    $info = 'Klient nebyl úspěšně vytvořen.';
}
if (isset($_POST['delete'])) {
  if ($database->query('DELETE FROM clients WHERE id = '.$_POST['id']))
    $info = 'Klient úspěšně odstraněn.';
  else
    $info = 'Klient nebyl úspěšně odstraněn.';
}
$clientList =
  '<table>
    <thead>
        <tr>
          <th>Jméno a příjmení</th>
          <th>Telefonní číslo</th>
          <th>Email</th>
          <th>Dlouhá poznámka</th>
          <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>';
$clientQuery = $database->query('SELECT * FROM clients');
if ($clientQuery && $clientQuery->num_rows) {
  while ($client = $clientQuery->fetch_assoc()) {
    $clientList .=
      '<tr>
        <td>'.$client['name'].'</td>
        <td>'.$client['phone'].'</td>
        <td>'.$client['email'].'</td>
        <td>'.$client['description'].'</td>
        <td colspan="2"><a href="./identifikator-kontaktu?id='.$client['id'].'">Upravit</a></td>
      </tr>';
  }
}
$clientList .=
    '</tbody>
  </table>';

?>
<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="UTF-8">
  <title>Klienti</title>
</head>
<body>
  <?php
    if ($url === IDENTIFIKATOR_KONTAKTU)
      include('./identifikator-kontaktu.php');
    else {
      echo '<h1>Seznam klientů</h1>';
      echo
        '<button><a href="./identifikator-kontaktu">Vytvořit klienta</a></button>
        <p>'.$info.'</p>';
      echo $clientList;

    }
  ?>
</body>
</html>