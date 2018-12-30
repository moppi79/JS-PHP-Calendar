<?php
$month = date('n',time());
$year = date('Y',time());


if (--$month == 0){
  
  $back_year = $year - 1;
  $back_month = 12;
  
}else{
  
  $back_year = $year;
  $back_month = $month - 1;
  
}

if ($month++ == 13){
  $vor_year = $year + 1;
  $vor_month = 1;
  
}else{
  
  $vor_year = $year;
  $vor_month = $month + 1;
  
}
?>

<html>
<head>
<script src='java.js' type='text/javascript'></script>
<style>


</style>
</head>


<body onload="abfrage('<?php print $month;?>','<?php print $year;?>');"> 

<div id='Ansicht'></div>


<div id='vor'><button onclick="abfrage('<?php print $vor_month;?>','<?php print $vor_year;?>');" >vor</button></div>


<div id='back'><button onclick="abfrage('<?php print $back_month;?>','<?php print $back_year;?>');" >back</button></div>

</body>
</html>
