<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         queryResultAdminUsers.php
Description;  Searches names matching user input typed in admin panel customer search form.
Usage;        n/a
-->
<?php
include("globalUI/globalConnect.php");

  /* Searches for surnames that match the query */
  $stmt = $globalDB->prepare("SELECT user_id, first_name, prefix, surname, date_birth, sex, email, phone, privilege_level, address_id
                              FROM users
                              WHERE surname
                              LIKE ?
                              ORDER BY surname");
  $stmt->bindValue(1, "%" . $_GET['q'] . "%", PDO::PARAM_STR);
  $stmt->execute();
  $results = $stmt->fetchAll();

  if (sizeof($results) > 0) {
    foreach ($results as $user) {
      $name = "";
      if (empty($user[2])) {
        $name = "" . $user[1] . " " . $user[3];
      } else {
        $name = "" . $user[1] . " " . $user[2] . " " . $user[3];
      }
      $sqladd = "SELECT street, number, addition, postcode, city FROM addresses WHERE address_id = '$user[9]'";
      $queryadd = $globalDB->prepare($sqladd);
      $queryadd->execute();
      $address = $queryadd->fetch();
      $addressvalue = "";
      if (empty($address[2])) {
        $addressvalue = "" . $address[0] . " " . $address[1] . ", " . $address[3] . " " . $address[4];
      } else {
        $addressvalue = "" . $address[0] . " " . $address[1] . " " . $address[2] . ", " . $address[3] . " " . $address[4];
      }
      $parts = explode('-', $user[4]);
      $birthday = "" . $parts[2] . "-" . $parts[1] . "-" . $parts[0];
      if ($user[5] == "male") {
        $sex = "Man";
      } else {
        $sex = "Vrouw";
      }
      /* Puts the information requested into a row */
      print('
        <tr class="table-row" name="user_rowsel" onclick=window.location.href="admingegevens.php?user_id='.$user[0].'">
          <td data-label=ID>'.$user[0].'</td>
          <td data-label=Naam>'.$name.'</td>
          <td data-label=Geboortedatum>'.$birthday.'</td>
          <td data-label=Geslacht>'.$sex.'</td>
          <td data-label=Adres>'.$addressvalue.'</td>
          <td data-label=E-mailadres>'.$user[6].'</td>
          <td data-label=Telefoonnumer>'.$user[7].'</td>
          <td data-label=Level>'.$user[8].'</td>
        </tr>
      ');
    }
  }
?>
