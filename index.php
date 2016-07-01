<?php
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/credentials.local.inc.php';
?>

<form>
  <label for="registrant">Registrant Name</label>
  <input name="registrant" type="text" placeholder="Name">
  <input name="amount" type="number" placeholder="Price" min="1">
  <input type="submit" value="Submit">
</form>
