<?php

namespace Lib\System;

/**
 * A wrapper for the PHP DateTime class with a simplified interface.
 */
final class DateTime extends Object
{
  private static $daysInWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday',
                                'Thursday', 'Friday', 'Saturday'];
  
  private $timeStamp;
  private $seconds;
  private $minutes;
  private $hours;
  private $dayOfWeek;
  private $dayOfMonth;
  private $month;
  private $year;
  
}