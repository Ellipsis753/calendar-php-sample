<?php

class CalandarView {
  private $month = -1;
  private $year = -1;

  public function getMonth() {
    return $this->month;
  }

  public function getYear() {
    return $this->year;
  }

  public function CalandarView($month, $year) {
    if ($month < 1 || $month > 12) {
      throw new InvalidArgumentException("CalandarView created with invalid month: " . $month);
    }
    if ($year < 1980 || $year > 2035) {
      //We use safe limits to avoid some possible issues with small/huge dates.
      throw new InvalidArgumentException("CalandarView created with invalid year: " . $year);
    }
    $this->month = $month;
    $this->year = $year;
  }

  public function htmlOfMonthList($defaultSelectedMonth=-1) {
    if ($defaultSelectedMonth === -1) {
      $defaultSelectedMonth = $this->month;
    }
    $monthNames = array("January", "February", "March", "April",
                        "May", "June", "July", "August", "September",
                        "October", "November", "December");
    $html = "";
    foreach ($monthNames as $iii=>$month) {
      $monthNumber = $iii + 1;
      $selected = "";
      if ($defaultSelectedMonth === $monthNumber) {
        $selected = 'selected="selected" ';
      }
      $html .= '<option ' . $selected . 'value="' . $monthNumber . '">' . $month . "</option>\n";
    }
    return $html;
  }
  
  public function htmlOfYearList($defaultSelectedYear=-1, $firstYear=1990, $lastYear=2030) {
    if ($firstYear > $lastYear) {
      throw new InvalidArgumentException("htmlOfYearList must have a larger lastYear value then firstYear.");
    }
    if ($defaultSelectedYear === -1) {
      $defaultSelectedYear = $this->year;
    }
    $html = "";
    foreach (range($firstYear, $lastYear) as $year) {
      $selected = "";
      if ($year === $defaultSelectedYear) {
        $selected = 'selected="selected" ';
      }
      $html .= '<option ' . $selected . 'value="' . $year . '">' . $year . "</option>\n";
    }
    return $html;
  }

  public function datesInPreviousMonth() {
    //If the month didn't start on a Monday we need to take a few dates from last month
    $dates = array();   
    $dayOfWeekToStartOn = date("w", strtotime($this->year . "-" . $this->month . "-01 UTC"));
    if ($dayOfWeekToStartOn != 1) {
       $previousMonth = $this->month - 1;
       $previousMonthYear = $this->year;
       if ($previousMonth === 0) {
         $previousMonth = 12;
         $previousMonthYear -= 1;
       }
       $numberOfDaysInPreviousMonth = cal_days_in_month(CAL_GREGORIAN, $previousMonth, $previousMonthYear);
    
       $numberOfDaysNeededFromPreviousMonth = $dayOfWeekToStartOn - 1;
       if ($numberOfDaysNeededFromPreviousMonth === -1) {
         $numberOfDaysNeededFromPreviousMonth = 6;
       }

       //Now we'll add this many dates to the output.
       for ($iii = $numberOfDaysNeededFromPreviousMonth; $iii > 0; $iii--) {
         $dates[] = $numberOfDaysInPreviousMonth - $iii + 1;
       }
    }
    return $dates;
  }

  public function datesInNextMonth() {
    //Get the first few dates of the next month if we don't end on a Sunday.
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
    $dayOfWeekOfLastDay = date("w", strtotime($this->year . "-" . $this->month . "-" . $daysInMonth . " UTC"));
    if ($dayOfWeekOfLastDay != 0) {
      return range(1, 7 - $dayOfWeekOfLastDay);
    } else {
      return array();
    }
  }

  public function datesInCurrentMonth() {
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
    return range(1, $daysInMonth);
  }

  public function htmlOfTable() {
    $html = "";

    $datesFromPreviousMonth = $this->datesInPreviousMonth();
    $datesFromCurrentMonth = $this->datesInCurrentMonth();
    $datesFromNextMonth = $this->datesInNextMonth();
    $dates = array_merge($datesFromPreviousMonth, $datesFromCurrentMonth, $datesFromNextMonth);
    
    {
      $datesOutput = 0;
      for ($row = 0; $row < floor(count($dates)/7); $row++) {
        $html .= "<tr>";
        for ($datesIntoRow = 0; $datesIntoRow < 7; $datesIntoRow++) {
          $class = "calandar-table__cell calandar-table__cell--current-month";
          if ($datesOutput < count($datesFromPreviousMonth)) {
            $class = "calandar-table__cell calandar-table__cell--previous-month";
          } else if ($datesOutput >= count($dates)-count($datesFromNextMonth)) {
            $class = "calandar-table__cell calandar-table__cell--next-month";
          }
          $html .= '<td class="' . $class . '">' . $dates[$row*7 + $datesIntoRow] . "</td>";
          $datesOutput++;
        }
        $html .= "</tr>\n";
      }
    }
    return $html;
  }
}
