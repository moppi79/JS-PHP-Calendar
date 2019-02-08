var hover_child;

var mou_x;

var mou_y;

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
    
    if (a['hover'] != 0){ //activate Hover and setting Mouse

        var str_mou = a['hover']['value'].split(':');
        mou_x = parseInt(str_mou[0]);
        mou_y = parseInt(str_mou[1]);
        
        hover_funk(a['hover']['style']);
    }
    
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
      console.log(item);
      document.getElementById(item).setAttribute(a2, style); 
      
      var spl = value.split('..;..')
      if ((item != 'table') && (item != 'year')){
          if (spl[1] == '1'){ //To fill Cell with new Value
              
              document.getElementById(item).innerHTML = spl[0] + '<span class=\'tttt\'>'+spl[0]+'</span>';
              
          }else{
              
              console.log(item);
              document.getElementById(item+'span').innerHTML = spl[0] ;
              
          }
      }
  }
    

}


function hover_funk(style){
	
hover_child =	document.createElement('style');
hover_child.appendChild(document.createTextNode(""));

document.head.appendChild(hover_child);

var css_values = hover_child.sheet;

	css_values.insertRule('.day .tttt {'+ style +'visibility: hidden; position: absolute;}',0);
	css_values.insertRule('.day:hover .tttt {visibility: visible;}',0);

	document.addEventListener('mousemove',logKey)
	
}

function logKey(e) { //mouse scan

var jump = hover_child.sheet


jump.cssRules[0].style.top = (e.clientY + mou_y)  +'px'; 

jump.cssRules[0].style.left = (e.clientX + mou_x)  +'px'; 

}

