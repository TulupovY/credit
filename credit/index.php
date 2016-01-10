<?php require 'options.php';?><!DOCTYPE HTML>
<html>
<head>
<title>Кредитный калькулятор</title>
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="script.js"></script>
</head>

<body>
<form id="credit">
<div class="text"><label>Сумма кредита</label> <input type="text" name="amount" id="amount" value="300000" /></div>
<div class="text"><label>Срок кредита (мес.)</label><input type="text" name="term" id="term" value="36" /></div>
<div class="text"><label>Процентная ставка</label><input type="text" name="rate" id="rate" value="15.5" /></div>
<div class="select"><label>Начало выплат</label>
<select name="startmonth" id="startmonth">
<?php
    $current_month = date("n");
    foreach($month_array as $key => $value) { ?>
    <option value="<?php echo $key+1; ?>" <?php if($current_month == $key+1) { ?>selected="selected"<?php } ?>><?php echo $value; ?></option>
<?php } ?>
</select>
<select name="startyear" id="startyear">
<?php
    $current_year = date("Y");
    for($i = $current_year - 10; $i <= $current_year + 10; $i++ ) { ?>
    <option value="<?php echo $i; ?>" <?php if($current_year == $i) { ?>selected="selected"<?php } ?>><?php echo $i; ?></option>
<?php } ?>
</select>
</div>
<div class="submit"><button type="submit">Рассчитать</button></div>
</form>

<p><strong>Ежемесячный платеж:</strong> <span id="payment"></span></p>
<p><strong>Переплата:</strong> <span id="overpay"></span></p>
<div id="schedule"></div>

</body>
</html>