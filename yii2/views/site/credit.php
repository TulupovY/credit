<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'credit',
    'options' => [
				'class' => 'form-horizontal'
				],
]);
//var_dump($credit_date);
 ?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Параметры кредита</h3>
  </div>
  <div class="panel-body">


 <div class="row">
 	<div class="col-lg-1">
 	</div>

            <div class="col-lg-2">
            	<?= $form->field($model, 'amount',['inputOptions' => ['value' => $post_date['amount'], ], ])->label('Сумма кредита') ?>
			 	<?= $form->field($model, 'term',['inputOptions' => ['value' => $post_date['term'], ], ])->label('Срок кредита (мес.)') ?>

                    <div class="form-group">
                        <?= Html::submitButton('Расчитать', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>

			 </div>
			 <div class="col-lg-1">
			 </div>
			 <div class="col-lg-2">
			 	<?= $form->field($model, 'rate',['inputOptions' => ['value' => $post_date['rate'], ], ])->label('Процентная ставка') ?>
			 	
			 	<label>Начало выплат</label>
			 	<select  class="form-control" name="startmonth" id="startmonth">
<?php
    $current_month = date("n");
    if ($post_date['startmonth']!='')
    	$current_month=$post_date['startmonth'];

    foreach($model->month_array as $key => $value) { ?>
    <option value="<?php echo $key+1; ?>" <?php if($current_month == $key+1) { ?>selected="selected"<?php } ?>><?php echo $value; ?></option>
<?php } ?>
</select>
<select name="startyear" class="form-control" id="startyear">
<?php
    $current_year = date("Y");
        if ($post_date['startyear']!='')
    	$current_year=$post_date['startyear'];
    for($i = $current_year - 10; $i <= $current_year + 10; $i++ ) { ?>
    <option value="<?php echo $i; ?>" <?php if($current_year == $i) { ?>selected="selected"<?php } ?>><?php echo $i; ?></option>
<?php } ?>
</select>

			 	
			 </div>

</div>


<?php ActiveForm::end() ?>
 </div>
</div>

<?php
if ($credit_date!='') {
	echo "
	<p><strong>Ежемесячный платеж:</strong> <span >".$credit_date['overpay']."</span></p>
	<p><strong>Переплата:</strong> <span >".$credit_date['payment']."</span></p>";
	echo $credit_date['schedule'];
}

?>


