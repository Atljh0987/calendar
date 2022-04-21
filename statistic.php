<?php
  require 'db.php';

  $data = $_POST;

  $startDate = date("Y-m-d");
  $endDate = date("Y-m-d", strtotime("+14 day", strtotime($startDate)));

  if(isset($data['startDate']) && isset($data['endDate'])) {
    $startDate = $data['startDate'];
    $endDate = $data['endDate'];
  }  

  $tt = R::getAll("
    SELECT date(start_event) st, 
    sum(abs(TIME_TO_SEC(TIMEDIFF(STR_TO_DATE(end_event,'%Y-%m-%dT%H:%i:%s.%f'),
    STR_TO_DATE(start_event,'%Y-%m-%dT%H:%i:%s.%f'))) / 3600 )) count 
    from timetables where 
    start_event between '" . $startDate ."' and '" . $endDate ."'
    and user_id='" . 
    $_SESSION['logged_user']->id ."'
    GROUP by date(start_event)");

  $hoursPerDay = R::getAll("
    
    select 
      avg(count) avgCount, 
      min(count) minCount, 
      max(count) maxCount, 
      sum(count) sumCount  
    from 
    (SELECT  
    sum(abs(TIME_TO_SEC(TIMEDIFF(STR_TO_DATE(end_event,'%Y-%m-%dT%H:%i:%s.%f'),
    STR_TO_DATE(start_event,'%Y-%m-%dT%H:%i:%s.%f'))) / 3600 )) count 
    from timetables where 
    start_event between '" . $startDate ."' and '" . $endDate ."'
    and user_id='" . 
    $_SESSION['logged_user']->id ."'
    GROUP by date(start_event)) t
  ");

  $avgHoursPerDay = round(floatval($hoursPerDay[0]["avgCount"]), 2);
  $minHoursPerDay = floatval($hoursPerDay[0]["minCount"]);
  $maxHoursPerDay = floatval($hoursPerDay[0]["maxCount"]);
  $sumHoursPerDay = floatval($hoursPerDay[0]["sumCount"]);
?>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
  <link href='node_modules/fullcalendar/main.min.css' rel='stylesheet' />
  <link rel="stylesheet" type="text/css" href="css/index.css">
  <style>
    .stat {
      margin-left: 10px;
    }
    .stat p, .stat h1 {
      margin-bottom: 10px;
    }

    @media screen and (max-width: 1200px) {
      .stat_container {
        flex-direction: column;
      }
    }
  </style>
</head>

<div class="header">
  <a href="index.php" class="autorize__logout" style="width: 100px">Назад</a>
</div>

<div style="display: flex;" class="stat_container">
  <div style="width: 100%;">
    <canvas  id="myChart"></canvas>
  </div>
  <div class="stat" style="width: 100%; display: flex; flex-direction: column;">
    <h1>Статистика</h1>
    
    <p>Среднее кол-во часов: <?=$avgHoursPerDay ?></p>
    <p>Минимальное кол-во часов: <?=$minHoursPerDay ?></p>
    <p>Максимальное кол-во часов: <?=$maxHoursPerDay ?></p>
    <p>Общее кол-во часов: <?=$sumHoursPerDay ?></p>

    <form action="statistic.php" method="POST" style="flex-direction: column;">
      <label for="startDate">Начало
        <input id="startDate" type="date" name="startDate" value=<?=$startDate?>>
      </label>
      <label for="endDate">Окончание
        <input id="endDate" type="date" name="endDate" value=<?=$endDate?>>
      </label>
      
      <input type="submit" value="Отправить"></p>
    </form>
  </div>
</div>


<?php
  

  
  // $tt = R::getAll( "SELECT date(start_event) st, count(title) count FROM timetables 
  // where start_event >= CURDATE() and user_id='" . 
  // $_SESSION['logged_user']->id ."' GROUP BY date(start_event) ");
  
  
  //start_event >= CURDATE() 

  

  function dates($t) {
    return $t["st"];
  }

  function counts($t) {
    return $t["count"];
  }

  $dates = array_map('dates', $tt);
  $counts = array_map('counts', $tt);
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

  var labels = <?php echo json_encode($dates); ?>;

  const data = {
    labels: labels,
    datasets: [{
      label: 'Часы',
      backgroundColor: 'rgb(255, 99, 132)',
      borderColor: 'rgb(255, 99, 132)',
      data: <?php echo json_encode($counts); ?>,
    }]
  };

  const config = {
    type: 'bar',
    data: data,
    options: {}
  };

  const myChart = new Chart(
    document.getElementById('myChart'),
    config
  );
</script>