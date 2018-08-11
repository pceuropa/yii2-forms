<div class="form-group-sm form-inline">

  <div class="input-group">
    <div class="input-group-addon"><?= Yii::t('builder', 'Width') ?></div>
        <select id="width" class="form-control data-source">
                <option value="col-md-12" selected>100%</option>
                <option value="col-md-9">75%</option>
                <option value="col-md-6">50%</option>
                <option value="col-md-4">33%</option>
                <option value="col-md-3">25%</option>
        </select>
    </div>

		<div class="checkbox margin-left">
			<label><input type="checkbox" id="require" class="data-source"> <?= Yii::t('builder', 'Field require') ?></label>
		</div>
</div>
