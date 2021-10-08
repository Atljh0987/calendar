<?php
  require 'db.php';

  $data = $_POST;
  var_dump($data);

  if(isset($data["title"])) {
    $tt = R::dispense('timetables');
    $tt->user = $_SESSION['logged_user']->login;
    $tt->title = $data['title'];
    $tt->start_event = $data['start'];
    $tt->end_event = $data['end'];
    R::store($tt);
  }

  // INSERT INTO `timetables` (`id`, `user`, `title`, `start_event`, `end_event`)
  //  VALUES (NULL, 'yjkyu', 'ikyuk', '2021-10-08 10:31:00.000000', '2021-10-08 17:31:00');
?>