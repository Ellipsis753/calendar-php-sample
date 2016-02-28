<?php

class CalandarViewTest extends PHPUnit_Framework_TestCase {

  /**
   * @expectedException InvalidArgumentException
   */
  public function testInvalidDateRejected() {
    $object = new CalandarView(0, 2000);
  }

  /**
   * @expectedException InvalidArgumentException
   */
  public function testInvalidDateRejected2() {
    $object = new CalandarView(13, 2000);
  }

  public function testValidDatesAccepted() {
    //Testing that no exceptions are thrown when valid dates used
    $object = new CalandarView(1, 2000);
    $object = new CalandarView(4, 2008);
    $object = new CalandarView(9, 1997);
    $object = new CalandarView(12, 1980);
    $object = new CalandarView(7, 2035);
  }

  public function testListOfMonthsHas12Months() {
    $object = new CalandarView(2, 2000);
    $html = $object->htmlOfMonthList();
    $count = substr_count($html, '<option');
    $this->assertEquals(12, $count);
  }

  /**
   * @expectedException InvalidArgumentException
   */
  public function testHtmlOfYearListRejectsInvalidArguments() {
    $object = new CalandarView(1, 2000);
    $object->htmlOfYearList(1, 1990, 1989);
  }

  public function testHtmlOfYearListAcceptsValidArguments() {
    $object = new CalandarView(1, 2000);
    $object->htmlOfYearList(1, 1990, 1990);
  }

  public function testMonthDatesReturned() {
    $object = new CalandarView(2, 2000);

    $previousMonth = $object->datesInPreviousMonth();
    $this->assertEquals($previousMonth, array(31));

    $nextMonth = $object->datesInNextMonth();
    $this->assertEquals($nextMonth, array(1, 2, 3, 4, 5));

    $currentMonth = $object->datesInCurrentMonth();
    $this->assertEquals($currentMonth, array(1, 2, 3, 4, 5, 6,
        7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21,
        22, 23, 24, 25, 26, 27, 28, 29));
  }

  public function testMonthDatesReturned2() {
    $object = new CalandarView(2, 2001);

    $previousMonth = $object->datesInPreviousMonth();
    $this->assertEquals($previousMonth, array(29, 30, 31));

    $nextMonth = $object->datesInNextMonth();
    $this->assertEquals($nextMonth, array(1, 2, 3, 4));

    $currentMonth = $object->datesInCurrentMonth();
    $this->assertEquals($currentMonth, array(1, 2, 3, 4, 5, 6,
        7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21,
        22, 23, 24, 25, 26, 27, 28));
  }

  public function testMonthDatesReturned3() {
    $object = new CalandarView(1, 1990);

    $previousMonth = $object->datesInPreviousMonth();
    $this->assertEquals($previousMonth, array());

    $nextMonth = $object->datesInNextMonth();
    $this->assertEquals($nextMonth, array(1, 2, 3, 4));

    $currentMonth = $object->datesInCurrentMonth();
    $this->assertEquals($currentMonth, array(1, 2, 3, 4, 5, 6,
        7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21,
        22, 23, 24, 25, 26, 27, 28, 29, 30, 31));
  }

  public function testMonthDatesReturned4() {
    $object = new CalandarView(1, 2016);

    $previousMonth = $object->datesInPreviousMonth();
    $this->assertEquals($previousMonth, array(28, 29, 30, 31));

    $nextMonth = $object->datesInNextMonth();
    $this->assertEquals($nextMonth, array());

    $currentMonth = $object->datesInCurrentMonth();
    $this->assertEquals($currentMonth, array(1, 2, 3, 4, 5, 6,
        7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21,
        22, 23, 24, 25, 26, 27, 28, 29, 30, 31));
  }
}
