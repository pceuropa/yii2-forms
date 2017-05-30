<?php
use yii\bootstrap\ActiveForm;
use pceuropa\forms\Form;

$form = ActiveForm::begin();
	foreach ($form_body as $key => $row) {
		echo ('<div class="row">');

		    foreach ($row as $key => $value) {
				echo count($form_body) != 0 ? Form::field($form, $model, $value) : '';
		    }
		echo('</div>');
	}

ActiveForm::end();

$this->registerCss("
    .ql-align-center { text-align:center }, 
    .ql-align-right { text-align:right }, 
");
?>
