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

function ausgabe (a){ //send data to Div
    
    
    document.getElementById("Ansicht").innerHTML = a['Kalender']; //overwrite The div with new Data
    
   var i;
    for (i = 0; i < Object.keys(a['value']).length; i++) { //walk CSS data in JSON Objekt
        
        data(a['value'][i]['id'],a['value'][i]['style'],a['value'][i]['value']); //Send CSS data to data() 
    }

}


function abfrage (month,year){ //call a new Month
    
    json_return('month='+ month +'&year='+ year +'','date.php','false',ausgabe); //send data to ausgabe()
    
    var month_back = month - 1;
    var month_forwart = 1 + parseInt(month);
    
    
    
   if (month_back == 0){ //Set buttons to new month 
       var new_year = year - 1;
       document.getElementById("back").innerHTML = "<button onclick=\"abfrage('12','"+ new_year +"');\" >back</button>";
   }else {
       
       document.getElementById("back").innerHTML = "<button onclick=\"abfrage('"+ month_back + "','"+ year +"');\" >back</button>";
   }
   
    if (month_forwart == 13){ //Set buttons to new month 
       var new_year = parseInt(year) + 1;
       document.getElementById("vor").innerHTML = "<button onclick=\"abfrage('1','"+ new_year +"');\" >vor</button>";
   }else {
       
       document.getElementById("vor").innerHTML = "<button onclick=\"abfrage('"+ month_forwart + "','"+ year +"');\" >vor</button>";
       
   }
   
}



function data(item,style,value) { //fills CSS data in Elements

  var a2 ="style"; //devince Style
  
  if ((item == 'overlap') || (item == 'week') || (item == 'day')){ //Class name Data !!! 
      for (i = 0; i < document.getElementsByClassName(item).length; i++) { //to fill all Class member
        var i;
        
        document.getElementsByClassName(item)[i].setAttribute(a2, style);
        } 
  }else{ //Element Id Data or Single Data
      
      document.getElementById(item).setAttribute(a2, style); 
      if (value != ''){ //To fill Cell with new Value
          
          document.getElementById(item).innerHTML = value;
          
      }
      
  }

}
