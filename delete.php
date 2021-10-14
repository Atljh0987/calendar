<?php
  require 'db.php';

  $data = $_POST;

  if(isset($data["title"])) {
    $bean = R::findOne( 'timetables', ' id = ? ', [$data['id']]);
    R::trash($bean);
  }
?>