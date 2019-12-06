<?php

use yii\helpers\Html;
use yii\helpers\Url;
use pceuropa\forms\Form;

$this->title = Yii::t('app', 'Form'). ': '. $form->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Forms') , 'url' => ['user']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Form::widget([
	'body' => $form->body,
	'typeRender' => 'php'
]);

$this->registerJs("
      Fingerprint2.get(function(c) {
        var fp = Fingerprint2.x64hash128(c.map(function (pair) { return pair.value }).join(), 31);
        $('input#fp').val(fp);
      })
", 4);
?>
