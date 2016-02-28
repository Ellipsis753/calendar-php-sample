<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="UTF-8">
    <title>Calendar Sample Program</title>
    <!-- Include Twitter Bootstrap Styling -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <!-- Include our main website stylesheet -->
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    <?php
      //Include the main CalandarView class.
      require_once("CalandarView.php");
    
      //Default to current month and year in UTC
      $month = (int)date("n");
      $year = (int)date("Y");
  
      //If the user has chosen a month we'll use that instead.
      if (isset($_GET["month"]) && isset($_GET["year"])) {
        $month = (int)$_GET["month"];
        $year = (int)$_GET["year"];
        if ($year < 1990 || $year > 2030 || $month < 1 || $month > 12) {
          //Invalid date given. Default to current.
          $month = (int)date("n");
          $year = (int)date("Y");
        }
      }

      $calandar = new CalandarView($month, $year);
    ?>
  
    <form method="get">
      Month: 
      <select name="month">
        <?php echo $calandar->htmlOfMonthList(); ?>
      </select>
    
      Year: 
      <select name="year">
        <?php echo $calandar->htmlOfYearList(); ?>
      </select>
  
      <input type="submit" value="Submit">
    </form>
  
    <?php
      //Output the next and previous buttons
      $previousMonth = $month - 1;
      $previousMonthYear = $year;
      if ($previousMonth === 0) {
        $previousMonth = 12;
        $previousMonthYear -= 1;
      }
      $nextMonth = $month + 1;
      $nextMonthYear = $year;
      if ($nextMonth === 13) {
        $nextMonth = 1;
        $nextMonthYear += 1;
      }
      echo '<a class="link-button" href="?month=' . $previousMonth . "&year=" . $previousMonthYear . '"> &#9664; </a> ';
      echo '<a class="link-button" href="?month=' . $nextMonth . "&year=" . $nextMonthYear . '"> &#9654; </a>';
    ?>
  
    <table class="calandar-table">
      <tr>
        <th class="calandar-table__cell">MON</th>
        <th class="calandar-table__cell">TUE</th>
        <th class="calandar-table__cell">WED</th>
        <th class="calandar-table__cell">THU</th>
        <th class="calandar-table__cell">FRI</th>
        <th class="calandar-table__cell">SAT</th>
        <th class="calandar-table__cell">SUN</th>
      </tr>
      <?php echo $calandar->htmlOfTable(); ?>
    </table>    
  </body>
</html>
