<?php
  require 'db.php';

  $data = $_POST;

  if(isset($data["title"])) {
    $bean = R::findOne( 'timetables', ' id = ? ', [$data['id']]);
    $bean->user_id = $_SESSION['logged_user']->id;
    $bean->title = $data['title'];
    $bean->start_event = $data['start'];
    $bean->end_event = $data['end'];    
    $bean->commentary = $data['commentary'];
    R::store($bean);
  }
?>