<?php
/**	SMG Date and Time pre-processor
*
*/
class Clock
{
	private $datetime;
	private $timezone;
	
	public function __construct($date = "")
	{
		$this->timezone = new DateTimeZone('Africa/Johannesburg');
		if (empty($date))
			$this->datetime = new DateTime("now",$this->timezone);
		else
			$this->datetime = new DateTime($date);
	}
	
	public function getDateBasic()
	{
		return $this->datetime->format(DATE_ATOM);
	}
	
	public function getDateAdvanced()
	{
		//object's date and time
		$day = $this->datetime->format("j");
		$month = $this->datetime->format("n");
		$year = $this->datetime->format("Y");
		$minute  = $this->datetime->format("i");
		$hour = $this->datetime->format("G");
		//current date and time
		$xdate = new DateTime("now", $this->timezone);
		$xday =  $xdate->format("j");
		$xmonth = $xdate->format("n");
		$xyear = $xdate->format("Y");
		$xminute  = $xdate->format("i");
		$xhour = $xdate->format("G");
		
		if ($xyear - $year > 0)
			return "over a year ago";
		else if ($xmonth - $month < 12 && $xmonth - $month > 1)
			return $xmonth - $month . " months ago";
		else if ($xmonth - $month == 1)
			return "a month ago";
		else if ($xmonth - $month < 1 && $xday - $day > 1)
			return $xday - $day . " days ago";
		else if ($xday - $day == 1)
			return "a day ago";
		else if ($xday - $day < 1 && $xhour - $hour > 1)
			return $xhour - $hour . " hours ago";
		else if ($xhour - $hour == 1)
			return "an hour ago";
		else if ($xhour - $hour < 1 && $xminute - $minute > 1)
			return $xminute - $minute . " minutes ago";
		else if ($xminute - $minute == 1)
			return "a minute ago";
		else if ($xminute - $minute == 0)
			return "just now";
	}
	
	
	
}

?>