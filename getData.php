<?php
    require 'db.php';

    $tt = R::getAll( 'SELECT id, title, start_event start, end_event end FROM timetables where user=' . $_SESSION['logged_user']->login);
    
    echo json_encode($tt);
?>