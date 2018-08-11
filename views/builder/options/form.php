<div class="form-group-sm">
    <div class="input-group">
      <div class="input-group-addon"><?= Yii::t('builder', 'View') ?></div>
		<select id="view-mode" class="form-control">
			<option value="html" >HTML</option>
			<option value="text"><?= Yii::t('builder', 'Text') ?></option>
			<option value="json" >Json</option>
			<option value="yii2">Yii2</option>
		</select>
    </div>
</div>

<span>
<div class="form-group-sm generator_mode">
    <div class="input-group">
      <div class="input-group-addon"><?= Yii::t('builder', 'Title') ?> *</div>
    	<input id="title" type="text" class="form-control">
    </div>
</div>


<div class="form-group-sm generator_mode">
    <div class="input-group">
      <div class="input-group-addon"><?= Yii::t('builder', 'URL') ?> *</div>
    	<input id="url" type="text" class="form-control">
    </div>
</div>

<div class="form-group-sm generator_mode">
    <div class="input-group">
      <div class="input-group-addon"><?= Yii::t('builder', 'Limit Entries') ?></div>
    	<input id="maximum" type="number" class="form-control">
    </div>
</div>

<div class="form-group-sm generator_mode">
    <div class="input-group">
      <div class="input-group-addon"><?= Yii::t('builder', 'Start') ?></div>
		<input id="date_start" type="date" class="form-control" placeholder="yyyy-mm-dd">
    </div>
</div>

<div class="form-group-sm generator_mode">
    <div class="input-group">
      <div class="input-group-addon"><?= Yii::t('builder', 'End') ?></div>
		<input id="date_end" type="date" class="form-control" placeholder="yyyy-mm-dd">
    </div>
</div>

<div class="form-group-sm expert">
    <div class="input-group">
      <div class="input-group-addon"><?= Yii::t('builder', 'Method') ?></div>
          <select id="method" class="form-control">
              <option value="post" >POST</option>
              <option value="get">GET</option>
          </select>
    </div>
</div>

<div class="form-group-sm expert">
    <div class="input-group">
      <div class="input-group-addon"><?= Yii::t('builder', 'Action') ?></div>
		<input id="action" type="text" class="form-control" >
    </div>
</div>

<?php require('field/_id.php'); ?>
		
<div class="form-group-sm expert">
    <div class="input-group">
    <div class="input-group-addon"><?= Yii::t('builder', 'Class') ?></div>
        <input id="class" type="text" class="form-control">
    </div>
</div>

	<div id="widget-form-options"></div>
	<?php if (!$hide_button_form_save) {
	    require('button/_save-form.php');
    }?> 
</span>
