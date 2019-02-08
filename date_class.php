<?php

class calender_create {
    
    public $date_start = ''; #Work Daten
    
    public $error = ''; #Return
    
    public $week_show = 1; #week Show bit
    
    public $week_day_show = 1; #Week of the day show
    
    public $month_show = 1; #Show month/year
    
    public $data = array(); #Push array for all data
    
    #public $data_komplete = array(); 
    
    private $date_id_arr = array(); # for filter Trash data
    
    private $end_begin;
    
    private $loop_values = 0;
    
    public $hover = 0; #hover funktion
    
    public function start_date ($month,$year){### insert Month / Year
        
        $date = mktime('1','1','1',$month,'1',$year);
        
        if ($date == FALSE){
            
            $this->error = 'Month/Year not numerical';
            
            $this->date_start = '';
        }else{
            $this->date_start = $date;
        }
        
    }
    
    public function month_switch($value){ #show month/year
        
        $this->month_show = $value;
        
    }
    
    public function week_nr ($value){#show Week number
        
        $this->week_show = $value;
        
    }
    
    public function week_day ($value){ #show week of the day 
        
        $this->week_day_show = $value;
        
    }
    
    public function basic_insert($id,$Style){ # data insert, ID, CSS style, Value 
        
        $this->data[$id]['style'] = $Style;  
        
        
        
    }
    
    public function hover_insert($Style,$mouse){ # data insert, ID, CSS style, Value 
        
        $this->data['hover']['style'] = $Style;  
        $this->data['hover']['value'] = $mouse;
        $this->hover = array();
        
    }
    
    
    public function data_insert($id,$Style,$value,$onoff){ # data insert, ID, CSS style, Value 
        
        $this->data[$id]['style'] = $Style;  
        $this->data[$id]['value'] = $value;
        $this->data[$id]['onoff'] = $onoff;
        
    }
    
    private function end_begin ($lastday){ ### Begin and end from the month to show overlap 
        $next = date('N',$this->date_start);
        $date = $this->date_start;
        $return['head'] = '';
        $Run = 0;
        while ($next > 1){ #Bevore the month starts, overlap day´s
            $run = 1;
            --$next; 
            $date = $date - 86400;
        
            $return['head'] = "<td class='overlap'>".date('j',$date)."</td>".$return['head']; ##insert optional data here (like Div or ID)
            
        }

        if ($this->week_show == 1){ #show Number of the Week
            
            if ($run == 1){
                $return['head'] = "<th class='week'>".date('W',$date)."</th>".$return['head'];
                
            }
            
            
        }
        
        $return['head'] = "<tr>".$return['head'];
        $next = date('N',$lastday['stamp']);
        $date = $lastday['stamp'];
        $return['foot'] = '';
        while ($next < 7){ # Month end, new month overlap day´s 
            $next++; 
            $date = $date + 86400;
        
            $return['foot'] .= "<td class='overlap'>".date('j',$date)."</td>"; ##insert optional data here (like Div or ID)
        
            
        }
        $return['foot'] .= "</tr>";
        
        return ($return);
        
    }
    
    public function inhalt(){ # Too fill the Calendar with Values.
    
    #This Data will be Used in the JS script. 
        
        //$data_komplete = "aa";
        $loop = array('table','day','overlap'); #Show Entrys he will be ever seen
        
        if ($this->month_show != 0){ #add Class Year in array ... when the Array is autmatic befillt, die JS is Crashing. entry in document not found
           array_push($loop, 'year');
            
           
        }else{
            
            if (isset($this->data['year'])){
                
                unset ($this->data['year']);
            }
        }
        
        if (($this->week_day_show != 0) && ($this->week_show != 0)){ #Add Class week in Array 
            array_push($loop, 'week');
        }else{
            
            if (isset($this->data['week'])){

                unset ($this->data['week']);
            } 
        }

        foreach ($loop as $id){# filling Table data and Class data First
            
            if (is_array($this->data[$id])){
                
                $t1[$this->loop_values]['id'] = $id;
                $t1[$this->loop_values]['value'] = '';
                $t1[$this->loop_values]['style'] = $this->data[$id]['style'];
                //print_r($id);
                //print_r($this->data[$id]);
                unset ($this->data[$id]);
                $this->loop_values++;
            }
            
            
        }
        
        if (is_array($this->data['hover'])){ #add hoverfunktion 
            
                
                $this->hover['id'] = 'hover';
                $this->hover['value'] = $this->data['hover']['value'];
                $this->hover['style'] = $this->data['hover']['style'];
                //print_r($this->hover);
                unset ($this->data['hover']);
                
        }else{
            $this->hover = 0; #set hover off in JS
        }
        
        
        while (list($id, $value) = each($this->data)) { #Filling Data with User Data (using the Rest from $this->data)
			
			if (array_key_exists($id, $this->date_id_arr)) { #sorting Irritating Data

	            $t1[$this->loop_values]['id'] = $id;
	            
	            $t1[$this->loop_values]['style'] = $this->data[$id]['style'];
	            //$t1[$this->loop_values]['onoff'] = $this->data[$id]['onoff'];
	           if ($this->data[$id]['value'] != ''){
                    
                    if ($this->data[$id]['onoff'] == 1){
                       $t1[$this->loop_values]['value'] = $this->data[$id]['value'].'..;..1'; 
                    }else{
                        $t1[$this->loop_values]['value'] = $this->data[$id]['value'].'..;..0';
                    }
                    
                    
                }else{
                    $t1[$this->loop_values]['value'] = ''.'..;..0'; 
                }
	
	            $this->loop_values++;
			}
        
        }

        return ($t1);
    }
    
