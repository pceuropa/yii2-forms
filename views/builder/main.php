<?php
use yii\helpers\Json;
pceuropa\forms\FormBuilderAsset::register($this);
?>
<div id="MyForm" class="row">

	<section class="col-md-8">
        <h1 class="header"><?= Yii::t('builder', 'Preview form') ?>:</h1>
		<div id="widget-form-header" class="pull-right">
			<span class="glyphicon glyphicon-info-sign hidden" aria-hidden="true"></span>
		</div>
		
        <div id="preview-form"></div>
        
        <span id='text-bofore-preview-field'><?= Yii::t('builder', 'Preview field')  ?>:</span>
        <div id="preview-field"></div>
    
        <div id="errors">
            <div id="name-field-empty" class="alert alert-info" role="alert"></div>
        </div>

	</section>

	<aside class="col-md-4">
        <div id="sidebar">
        <?= $this->render('_sidebar', ['hide_button_form_save' => $hide_button_form_save] ); ?>
        </div>
    </aside>
</div>

<?php

if ($easy_mode){
	$this->registerCss(".expert {display:none}"); // hide many options
}

if ($generator_mode){
	$this->registerCss(".generator_mode {display:none}"); // hide many options
}
	$this->registerJs("var form = new MyFORM.Form(); ", 4); // init form.js

if ($send_email){
  // add module Email send after submit form (work if in forms is field with attribute name 'email')
  // form.modules are initalized each time the form is rendered
	$this->registerJs("form.modules.response = MyFORM.response()", 4);
}
$this->registerJs("
  form.init(".Json::encode($jsConfig).");
  form.controller();
", 4);

if ($test_mode){
	$this->registerJs(" MyFORM.test(form);", 4); // init test form on begining
}

if (!$easy_mode){
	$this->registerJs(" MyFORM.examples(form);", 4);	// add module with examples of formsj
}
?>		
