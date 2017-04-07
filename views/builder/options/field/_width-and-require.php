<div class="row form-group-sm">
	<label class="col-sm-3 control-label"><?= Yii::t('builder', 'Width') ?></label>
		<div class="col-sm-4">
		<select id="width" class="form-control data-source">
				<option value="col-md-12" selected>100%</option>
				<option value="col-md-9">75%</option>
				<option value="col-md-6">50%</option>
				<option value="col-md-4">33%</option>
				<option value="col-md-3">25%</option>
		</select>
	</div>

	<div class="col-sm-5">
		<div class="checkbox">
			<label><input type="checkbox" id="require" class="data-source"> <?= Yii::t('builder', 'Field require') ?></label>
		</div>
	</div>
</div>
