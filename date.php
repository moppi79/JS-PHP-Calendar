<?php

include('date_class.php');


$test = new calender_create();


$test->start_date($_POST['month'],$_POST['year']);


$test->week_nr(1); #week on/off

$test->week_day(1); #week_day on/off

$test->month_switch(1); #month on/off

$test->data_insert('table','background-color: a400ff;color: 4f006f; border: 1px solid black; border-collapse: collapse;',''); #define Month CSS
$test->data_insert('year','background-color: a400ff;color: 4f006f; padding: 15px; border-collapse: collapse; border: 1px solid black;',''); #define Month CSS
$test->data_insert('day','background-color: f2f222;color: 4f006f; padding: 15px; border-collapse: collapse; border: 1px solid black',''); #your Standart Daily
$test->data_insert('overlap','background-color: d3d3d3;color: 4f006f; padding: 15px; border-collapse: collapse; border: 1px solid black',''); #define Month overlapping
$test->data_insert('week','background-color: a80375;color: 4f006f; padding: 15px; border-collapse: collapse; border: 1px solid black',''); # name of day or 




$test->data_insert("d6".$_POST['month']."",'background-color: ffffff;color: 4f006f;','');
$test->data_insert("d9".$_POST['month']."",'background-color: ffffff;color: 4f006f;','ggg');

print (json_encode($test->Calendar()));

?>
