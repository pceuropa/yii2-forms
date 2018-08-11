<div class="form-group-sm">
    <div class="input-group">
      <div class="input-group-addon"><?= Yii::t('builder', 'Type') ?></div>
		<select id="type" class="form-control data-source">
			<option value="text"><?= Yii::t('builder', 'text') ?></option>
			<option value="email"><?= Yii::t('builder', 'email') ?></option>
			<option value="password"><?= Yii::t('builder', 'password') ?></option>
			<option value="date"><?= Yii::t('builder', 'date') ?></option>
			<option value="number"><?= Yii::t('builder', 'number') ?></option>
			<option value="url"><?= Yii::t('builder', 'URL') ?></option>
			<option value="tel"><?= Yii::t('builder', 'phone') ?></option>
			<option value="color"><?= Yii::t('builder', 'color') ?></option>
			<option value="range"><?= Yii::t('builder', 'range') ?></option>
		</select>
    </div>
</div>
