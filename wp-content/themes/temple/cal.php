<?php @session_start();
require_once('../../../wp-config.php');
global $wpdb;
$temple_id=$_REQUEST['temple_id'];
$date =time () ;

//This puts the day, month, and year in seperate variables
if(!isset($_REQUEST['date']))
{
	$month = date('m', $date) ;
	$year = date('Y', $date) ;
}
else
{
	$dat1 = $_REQUEST['date'] ;
	$dt=explode('-',$dat1);
	$month=$dt[0];
	$year=$dt[1];
	$date = mktime(0,0,0,$month, 1, $year) ;
}

//Here we generate the first day of the month
$first_day = mktime(0,0,0,$month, 1, $year) ;

//This gets us the month name
$title = date('F', $first_day) ;

//Here we find out what day of the week the first day of the month falls on 
 $day_of_week = date('D', $first_day) ; 



 //Once we know what day of the week it falls on, we know how many blank days occure before it. If the first day of the week is a Sunday then it would be zero

 switch($day_of_week){ 

 case "Sun": $blank = 0; break; 

 case "Mon": $blank = 1; break; 

 case "Tue": $blank = 2; break; 

 case "Wed": $blank = 3; break; 

 case "Thu": $blank = 4; break; 

 case "Fri": $blank = 5; break; 

 case "Sat": $blank = 6; break; 

 }



 //We then determine how many days are in the current month

 $days_in_month = cal_days_in_month(0, $month, $year) ; 
 
 //Here we start building the table heads 
$prevmonth = strtotime(date("Y-m-d", $date) . " -1 month");
$nextmonth = strtotime(date("Y-m-d", $date) . " +1 month");
 echo '<table id="temple-calendar" cellpadding="0" cellspacing="0" border="0">';

 echo'<caption>
            <a href="'.date("m-Y", $prevmonth).'" class="prearw npdate"><</a>  '.$title.' '.$year.' <a href="'.date("m-Y", $nextmonth).'" class="nextarw npdate">></a>
      </caption>';

 echo '<thead class="daysname">
              <tr>
			  	<th title="Sunday" scope="col">Sunday</th>
                <th title="Monday" scope="col">Monday</th>
                <th title="Tuesday" scope="col">Tuesday</th>
                <th title="Wednesday" scope="col">Wednesday</th>
                <th title="Thursday" scope="col">Thursday</th>
                <th title="Friday" scope="col">Friday</th>
                <th title="Saturday" scope="col">Saturday</th>
              </tr>
            </thead>';



 //This counts the days in the week, up to 7

 $day_count = 1;



 echo "<tr>";

 //first we take care of those blank days

 while ( $blank > 0 ) 

 { 

 echo "<td class='blank'></td>"; 

 $blank = $blank-1; 

 $day_count++;

 } 
 //sets the first day of the month to 1 

 $day_num = 1;



 //count up the days, untill we've done all of them in the month

 while ( $day_num <= $days_in_month ) 
 { 
 	if($day_num<10)
	{
		$d_n='0'.$day_num;
	}
	else
	{
		$d_n=$day_num;
	}
	$cdate=$year.'-'.$month.'-'.$d_n;
	$calendar=templecalendar($temple_id, " and cdate='$cdate'");
	if(count($calendar)>0)
	{
		$img='<img src="'.get_option('home').'/wp-content/themes/temple/images/calendar_default.jpg" alt="'.$calendar[0]->title.'" style="max-width:50px;" />';
		if(trim($calendar[0]->image)!='' && file_exists('../../../wp-content/uploads/temples/calendar/'.$calendar[0]->image)){
			$img='<img src="'.get_option('home').'/wp-content/uploads/temples/calendar/'.$calendar[0]->image.'" alt="'.$calendar[0]->title.'" style="max-width:50px;" />';
		}
 		echo '<td> <a href="javascript:;" class="showcaldetail" title="'.$calendar[0]->title.'">'.$day_num.'<br class="clr" />'.$img.'</a>
			<div class="calendardetail">
				<div class="closebtns"><a href="javascript:;" class="closecalendar">Close</a> <a href="javascript:;" class="movecalendar">Move</a></div>
				<div class="calcontents">
					<p>Special : <span>'.$calendar[0]->special.'</span></p>
					<p>Worship : <span>'.$calendar[0]->worship.'</span></p>
				</div>
			</div>
		</td>'; 
	}
	else
	{
		$img='<img src="'.get_option('home').'/wp-content/themes/temple/images/calendar_default.jpg" alt="'.$calendar[0]->title.'" style="max-width:50px;" />';
		echo '<td> <a href="javascript:;">'.$day_num.'<br class="clr" />'.$img.'</a></td>';
	}
 $day_num++; 

 $day_count++;



 //Make sure we start a new row every week

 if ($day_count > 7)

 {

 echo "</tr><tr>";

 $day_count = 1;

 }

 }
 //Finaly we finish out the table with some blank details if needed

 while ( $day_count >1 && $day_count <=7 ) 

 { 

 echo "<td class='blank'></td>"; 

 $day_count++; 

 } 

 
 echo "</tr></table>"; 
?>