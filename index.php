<html>
<body>

<form action="">
  Month: 
  <select name="month">
    <option value="1">January</option>
    <option value="2">February</option>
    <option value="3">March</option>
    <option value="4">April</option>
    <option value="5">May</option>
    <option value="6">June</option>
    <option value="7">July</option>
    <option value="8">August</option>
    <option value="9">September</option>
    <option value="10">October</option>
    <option value="11">November</option>
    <option value="12">December</option>
  </select>
  
  Year: 
  <select name="month">
    <option value="1990">1990</option>
    <option value="1991">1991</option>
    <option value="1992">1992</option>
    <option value="1993">1993</option>
    <option value="1994">1994</option>
    <option value="1995">1995</option>
    <option value="1996">1996</option>
    <option value="1997">1997</option>
    <option value="1998">1998</option>
    <option value="1999">1999</option>
    <option value="2000">2000</option>
    <option value="2001">2001</option>
    <option value="2002">2002</option>
    <option value="2003">2003</option>
    <option value="2004">2004</option>
    <option value="2005">2005</option>
    <option value="2006">2006</option>
    <option value="2007">2007</option>
    <option value="2008">2008</option>
    <option value="2009">2009</option>
    <option value="2010">2010</option>
    <option value="2011">2011</option>
    <option value="2012">2012</option>
    <option value="2013">2013</option>
    <option value="2014">2014</option>
    <option value="2015">2015</option>
    <option value="2016">2016</option>
    <option value="2017">2017</option>
    <option value="2018">2018</option>
    <option value="2019">2019</option>
    <option value="2020">2020</option>
    <option value="2021">2021</option>
    <option value="2022">2022</option>
    <option value="2023">2023</option>
    <option value="2024">2024</option>
    <option value="2025">2025</option>
    <option value="2026">2026</option>
    <option value="2027">2027</option>
    <option value="2028">2028</option>
    <option value="2029">2029</option>
    <option value="2030">2030</option>
  </select>
</form>


<table>
<tr>
  <th>MON</th>
  <th>TUE</th>
  <th>WED</th>
  <th>THU</th>
  <th>FRI</th>
  <th>SAT</th>
  <th>SUN</th>
</tr>

<?php

//Now we output the current months

$month = 3;
$year = 2016;

$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
//Remember that Sunday is 0 and so on.
date_default_timezone_set("UTC");
$dayOfWeekToStartOn = date("w", strtotime($year . "-" . $month . '-1'));

#Maybe use mktime?!

$datesToOutput = array();

//If the month didn't start on a Monday we need to take a few dates from last month
if ($dayOfWeekToStartOn != 1) {
   $previousMonth = $month - 1;
   $previousMonthYear = $year;
   if ($previousMonth == 0) {
     $previousMonth = 12;
     $previousMonthYear -= 1;
   }
   $numberOfDaysInPreviousMonth = cal_days_in_month(CAL_GREGORIAN, $previousMonth, $previousMonthYear);

   $numberOfDaysNeededFromPreviousMonth = $dayOfWeekToStartOn - 1;
   if ($numberOfDaysNeededFromPreviousMonth == 0) {
     $numberOfDaysNeededFromPreviousMonth = 6;
   }

   //Now we'll add this many dates to the output.
   for ($iii = $numberOfDaysNeededFromPreviousMonth; $iii > 0; $iii--) {
     $datesToOutput[] = $numberOfDaysInPreviousMonth - $iii + 1;
   }
}

//Now we add the numbers from the current month to the array to output
$datesToOutput = array_merge($datesToOutput, range(1, $daysInMonth));

//Append the first few dates of the next month if we don't end on a Sunday.
$dayOfWeekOfLastDay = date("w", strtotime($year . "-" . $month . "-" . $daysInMonth));
if ($dayOfWeekOfLastDay != 0) {
  //If 1 then 6
  //If 2 then 5
  $datesFromNextMonth = range(1, 7 - $dayOfWeekOfLastDay);
  $datesToOutput = array_merge($datesToOutput, $datesFromNextMonth);
}

foreach ($datesToOutput as $date) {
  echo $date . " ";
}

?>

</table>

</body>
</html>