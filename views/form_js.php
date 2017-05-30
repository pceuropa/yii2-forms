<div id="preview-form">js forms not work</div>
	
<?php
pceuropa\forms\FormAsset::register($this);
use yii\helpers\Json;

	$this->registerJs("var form = new MyFORM.Form(); ", 4);
	$this->registerJs("form.init(".Json::encode($form).");", 4);

?>
