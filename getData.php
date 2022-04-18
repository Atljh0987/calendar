<?php
    require 'db.php';


    $tt = R::getAll( "SELECT id, title, start_event start, end_event end, commentary description FROM timetables where user_id='" .  $_SESSION['logged_user']->id ."'");

    
    echo json_encode($tt);
?>