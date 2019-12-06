<?php
use pceuropa\forms\bootstrap\ActiveForm;

use pceuropa\forms\FormPHPAsset;
FormPHPAsset::register($this);

$form = ActiveForm::begin([
    'options' => [
      'class' => 'pceuropa-form',
    ]
]);
echo('<input id="fp" type="hidden" value="">');

if (count($form_body) != 0) {
	foreach($form_body as $key => $row) {
		echo('<div class="row">');

		    foreach ($row as $key => $value) {
                echo $form->dynamicField($model, $value);
		    }
		echo('</div>');
	}
} 


ActiveForm::end();

$this->registerCss("
    .ql-align-center { text-align:center } 
    .ql-align-right { text-align:right }
");
?>
