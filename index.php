<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
  <link href='node_modules/fullcalendar/main.min.css' rel='stylesheet' />
  <!-- <link href='node_modules/bootstrap/dist/css/bootstrap.min.css' rel='stylesheet' /> -->
  <link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
	<?php 
		require 'db.php';
	?>

	<?php if ( isset ($_SESSION['logged_user']) ) : ?>
      <header class="header">
        <h1 class="header__logo">Календарь-планировщик</h1>
        <div>
          <div id="txtButton" class="autorize__logout">Выгрузить</div>
          <a href="statistic.php" class="autorize__logout">Статистика</a>
        </div>
        <div class="autorize">
          <h3 class="autorize__login-text"><?php echo $_SESSION['logged_user']->login; ?></h3><br/>
          <a href="logout.php" class="autorize__logout">Выйти</a>
      </div>
      </header>

    <div class="wrapper">
      <div class="container">
        <!-- <div class="container_settings">
          <h1>Контейнер</h1>
        </div> -->
        <div id="calendar"></div>
      </div>
    </div>

    <div class="main_enter_form">
    <div class="enter hide">
      <div class="enter_wrapper">

        <div class="enter_form hide">
          <h4 class="enter_error" style="color: red"></h4>
          <h3 class="enter_main_title">Без имени</h3>
          <label>Начало: <input class="enter_time-start" type="datetime-local"></label>
          <label>Конец: <input class="enter_time-end" type="datetime-local"></label>
          <label>Комментарий<Br>
            <textarea class="enter_commentary" name="comment" cols="40" rows="3"></textarea>
          </label>
          <input class="change_button" type="button" value="Изменить" />
          <input class="delete_button" type="button" value="Удалить" />
        </div>

        <div class="add_form hide">
          <h4 class="add_error" style="color: red"></h4>
          <h3>Добавление события</h3>
          <label>Название: <input class="add_title" type="text"></label>
          <label>Начало: <input class="add_time-start" type="datetime-local"></label>
          <label>Конец: <input class="add_time-end" type="datetime-local"></label>
          <label>Комментарий<Br>
            <textarea class="add_commentary" name="comment" cols="40" rows="3"></textarea>
          </label>
          <input class="add_button" type="button" value="Добавить" />
        </div>
      </div>   
      <div class="enter_bg"></div>
      </div>
    </div>
	<?php else : ?>
		<!-- <div>
			<h3>Вы не авторизованы</h3><br/>
			<a href="/login.php">Авторизация</a>
			<a href="/signup.php">Регистрация</a>
		</div> -->
    <!-- <?php 
      ob_start();
      header('Location: login.php');
      ob_end_flush();
      die();
    ?> -->
	<?php endif; ?>
</body>
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="node_modules/moment/moment.js"></script>
<script src='node_modules/fullcalendar/main.min.js'></script>
<!-- <script src='node_modules/bootstrap/dist/js/bootstrap.min.js'></script> -->
<!-- <script src='node_modules/bootstrap/dist/js/bootstrap.bundle.min.js'></script> -->


<script>
  $(document).ready(function() {
    var calendarEl = document.getElementById('calendar');
    var data = {};
    $('#txtButton').on('click', function() {
      $.ajax({
        url: "/download.php",
        type: "post",
        data: {},
        success: function(data) {
          window.location = 'download.php';
        }
      })
    })

    $('.enter_bg').on('click', function() {
      $('.enter').addClass('hide')
      $('.enter_form').addClass('hide')
      $('.add_form').addClass('hide')
    })

    $('.change_button').on('click', function() {
      
      $('.enter_error').text("")
      let id = data.id
      let title = data.title
      let start = $('.enter_time-start').val()
      let end = $('.enter_time-end').val()
      let commentary = $('.enter_commentary').val()

      if(start && end) {
        $('.enter').addClass('hide')
        $('.add_form').addClass('hide')
        $('.enter_form').addClass('hide')

        $.ajax({
          url: "/update.php",
          type: "POST",
          data: {title: title, start: start, end: end, commentary: commentary, id: id},
          success: function() {
            calendar.refetchEvents()
          }
        })
      } else {
        $('.enter_error').text("Поля с датой и временем обязательны к заполнению")
      }
    })

    $('.delete_button').on('click', function() {
      $('.enter').addClass('hide')
      $('.add_form').addClass('hide')
      $('.enter_form').addClass('hide')
      
      let id = data.id
      let title = data.title      
      $.ajax({
        url: "/delete.php",
        type: "POST",
        data: {title: title, id: id},
        success: function() {
          calendar.refetchEvents()
        }
      })
    })

    $('.add_button').on('click', function() {
      let title = $('.add_title').val()
      let start = $('.add_time-start').val()
      let end = $('.add_time-end').val()
      let commentary = $('.add_commentary').val()

      if(title && start && end) {    
        $('.enter').addClass('hide')
        $('.add_form').addClass('hide')
        $('.enter_form').addClass('hide')

        $.ajax({
            url: "/insert.php",
            type: "POST",
            data: {title: title, start: start, end: end, commentary: commentary},
            success: function() {
              calendar.refetchEvents()
            }
          })

          $('.add_title').val("")
          $('.add_time-start').val("")
          $('.add_time-end').val("")
          $('.add_commentary').val("")
      } else {
        $('.add_error').text("Название и время обязательны к заполнению")
      }
    })

    var calendar = new FullCalendar.Calendar(calendarEl, {
      timeZone: 'America/New_York',
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
        $('.enter').removeClass('hide');
        $('.add_form').removeClass('hide')
      
        $('.add_error').text("")

        let start = (time.startStr.length < 11)? time.startStr + "T00:00" : time.startStr
        let end = (time.endStr.length < 11)? time.endStr + "T00:00" : time.endStr
        
        $('.add_time-start').val(start)
        $('.add_time-end').val(end)
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
        data.title = info.event.title;
        data.start = info.event.startStr;
        data.end = info.event.endStr;
        data.id = info.event.id;
        data.commentary = info.event.extendedProps.description        
        $('.enter').removeClass('hide');
        $('.enter_form').removeClass('hide')
      
        $('.add_error').text("")

        $('.enter_main_title').text(info.event.title)
        $('.enter_time-start').val(info.event.startStr)
        $('.enter_time-end').val(info.event.endStr)
        $('.enter_commentary').val(info.event.extendedProps.description)
      }
    });
    calendar.render();
  })


</script>

</html>	



