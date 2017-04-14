<div class="row form-group-sm">
	<label class="col-sm-3 control-label"><?= Yii::t('builder', 'View') ?></label>
	<div class="col-sm-9">
		<select id="view-mode" class="form-control">
			<option value="html" ><?= Yii::t('builder', 'HTML') ?></option>
			<option value="text"><?= Yii::t('builder', 'Text') ?></option>
			<option value="json" ><?= Yii::t('builder', 'Json') ?></option>
			<option value="yii2"><?= Yii::t('builder', 'Yii2') ?></option>
		</select>
	</div>
</div>

<span>
	<div class="row form-group-sm">
		<label class="col-sm-3 control-label"><?= Yii::t('builder', 'Title') ?></label>
		<div class="col-sm-9">
		  <input id="title" type="text" class="form-control" >
		</div>
	</div>

	<div class="row form-group-sm">
		<label class="col-sm-3 control-label"><?= Yii::t('builder', 'URL') ?></label>
		<div class="col-sm-9">
		  <input id="url" type="text" class="form-control" >
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
		<?php
			require('field/_id.php');
			require('field/_class.php');
		?>
		
	<div id="widget-form-options"></div>
	<?php require('button/_save-form.php');?>
</span>
