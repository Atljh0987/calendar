<div style="width: 50%;">
  <canvas  id="myChart"></canvas>
</div>

<?php
  require 'db.php';

  // $tt = R::getAll( "SELECT date(start_event) st, count(title) count FROM timetables 
  // where start_event >= CURDATE() and user_id='" . 
  // $_SESSION['logged_user']->id ."' GROUP BY date(start_event) ");

  $tt = R::getAll("
    SELECT date(start_event) st, 
    sum(abs(TIME_TO_SEC(TIMEDIFF(STR_TO_DATE(end_event,'%Y-%m-%dT%H:%i:%s.%f'),
    STR_TO_DATE(start_event,'%Y-%m-%dT%H:%i:%s.%f'))) / 3600 )) count 
    from timetables where start_event >= CURDATE() and user_id='" . 
    $_SESSION['logged_user']->id ."'
    GROUP by date(start_event)");

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
      label: 'Минуты',
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