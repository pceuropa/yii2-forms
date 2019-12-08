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
  var selector = $('input[name=\"_fp\"]');
  if (selector.length) {
      Fingerprint2.get(function(c) {
        selector.val(Fingerprint2.x64hash128(c.map(function (pair) { return pair.value }).join(), 31));
      })
  }", 4);
?>
