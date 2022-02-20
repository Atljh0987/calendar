<div>
  <canvas id="myChart"></canvas>
</div>

<?php
  require 'db.php';

  $tt = R::getAll( "SELECT date(start_event) st, count(title) count FROM timetables 
  where start_event >= CURDATE() and user='" . 
  $_SESSION['logged_user']->login ."' GROUP BY date(start_event) ");

  function dates($t) {
    return $t["st"];
  }

  function counts($t) {
    return $t["count"];
  }

  $dates = array_map('dates', $tt);
  $counts = array_map('counts', $tt);

  var_dump($dates);
  var_dump($counts);
  // $js_array = json_encode($php_array);
  // echo "var javascript_array = ". $js_array . ";\n";
  ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

  var labels = <?php echo json_encode($dates); ?>;
  // const labels = [
  //   'January',
  //   'February',
  //   'March',
  //   'April',
  //   'May',
  //   'June',
  //   'Jule'
  // ];

  const data = {
    labels: labels,
    datasets: [{
      label: 'My First dataset',
      backgroundColor: 'rgb(255, 99, 132)',
      borderColor: 'rgb(255, 99, 132)',
      data: <?php echo json_encode($counts); ?>,
    }]
  };

  const config = {
    type: 'line',
    data: data,
    options: {}
  };

  const myChart = new Chart(
    document.getElementById('myChart'),
    config
  );
</script>