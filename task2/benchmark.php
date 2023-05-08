<?php 

$array = range(1, 1000000); // Generate an array with 1000000 elements

//randomize the array
shuffle($array);

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

// Results:
// 1:
// Loop B: 0.0096433758735657 seconds
// Loop A: 0.011380925178528 seconds
// Loop C: 0.011663844585419 seconds
// Loop D: 0.030632042884827 seconds
//2:
// Loop B: 0.0092501068115234 seconds
// Loop A: 0.011196420192719 seconds
// Loop C: 0.011532874107361 seconds
// Loop D: 0.030122628211975 seconds
//3:
// Loop B: 0.0092702555656433 seconds
// Loop C: 0.011247909069061 seconds
// Loop A: 0.011366536617279 seconds
// Loop D: 0.03011958360672 seconds
//4:
// Loop B: 0.0091671776771545 seconds
// Loop C: 0.011183226108551 seconds
// Loop A: 0.011333756446838 seconds
// Loop D: 0.030087449550629 seconds

?>

