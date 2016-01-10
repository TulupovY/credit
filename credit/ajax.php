<?php
require 'functions.php' ;

$term = $_POST['term'];
$rate = $_POST['rate'];
$amount = $_POST['amount'];
$startmonth = $_POST['startmonth'];
$startyear = $_POST['startyear'];

$credit = credit($term, $rate, $amount, $startmonth, $startyear);

echo json_encode($credit);