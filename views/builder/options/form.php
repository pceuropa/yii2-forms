<!--Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net -->
<div class="form-group">
	<label class="col-sm-3 control-label"><?= Yii::t('builder', 'View') ?></label>
	<div class="col-sm-9">
		<select id="view-mode" class="form-control input-sm">
			<option value="html" ><?= Yii::t('builder', 'HTML') ?></option>
			<option value="text"><?= Yii::t('builder', 'Text') ?></option>
			<option value="json" ><?= Yii::t('builder', 'Json') ?></option>
			<option value="yii2"><?= Yii::t('builder', 'Yii2') ?></option>
		</select>
	</div>
</div>

	<div class="form-group">
		<label class="col-sm-3 control-label"><?= Yii::t('builder', 'Title') ?></label>
		<div class="col-sm-9">
		  <input id="title" type="text" class="form-control input-sm" >
		</div>
	</div>

	<div class="form-group expert">
		<label class="col-sm-3 control-label"><?= Yii::t('builder', 'Method') ?></label>
		<div class="col-sm-9">
			<select id="method" class="form-control input-sm">
				<option value="post" >POST</option>
				<option value="get">GET</option>
			</select>
		</div>
	</div>

	<div class="form-group expert">
		<label class="col-sm-3 control-label"><?= Yii::t('builder', 'Action') ?></label>
		<div class="col-sm-9">
		  <input id="action" type="text" class="form-control input-sm" >
		</div>
	</div>
	<div class="widgets"></div>
	<?php
		require('fields/_id.php');
		require('fields/_class.php');
		require('buttons/_save-form.php');
	?>
