<?php
use pceuropa\forms\bootstrap\ActiveForm;
pceuropa\forms\FormPHPAsset::register($this);

$form = ActiveForm::begin([
    'options' => [
      'class' => 'pceuropa-form',
    ]
]);
$date = (new \DateTime())->format('Y-m-d H:i:s');
    echo('<input name="_fp" type="hidden" value="">');
    echo("<input name='form_created' type='hidden' value='$date'>");

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
