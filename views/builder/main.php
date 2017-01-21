<!--Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net -->
<?php
	pceuropa\forms\FormBuilderAsset::register($this);
?>
<div id="MyForm" class="row">

	<section class="col-md-8">
		<h1>Form Builder</h1>
		<div id="preview-form"></div>
		<div id="preview-field"></div>
		<div id="errors">
			<div id="name-field-empty" class="alert alert-info" role="alert">Field name is empty, plz write entything.</div>
		</div>
	</section>
	

	<asside class="col-md-4">
		<div id="sidebar" class="sidebar-nav-fixed affix">
			
			<select id="select-field" class="pull-right form-control input-sm">
				<option value="input">Input</option>
				<option value="textarea">TextArea</option>
				<option value="radio">Radio</option>
				<option value="checkbox">Checkbox</option>
				<option value="select">Select</option>
				<option value="description">Description</option>
				<option value="submit">Submit Button</option>
			</select>
		
			<ul id="tabs-options" class="list-inline">
				<li id="form-tab" class="btn active-tab">Form</li>
				<li id="field-tab" class="btn">Field</li>
				<li id="update-tab" class="btn">Update</li>
				<li id="delete-tab" class="btn">Delete</li>
			</ul>
			
		
			<div id="options-form" class="options form-horizontal active-option"><?= $this->render('options/form'); ?></div>
			
			<div id="input" class="options form-horizontal"><?= $this->render('options/input'); ?></div>
			<div id="textarea" class="options form-horizontal"><?= $this->render('options/textarea'); ?></div>
			<div id="radio" class="options form-horizontal"><?= $this->render('options/multi-field'); ?></div>
			<div id="checkbox" class="options form-horizontal"><?= $this->render('options/multi-field'); ?></div>
			<div id="select" class="options form-horizontal"><?= $this->render('options/select'); ?></div>
			<div id="description" class="options form-horizontal"><?= $this->render('options/description'); ?></div>
			<div id="submit" class="options form-horizontal"><?= $this->render('options/submit'); ?></div>
			
			<div id="update" class="options form-horizontal">update</div>
			<div id="delete" class="options form-horizontal">
				
                <?= $this->render('options/buttons/_delete'); ?>
                <?= $this->render('options/buttons/_back'); ?>
			</div>
			
			

		</div> <!-- end id.sidebar -->
	</aside>
</div>

<?php


$this->registerCss("
	div.options, .update-buttons, #update-tab, #delete-tab, #select-field, #preview-field, #name-field-empty {display:none}

	#preview-form {min-height: 50px;border:dashed 1px #C8EBFB;margin-bottom:50px}
	#preview-form .row { border-bottom:dashed 1px #C8EBFB; border-left:solid 7px #C8EBFB; margin-top:15px;}
	#preview-form input, #preview-form textarea, #preview-form select, #preview-form radio , #preview-form checkbox{cursor: grab;}
	
	#preview-field {margin-bottom:200px}
	#preview-field .show {display:block}
	

	#sidebar > ul 	 { margin:0 0 0 5px;  }
	#sidebar > ul li { color:#8C8C95;}
	#sidebar > ul li#btn-update {color: #DC932C;}
	#sidebar > ul li#btn-delete {color: #d43f3a;}
	#sidebar > ul li.active-tab { background-color: #fff; color:#244BAC; margin-bottom:-4px; z-index:2; font-weight:bold; border-color: #ccc; display:inline-block; border-bottom: none;}
	
	.name-error {color: red}
	.empty {border: solid 1px #D42323 }
	div.options {border-top:solid 1px #ccc; border-left:solid 1px #ccc; padding:10px;}
	div.options.active-option {display: block}
	
	#select-field {width: 130px; margin: 0 50px -10px 0 }
	#select-field .show {display:inline-block}
	
	#items.update div.create-buttons {display:none}
	#items.update div.update-buttons {display:block}
	
	.ghost { opacity: 0.2;outline: 0;background: #C8EBFB;}
	.edit-field span { color:#A6E0FB; margin-left: 7px;}
	
	.border {border:solid 1px #ccc}
	.add-item {
		color: #fff;
		background-color: #337ab7;
		border-color: #2e6da4;
	}
	
	.glyphicon-pencil { cursor: e-resize;}
	.glyphicon-duplicate { cursor: pointer;}
	.glyphicon-trash { cursor: no-drop;}

");

if (false){
//	$this->registerJsFile("panelx/js/forms/forms.min.js", ['position' => 3, 'depends' => 'yii\web\YiiAsset']);
	$this->registerJsFile("panelx/js/forms/helpers.js", ['position' => 3, 'depends' => 'yii\web\YiiAsset']);
	$this->registerJsFile("panelx/js/forms/form.js", ['position' => 3, 'depends' => 'yii\web\YiiAsset']);
	$this->registerJsFile("panelx/js/forms/fields.js", ['position' => 3, 'depends' => 'yii\web\YiiAsset']);
	$this->registerJsFile("panelx/js/forms/events.js", ['position' => 3, 'depends' => 'yii\web\YiiAsset']);
	$this->registerJsFile("panelx/js/forms/template.js", ['position' => 3, 'depends' => 'yii\web\YiiAsset']);
}






if ($easy_mode){
	$this->registerCss(".expert {display:none}");
}

$this->registerJs("
	var form = new MyFORM.Form();
	
", 4);

if (!$update){
	$this->registerJs("form.init();", 4);
} else {
	$this->registerJs("form.init({get: true, save: true, autosave: true,create_url: document.URL, 
			update_url: document.URL});", 4);
}


		
	
	

if ($test_mode){
	$this->registerJsFile("panelx/js/forms/test.js", ['position' => 3, 'depends' => 'yii\web\YiiAsset']);
	$this->registerJs("
	
	form.generate(MyFORM.test);
	form.deleteField(0, 1)
	form.body = [];
	form.generate(MyFORM.test)
	form.add(MyFORM.test.body[0][0]);
	form.add(MyFORM.test.body[2][1]);
", 4);

}

$this->registerJs(" MyFORM.template(form);", 4);	
	


?>		
