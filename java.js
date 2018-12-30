
//################# JSON SEND #################

function json_return($data,$adress,onoff,destination){ //function für den asyncron modus
	
	var dbcheck = new XMLHttpRequest(); //request erstellen 
	
		dbcheck.onreadystatechange = function () {
        if (dbcheck.readyState == 4 && dbcheck.status == 200) {

              //destination(JSON.parse(dbcheck.responseText));
				test = JSON.parse(dbcheck.responseText);
				//alert(test['anzahl']);
				destination(test);
            }
        }
		
		dbcheck.open('post', $adress, onoff);
		dbcheck.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		dbcheck.send($data); //POST format "fname=Henry&lname=Ford"
}



//################# JSON SEND #################

function ausgabe (a){
    
    
    document.getElementById("Ansicht").innerHTML = a['Kalender'];
    
   var i;
    for (i = 0; i < Object.keys(a['value']).length; i++) {
        
        data(a['value'][i]['id'],a['value'][i]['style'],a['value'][i]['value']); 
    }

}


function abfrage (month,year){
    
     //document.getElementById("copy").style.backgroundImage = "url('latest.jpg')";

    json_return('month='+ month +'&year='+ year +'','date.php','false',ausgabe);
    
    //document.getElementById("test1").innerHTML = loop
    
    var month_back = month - 1;
    var month_forwart = 1 + parseInt(month);
    
   if (month_back == 0){
       var new_year = year - 1;
       document.getElementById("back").innerHTML = "<button onclick=\"abfrage('12','"+ new_year +"');\" >back</button>";
   }else {
       
       document.getElementById("back").innerHTML = "<button onclick=\"abfrage('"+ month_back + "','"+ year +"');\" >back</button>";
   }
   
    if (month_forwart == 13){
       var new_year = parseInt(year) + 1;
       document.getElementById("vor").innerHTML = "<button onclick=\"abfrage('1','"+ new_year +"');\" >vor</button>";
   }else {
       
       document.getElementById("vor").innerHTML = "<button onclick=\"abfrage('"+ month_forwart + "','"+ year +"');\" >vor</button>";
       
   }
   
}



function data(item,style,value) {

  var a2 ="style";
  
  if ((item == 'overlap') || (item == 'week') || (item == 'day')){
      for (i = 0; i < document.getElementsByClassName(item).length; i++) {
        var i;
        
        document.getElementsByClassName(item)[i].setAttribute(a2, style);
        } 
  }else{
      
      document.getElementById(item).setAttribute(a2, style); 
      if (value != ''){
          
          document.getElementById(item).innerHTML = value;
          
      }
      
  }
  
  
    //document.getElementsByClassName("old")[2].style.backgroundColor = index;
}
