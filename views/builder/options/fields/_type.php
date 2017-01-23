<div class="form-group">
	<label class="col-sm-2 control-label"><?= Yii::t('builder', 'Type') ?></label>
	<div class="col-sm-10">
		<select id="type" class="form-control input-sm data-source">
			<option><?= Yii::t('builder', 'tex') ?>t</option>
			<option><?= Yii::t('builder', 'email') ?></option>
			<option><?= Yii::t('builder', 'password') ?></option>
			<option><?= Yii::t('builder', 'date') ?></option>
			<option><?= Yii::t('builder', 'number') ?></option>
			<option><?= Yii::t('builder', 'url') ?></option>
			<option><?= Yii::t('builder', 'tel') ?></option>
			<option><?= Yii::t('builder', 'color') ?></option>
			<option><?= Yii::t('builder', 'range') ?></option>
		</select>
	</div>
</div>
