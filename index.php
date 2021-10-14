<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
  <link href='node_modules/fullcalendar/main.min.css' rel='stylesheet' />
  <!-- <link href='node_modules/bootstrap/dist/css/bootstrap.min.css' rel='stylesheet' /> -->
  <link rel="stylesheet" type="text/css" href="styles/index.css">
</head>
<body>
	<?php 
		require 'db.php';
	?>

	<?php if ( isset ($_SESSION['logged_user']) ) : ?>
    <div class="wrapper">
      <div class="header">
        <div class="autorize">
          <span>Привет, <?php echo $_SESSION['logged_user']->login; ?>!</span><br/>
          <a href="logout.php" class="autorize__logout">Выйти</a>
        </div>
      </div>

      <div class="container">
        <div class="container_settings">
          <h1>Контейнер</h1>
        </div>
        <div id="calendar"></div>
      </div>
    </div>
	<?php else : ?>
		<!-- <div>
			<h3>Вы не авторизованы</h3><br/>
			<a href="/login.php">Авторизация</a>
			<a href="/signup.php">Регистрация</a>
		</div> -->
    <?php 
      ob_start();
      header('Location: /login.php');
      ob_end_flush();
      die();
    ?>
	<?php endif; ?>
</body>
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src='node_modules/fullcalendar/main.min.js'></script>
<!-- <script src='node_modules/bootstrap/dist/js/bootstrap.min.js'></script> -->
<!-- <script src='node_modules/bootstrap/dist/js/bootstrap.bundle.min.js'></script> -->
<script>
  $(document).ready(function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      // themeSystem: 'bootstrap',
      editable: true,
      initialView: 'dayGridMonth',
      showNonCurrentDates: false,
      headerToolbar: { 
        start: 'prev,next today',
        center: 'title',
        end: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
      },
      events: 'getData.php',
      selectable: true,
      selectHelper: true,
      select: function(time) {
        var title = prompt("Enter Event Title");
        if(title) {
          $.ajax({
            url: "/insert.php",
            type: "POST",
            data: {title: title, start: time.startStr, end: time.endStr},
            success: function() {
              calendar.refetchEvents()
            }
          })
        }
      },
      eventResize: function(info) {
        var title = info.event.title;
        var start = info.event.startStr;
        var end = info.event.endStr;
        var id = info.event.id;
        if(title) {
          $.ajax({
            url: "/update.php",
            type: "POST",
            data: {title: title, start: start, end: end, id: id},
            success: function() {
              calendar.refetchEvents()
            }
          })
        }
      },
      eventDrop: function(info) {
        var title = info.event.title;
        var start = info.event.startStr;
        var end = info.event.endStr;
        var id = info.event.id;
        if(title) {
          $.ajax({
            url: "/update.php",
            type: "POST",
            data: {title: title, start: start, end: end, id: id},
            success: function() {
              calendar.refetchEvents()
            }
          })
        }
      },
      eventClick: function (info) {
        if(confirm("Are you sure you want to remove it?")) {
          var title = info.event.title;
          var start = info.event.startStr;
          var end = info.event.endStr;
          var id = info.event.id;
          if(title) {
            $.ajax({
              url: "/delete.php",
              type: "POST",
              data: {title: title, start: start, end: end, id: id},
              success: function() {
                calendar.refetchEvents()
              }
            })
          }
        }
      }
    });
    calendar.render();
  })


</script>

</html>	



