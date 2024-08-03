<?php

error_reporting(1);
session_start();
ob_start();
define("ROOTFOLDER", "Shipment/");
//define("ROOTFOLDER", "/");
date_default_timezone_set('Asia/Kolkata');
include './classes/DBOperation.php';
include './classes/DBconfig.php';

function DB_curr_date_time() {
    $dt_timeSQL = "SELECT NOW() CURR_DATE_TIME FROM DUAL";
    $date_time_val = json_encode(connect_db()->fetchData($dt_timeSQL));
    return $date_time_val;
}

function site_url() {

    $link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/" . ROOTFOLDER;

    return $link;
}

function number_words($number) {
   $no = round($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'one', '2' => 'two',
    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
    '7' => 'seven', '8' => 'eight', '9' => 'nine',
    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
    '13' => 'thirteen', '14' => 'fourteen',
    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
    '60' => 'sixty', '70' => 'seventy',
    '80' => 'eighty', '90' => 'ninety');
   $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "" . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';
  $conv="Rupees  " .  $result. " and ". $points. " paise" ;
  return $conv;
}


include './global_functions.php';
ob_flush();
?>

