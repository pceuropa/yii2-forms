<?php
use yii\helpers\Json;
	pceuropa\forms\FormBuilderAsset::register($this);
?>
<div id="MyForm" class="row">

	<section class="col-md-8">
		<div id="widget-form-header" class="pull-right">
			<span class="glyphicon glyphicon-info-sign hidden" aria-hidden="true"></span>
		</div>
		
			<div id="preview-form">
				<div class="manual" ></div>
			</div>
			<p id="end-form" class="text-uppercase text-center">-- <?= Yii::t('builder', 'Form end') ?> --</p>
			
			<span id='text-bofore-preview-field'><?= Yii::t('builder', 'Preview field')  ?>:</span>
			<div id="preview-field"></div>
		
			<div id="errors">
				<div id="name-field-empty" class="alert alert-info" role="alert"></div>
			</div>
	</section>
	
	<asside class="col-md-4">
		<div id="sidebar">
			<select id="select-field" class="pull-right form-control input-sm">
				<option value="input"><?= Yii::t('builder', 'Input') ?></option>
				<option value="textarea"><?= Yii::t('builder', 'TextArea') ?></option>
				<option value="radio"><?= Yii::t('builder', 'Radio') ?></option>
				<option value="checkbox"><?= Yii::t('builder', 'Checkbox') ?></option>
				<option value="select"><?= Yii::t('builder', 'Select') ?></option>
				<option value="description"><?= Yii::t('builder', 'Description') ?></option>
				<option value="submit"><?= Yii::t('builder', 'Submit Button') ?></option>
			</select>
		
			<ul id="tabs" class="list-inline">
				<li id="form-tab" class="btn active-tab"><?= Yii::t('builder', 'Form') ?></li>
				<li id="field-tab" class="btn"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <?= Yii::t('builder', 'Field') ?></li>
				<li id="update-tab" class="btn"><?= Yii::t('builder', 'Update') ?></li>
				<li id="delete-tab" class="btn"><?= Yii::t('builder', 'Delete') ?></li>
			</ul>
		
	 		<div id="form" class="options form-horizontal active-option"><?= $this->render('options/form', ['hide_button_form_save' => $hide_button_form_save]); ?></div>
			<div id="input" class="options form-horizontal"><?= $this->render('options/input'); ?></div>
			<div id="textarea" class="options form-horizontal"><?= $this->render('options/textarea'); ?></div>
			<div id="radio" class="options form-horizontal"><?= $this->render('options/multi-field'); ?></div>
			<div id="checkbox" class="options form-horizontal"><?= $this->render('options/multi-field'); ?></div>
			<div id="select" class="options form-horizontal"><?= $this->render('options/select'); ?></div>
			<div id="description" class="options form-horizontal"><?= $this->render('options/description'); ?></div>
			<div id="submit" class="options form-horizontal"><?= $this->render('options/submit'); ?></div>
			
			<div id="delete" class="options form-horizontal">
                <?= $this->render('options/button/_back'); ?> - 
                <?= $this->render('options/button/_delete'); ?>
			</div>
			
		</div> <!-- end id.sidebar -->
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
