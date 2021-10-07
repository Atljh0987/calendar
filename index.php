<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
  <link href='node_modules/fullcalendar/main.min.css' rel='stylesheet' />
</head>
<body>
	<?php 
		require 'db.php';
	?>

	<?php if ( isset ($_SESSION['logged_user']) ) : ?>
    <div>
      <span> Авторизован!</span><br/>
      <span>Привет, <?php echo $_SESSION['logged_user']->login; ?>!</span><br/>
      <a href="logout.php">Выйти</a>

      <div class="container">
        <div id="calendar"></div>
      </div>
    </div>
	<?php else : ?>
		<div>
			<h3>Вы не авторизованы</h3><br/>
			<a href="/login.php">Авторизация</a>
			<a href="/signup.php">Регистрация</a>
		</div>
	<?php endif; ?>
</body>
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src='node_modules/fullcalendar/main.min.js'></script>
<script>
  $(document).ready(function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      editable: true,
      headerToolbar: { 
        start: 'prev,next today',
        center: 'title',
        end: 'dayGridMonth,dayGridWeek,dayGridDay'
      },
      selectable: true
    });
    calendar.render();
  })

</script>
</html>	



