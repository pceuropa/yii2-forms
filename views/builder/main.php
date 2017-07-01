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
				<div class="manual" ><?= $this->render('_manual'); ?></div>
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

$this->registerCss("
	#MyForm h1.header {color: #C8EBFB}
	.options, .update-buttons, #update-tab, #delete-tab, #select-field, #preview-field, #name-field-empty {display:none}

	#preview-form {min-height: 50px; border:dashed 1px #C8EBFB; border-top: solid 3px #C8EBFB;}
	#preview-form .row { border-bottom:dashed 1px #C8EBFB; border-left:solid 7px #C8EBFB; margin-top:15px;}
	
	#preview-form input, #preview-form textarea, #preview-form select, #preview-form radio, #preview-form checkbox{cursor: grab;}
    #preview-form .row .update {
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        -khtml-border-radius: 5px;
        border-radius: 5px;
        behavior: url(border-radius.htc);
    }

	#end-form {height: 25px;background-color: #C8EBFB; color:#6CBDE3; margin:0 0 50px 0; }
	#text-bofore-preview-field {margin: 0 0px 10px 0; float:left }
	
	asside {height: 100%;}
	.options { border:solid 1px #ccc; padding:5px;}
	#sidebar > ul { margin:0 0 0 5px;  }
	#sidebar > ul li { color:#3894B0; box-shadow: none; border: solid 1px #ccc; border-bottom: none; padding: 4px 10px; margin-bottom: -3px;}
	#sidebar > ul li:hover { background-color:#eee}
	#sidebar > ul li#field-tab.active-tab  {display:none}
	#sidebar > ul li.active-tab { 
		background-color: #fff; color:#244BAC; padding: 6px 25px; margin-bottom:-1px; z-index:2; font-weight:bold; border-color: #ccc; display:inline-block; border-bottom: none;
	}
	
    #sidebar > ul li#update-tab {  background-color:#e5f6e5}
    #sidebar > ul li#delete-tab {  background-color:#FFF4F4}
	#sidebar.update #add-to-form{display:none}
	#sidebar .well {
		padding: 5px;
		margin-bottom: 10px;
		background-color: #ECF9FF;
		border: 1px solid #e3e3e3;
		margin-top: 5px;
	}

	#sidebar.update, #preview-form .row .update-field {
        border: solid 1px #B5DAB5;
        background-color: #e5f6e5;
    }

	#delete, #preview-form .row .delete-field {
         border: solid 1px #F7B68F;
         background-color: #FFF4F4; 
    }

	.options.active-option {display: block}
	#select-field {
		font-weight: bold;  width: 130px; margin: -10px 40px 0px 0 ;  padding-left: 10px;  border-bottom:none; height: 40px; box-shadow: none;
	}
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
	
	#MyForm .ghost { opacity: 0.2;outline: 0;background: #C8EBFB;}
	#MyForm .edit-field span { color:#A6E0FB; margin-left: 7px;}
	
	#MyForm .ql-snow .ql-tooltip {z-index: 1000;}
	#MyForm .ql-align-center {text-align: center}
    #MyForm .ql-align-right { text-align:right }
	#MyForm .border {border:solid 1cx #ccc}
	
	.glyphicon-pencil { cursor: e-resize;}
	.glyphicon-duplicate { cursor: pointer;}
	.glyphicon-trash { cursor: no-drop;}
	
	#MyForm .btn-danger {margin-left:20px}
	#MyForm #save-form {margin-top:5px}
	#MyForm .manual {
		background-color: #FAFAFA;
		color: #ADADAD;
		padding: 10px;
		margin:0;
	}
");

    if ($easy_mode){
        $this->registerCss(".expert {display:none}"); // hide many options
    }

    if ($generator_mode){
        $this->registerCss(".generator_mode {display:none}"); // hide many options
    }
        $this->registerJs("var form = new MyFORM.Form(); ", 4); // init form.js

    if ($email_response){
      // add module Email send after submit form (work if in forms is field with name email)
      // form.modules are initalize each time when form is render
        $this->registerJs("console.log(form);form.modules.response = MyFORM.response(form)", 4);
    }
    $this->registerJs("
        form.init(".Json::encode($jsConfig).");
        form.controller();
    ", 4);

    if ($test_mode){
        $this->registerJs(" MyFORM.test(form);", 4); // init test form on begining
    }
        $this->registerJs(" MyFORM.examples(form);", 4);	// add module with examples of formsj
?>		
