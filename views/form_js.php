<div id="preview-form">js forms not work</div>
	
<?php
pceuropa\forms\FormAsset::register($this);

	//$this->registerJsFile('/js/forms/creator.js', ['position' => 3, 'depends' => 'yii\web\YiiAsset']);
	//$this->registerJsFile('/js/forms/fields.js', ['position' => 3, 'depends' => 'yii\web\YiiAsset']);
	$this->registerJs("
		var form = new MyFORM.Form(), fields = ".$form_body.";
			form.generate(fields);
		", 3);
?>
