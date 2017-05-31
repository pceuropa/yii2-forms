<div class="row form-group-sm">
	<label class="col-sm-3 control-label"><?= Yii::t('builder', 'View') ?></label>
	<div class="col-sm-9">
		<select id="view-mode" class="form-control">
			<option value="html" >HTML</option>
			<option value="text"><?= Yii::t('builder', 'Text') ?></option>
			<option value="json" >Json</option>
			<option value="yii2">Yii2</option>
		</select>
	</div>
</div>

<span>
	<div class="row form-group-sm generator_mode">
		<label class="col-sm-3 control-label"><?= Yii::t('builder', 'Title') ?> *</label>
		<div class="col-sm-9">
		  <input id="title" type="text" class="form-control" >
		</div>
	</div>

	<div class="row form-group-sm generator_mode">
		<label class="col-sm-3 control-label"><?= Yii::t('builder', 'URL') ?> *</label>
		<div class="col-sm-9">
		  <input id="url" type="text" class="form-control" >
		</div>
	</div>

	<div class="row form-group-sm generator_mode">
		<label class="col-sm-3 control-label"><?= Yii::t('builder', 'Max Entries') ?></label>
		<div class="col-sm-9">
		  <input id="maximum" type="number" class="form-control" >
		</div>
	</div>

	<div class="row form-group-sm expert generator_mode">
		<label class="col-sm-3 control-label"><?= Yii::t('builder', 'Start') ?></label>
		<div class="col-sm-9">
		  <input id="date_start" type="date" class="form-control" placeholder="yyyy-mm-dd">
		</div>
	</div>

	<div class="row form-group-sm generator_mode">
		<label class="col-sm-3 control-label"><?= Yii::t('builder', 'End') ?></label>
		<div class="col-sm-9">
		  <input id="date_end" type="date" class="form-control" placeholder="yyyy-mm-dd">
		</div>
	</div>

	<div class="row form-group-sm expert">
		<label class="col-sm-3 control-label"><?= Yii::t('builder', 'Method') ?></label>
		<div class="col-sm-9">
			<select id="method" class="form-control">
				<option value="post" >POST</option>
				<option value="get">GET</option>
			</select>
		</div>
	</div>

	<div class="row form-group-sm expert">
		<label class="col-sm-3 control-label"><?= Yii::t('builder', 'Action') ?></label>
		<div class="col-sm-9">
		  <input id="action" type="text" class="form-control" >
		</div>
	</div>

	<?php require('field/_id.php'); ?>
		
 <div class="row form-group-sm expert">
    <label class="col-sm-3 control-label"><?= Yii::t('builder', 'Class') ?></label>
    <div class="col-sm-9">
      <input id="class" type="text" class="form-control data-source" >
	</div>
</div>

	<div id="widget-form-options"></div>

	<?php if (!$hide_button_form_save) {
	 require('button/_save-form.php');
    }?> 
</span>
