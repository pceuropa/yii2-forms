<?php
use yii\widgets\ActiveForm;
use pceuropa\forms\Form;

$form = ActiveForm::begin();
	//echo('<pre>'); print_r($array);die();
	foreach ($array as $key => $row) {
		echo ('<div class="row">');

		    foreach ($row as $key => $value) {
				echo count($array) != 0 ? Form::field($form, $model, $value) : '';
		    }
		echo('</div>');
	}

ActiveForm::end();
?>
