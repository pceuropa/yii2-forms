<!--Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net  1.1.0-->
<?php
use yii\helpers\Json;
	pceuropa\forms\FormBuilderAsset::register($this);
?>
<div id="MyForm" class="row">

	<section class="col-md-8">
	
		<div id="widget-form-header" class="pull-right">
			<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
		</div>
		
		<h1><?= Yii::t('builder', 'Form Builder') ?></h1>
	
			<div id="preview-form">
				<div class="manual" ><?= $this->render('_manual'); ?></div>
			</div>
		
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
		
			<div id="form" class="options form-horizontal active-option"><?= $this->render('options/form'); ?></div>
			<div id="input" class="options form-horizontal"><?= $this->render('options/input'); ?></div>
			<div id="textarea" class="options form-horizontal"><?= $this->render('options/textarea'); ?></div>
			<div id="radio" class="options form-horizontal"><?= $this->render('options/multi-field'); ?></div>
			<div id="checkbox" class="options form-horizontal"><?= $this->render('options/multi-field'); ?></div>
			<div id="select" class="options form-horizontal"><?= $this->render('options/select'); ?></div>
			<div id="description" class="options form-horizontal"><?= $this->render('options/description'); ?></div>
			<div id="submit" class="options form-horizontal"><?= $this->render('options/submit'); ?></div>
			<div id="update" class="options form-horizontal">update</div>
			
			<div id="delete" class="options form-horizontal">
                <?= $this->render('options/button/_delete'); ?>
                <?= $this->render('options/button/_back'); ?>
			</div>
			
		</div> <!-- end id.sidebar -->
	</aside>
</div>

<?php

$this->registerCss("
	div.options, .update-buttons, #update-tab, #delete-tab, #select-field, #preview-field, #name-field-empty {display:none}

	#preview-form {min-height: 50px;border:dashed 1px #C8EBFB;margin-bottom:50px}
	#preview-form .row { border-bottom:dashed 1px #C8EBFB; border-left:solid 7px #C8EBFB; margin-top:15px;}
	
	#preview-form.edit-mode div.row > div{opacity: 0.3;}
	#preview-form.edit-mode div.row > div.edit-now {opacity: 1;}
	.ql-align-center {text-align: center}
	
	#preview-form input, #preview-form textarea, #preview-form select, #preview-form radio , #preview-form checkbox{cursor: grab;}
	span#text-bofore-preview-field {margin: 0 0px 10px 0; float:left }
	#preview-field .show {display:block}
	
	div.options { border:solid 1px #ccc; padding:10px;}
	div.options.active-option {display: block}
	asside {height: 100%}
	#sidebar > ul { margin:0 0 0 5px;  }
	#sidebar > ul li { color:#3894B0; box-shadow: none; border: solid 1px #ccc; border-bottom: none; padding: 4px 10px; margin-bottom: -3px;}
	#sidebar > ul li:hover { background-color:#eee}
	#sidebar > ul li#field-tab.active-tab  {display:none}
	#sidebar > ul li.active-tab { background-color: #fff; color:#244BAC;  padding: 6px 25px; margin-bottom:-1px; z-index:2; font-weight:bold; border-color: #ccc; display:inline-block; border-bottom: none;}
	
	#sidebar.update #add-to-form{display:none}
	
	#select-field {font-weight: bold;  width: 130px; margin: -10px 40px 0px 0 ;  padding-left: 10px;  border-bottom:none; height: 40px; box-shadow: none;}
	#select-field .show {display:inline-block}
	.change-item {width: 145px}
	@media screen and (min-width: 1024px){
	  #sidebar { position: fixed;}
	  #preview-field {margin-bottom:200px}
	}
	
	.name-error {color: red}
	.empty {border: solid 1px #D42323 }
	.green {border: solid 1px #399D6E }
	
	.input-item.update div.create-buttons {display:none}
	.input-item.update div.update-buttons {display:block}
	
	.ghost { opacity: 0.2;outline: 0;background: #C8EBFB;}
	.edit-field span { color:#A6E0FB; margin-left: 7px;}
	#editor { max-width: 100%; }
	
	.ql-snow .ql-tooltip {
		z-index: 1000;
	}
	
	.border {border:solid 1px #ccc}
	.add-item {
		color: #fff;
		background-color: #337ab7;
		border-color: #2e6da4;
	}
	
	.glyphicon-pencil { cursor: e-resize;}
	.glyphicon-duplicate { cursor: pointer;}
	.glyphicon-trash { cursor: no-drop;}
	.manual {
		background-color: #FAFAFA;
		color: #ADADAD;
		padding: 10px;
		margin:0;
	}
");


if ($easy_mode){
	$this->registerCss(".expert {display:none}");
}
	$this->registerJs(" var form = new MyFORM.Form(); ", 4);
	$this->registerJs("form.init(".Json::encode($config).");", 4);

if ($test_mode){
	$this->registerJs(" MyFORM.test(form);", 4);
}
	$this->registerJs(" MyFORM.template(form);", 4);	
?>		
