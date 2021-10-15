<?php
  require 'db.php';

  $data = $_POST;

  if(isset($data["title"])) {
    $bean = R::findOne( 'timetables', ' id = ? ', [$data['id']]);
    $bean->user = $_SESSION['logged_user']->login;
    $bean->title = $data['title'];
    $bean->start_event = $data['start'];
    $bean->end_event = $data['end'];    
    $bean->commentary = $data['commentary'];
    R::store($bean);
  }
?>