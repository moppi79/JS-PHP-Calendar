<?php

include('date_class.php'); #Import Class


$test = new calender_create(); #Create new Objekt


$test->start_date($_POST['month'],$_POST['year']); #Submit Month and Year


$test->week_nr(1); #week on/off

$test->week_day(1); #week_day on/off

$test->month_switch(1); #month on/off

$test->basic_insert('table','background-color: a400ff;color: 4f006f; border: 1px solid black; border-collapse: collapse;'); #Define Table Border, Global Table data
$test->basic_insert('year','background-color: a400ff;color: 4f006f; padding: 15px; border-collapse: collapse; border: 1px solid black;'); #Month Year Header
$test->basic_insert('day','background-color: f2f222;color: 4f006f; padding: 15px; border-collapse: collapse; border: 1px solid black'); #Every day cell
$test->basic_insert('overlap','background-color: d3d3d3;color: 4f006f; padding: 15px; border-collapse: collapse; border: 1px solid black'); #Overlapping Days 
$test->basic_insert('week','background-color: a80375;color: 4f006f; padding: 15px; border-collapse: collapse; border: 1px solid black'); # Weekday´s and number of week

$test->hover_insert('width: 120px; background-color: #ff0000; color: #fff00f; text-align: center; border-radius: 6px; padding: 5px;','10:15'); # Style, Mouse Position x:y 



#### data_insert(DAY,CSS DATA,VALUE,Value on/off);
#### DAY --> d[day][month] --> d53 is the 5.3.xxxx 

#### Value on/off, 1 shows Value in The table with the hover, 0 shows the day with value as hovertext 

#### You can all data fill with a DB call or simular

$test->data_insert("d6".$_POST['month']."",'background-color: ffffff;color: 4f006f;','',0);
$test->data_insert("d9".$_POST['month']."",'background-color: ffffff;color: 4f006f;','test',0);
$test->data_insert("d12".$_POST['month']."",'background-color: ffffff;color: 4f006f;','test',1);
print (json_encode($test->Calendar())); #call all data und send zu JS 

?>