    public function Calendar (){ #Master Funktion
        
        if ($this->error != ''){ #On Failure ... Break
            print $this->error;
        }else{
            
            $run = date('m',$this->date_start);
            $stop = $run;
            $date_new = $this->date_start;
            $day = 0;
            $return = '';
            while ($run == $stop){ #While Month date is the same. Fill the komplete month
                $day++;
                $month_array[$day]['wd'] = date('N',$date_new); #weekday number
                $month_array[$day]['day'] = $day;
                $month_array[$day]['stamp'] = $date_new;
                if ($month_array[$day]['wd'] == 1){ #is now monday, create new column in Table
                    $return .= "<tr>";
                    
                    if ($this->week_show == 1){ #show week number 
                        $return .= "<th class='week'>".date('W',$date_new)."</th>";
                    }   
                    
                }
                $day_calc = "d".$month_array[$day]['day'].date('n',$date_new);
                
                if ($this->hover != 0){ #adding hover span
                    $hover_span = "<span class='tttt' id='".$day_calc."span'>".$month_array[$day]['day']."</span>";
                }
         
                $return .= "<td class='day' id='".$day_calc."'>".$month_array[$day]['day']." ".$hover_span."</td>"; ## Inserrt Herve your Div/id oder Different, The d on the Begin stand for Day ... CSS needs a Char to the begin
                    
                
                
                $this->date_id_arr[$day_calc] = 1; 
                
                if ($month_array[$day]['wd'] == 7){ #now is sundy, Close column
                    $return .= "</tr>";
                }
                
                
                $date_new = $date_new + 86400;
                $run = date('m',$date_new);
                
            }#end While
            
            $rest = calender_create::end_begin($month_array[$day]); #To fill overlap day´s
            
            ############### monata und jahres ausgebat ########
            if ($this->month_show == 1){ #to show month and year
            
            $monats_array = array('LEER','Januar','Februar','März','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember');
            $monats_anzeige = "<tr><th id='year' colspan='8'>".$monats_array[date('n',$this->date_start)]." ".date('Y',$this->date_start)."</th></tr>";
            }
            
           ############### monata und jahres ausgebat ######## 
            
            
            ########Wochenztag angabe
            $wochentage = array('mo','di','mi','do','fr','sa','so');
            if ($this->week_day_show == 1){ #show day of the week
            
                $ausgabe_wochentage = "<tr>";
                
                if ($this->week_show == 1){
                    
                    $ausgabe_wochentage .= "<th class='week'>Nr.</th>";
                }
                
                while (list($key, $val) = each($wochentage)){
                    
                    $ausgabe_wochentage .= "<th class='week'>".$val."</th>";
                    
                }
                $ausgabe_wochentage .= "</tr>";
            }
            ##################Wochentage 
            
            
            $complete = "<Table id='table'>".$monats_anzeige.$ausgabe_wochentage.$rest['head'].$return.$rest['foot']."</table>"; #complete return
            
            $this->loop_values = 0; #### Reset Value
            
            $end_return['Kalender'] = $complete;
            
            $end_return['value'] = $this->inhalt();
            
            $end_return['hover'] = $this->hover;
            
            return ($end_return);
            
            

        }
    }
    
    
    
}

?>
