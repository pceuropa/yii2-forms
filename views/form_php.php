<?php
use yii\bootstrap\ActiveForm;
use pceuropa\forms\Form;

$form = ActiveForm::begin();
if (count($form_body) != 0) {
  
	foreach ($form_body as $key => $row) {
		echo ('<div class="row">');

		    foreach ($row as $key => $value) {
				echo  Form::field($form, $model, $value);
		    }
		echo('</div>');
	}
} 


ActiveForm::end();

$this->registerCss("
    .ql-align-center { text-align:center }, 
    .ql-align-right { text-align:right }, 
");
?>
