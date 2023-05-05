<?php 


$array = range(1, 1000000); // Generate an array with 1000000 elements

$times = array();

// ---- A -----------------------------------------
for ($j = 0; $j < 100; $j++) {
    $start_time = microtime(true);
    $ant = count($array);
    for ($i = 0 ; $i<$ant; $i++) {
        //echo "[".$array[$i]."]";
    }
    $end_time = microtime(true);
    $times['A'][] = $end_time - $start_time;
}

// ---- B -----------------------------------------
for ($j = 0; $j < 100; $j++) {
    $start_time = microtime(true);
    foreach ($array as $nr) {
        //echo "[".$nr."]";
    }
    $end_time = microtime(true);
    $times['B'][] = $end_time - $start_time;
}

// ---- C -----------------------------------------
for ($j = 0; $j < 100; $j++) {
    $start_time = microtime(true);
    for ($i = 0, $ant = count($array) ; $i<$ant; $i++) {
        //echo "[".$array[$i]."]";
    }
    $end_time = microtime(true);
    $times['C'][] = $end_time - $start_time;
}

// ---- D -----------------------------------------
for ($j = 0; $j < 100; $j++) {
    $start_time = microtime(true);
    for ($i = 0 ; $i<count($array); $i++) {
        //echo "[".$array[$i]."]";
    }
    $end_time = microtime(true);
    $times['D'][] = $end_time - $start_time;
}

// Calculate and print the average times in order of fastest
$average_times = array();
foreach ($times as $loop => $loop_times) {
    $average_time = array_sum($loop_times) / count($loop_times);
    $average_times[$loop] = $average_time;
}

asort($average_times);

foreach ($average_times as $loop => $average_time) {
    echo "Loop $loop: " . $average_time . " seconds<br>";
}

?>