<?php
use pceuropa\forms\FormAsset;
use yii\helpers\Json;
FormAsset::register($this);
?>
<div id="preview-form">js forms not work</div>
<?php
	$this->registerJs("var form = new MyFORM.Form(); ", 4);
	$this->registerJs("form.init(".Json::encode($form).");", 4);
?>
