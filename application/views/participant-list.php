<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>

</head>

<body>
<form method="post" action>
  <input type="text" name="search" autofocus="true"/> <input type="submit" name="searched"/>
</form>

<br/>
<br/>

<table border="1">
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Age</th>
    <th>Date of Birth</th>
    <th>Profession</th>
    <th>Locality</th>
    <th>Number of Guests</th>
    <th>Address</th>
  </tr>
<?php
foreach($list as $li){
?>
  <tr>
    <td><?= $li->id;?></td>
    <td><?= $li->name;?></td>
    <td><?= $li->age;?></td>
    <td><?= $li->date_of_birth;?></td>
    <td><?= $li->profession;?></td>
    <td><?= $li->locality;?></td>
    <td><?= $li->number_of_guests;?></td>
    <td><?= $li->address;?></td>
  </tr>
<?php
}
 ?>
</table>

<br/>
<br/>

<form method="post" action>
  <?php
    for($i = 1; $i <= $totalPages; $i++){
      echo '<input type="submit" name="page" value="'.$i.'"/> ';
    }
  ?>
</form>

</body>
</html>
