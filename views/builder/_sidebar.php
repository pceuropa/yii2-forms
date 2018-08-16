
  <ul id="options-tabs" class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
        <a href="#form" data-id='form' aria-controls="form" role="tab" data-toggle="tab"><?= Yii::t('builder', 'Form') ?></a>
    </li>

    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?= Yii::t('builder', 'Field') ?><span class="caret"></span></a>
      <ul id='select-field' class="dropdown-menu" role="menu">
        <li role="presentation"><a href="#input" data-id='input'  aria-controls="input" role="tab" data-toggle="tab"><?= Yii::t('builder', 'Input') ?></a></li>
        <li role="presentation"><a href="#textarea" data-id='textarea' aria-controls="textarea" role="tab" data-toggle="tab"><?= Yii::t('builder', 'TextArea') ?></a></li>
        <li role="presentation"><a href="#radio" data-id='radio' aria-controls="radio" role="tab" data-toggle="tab"><?= Yii::t('builder', 'Radio') ?></a></li>
        <li role="presentation"><a href="#checkbox" data-id='checkbox' aria-controls="checkbox" role="tab" data-toggle="tab"><?= Yii::t('builder', 'Checkbox') ?></a></li>
        <li role="presentation"><a href="#select" data-id='select' aria-controls="select" role="tab" data-toggle="tab"><?= Yii::t('builder', 'Select') ?></a></li>
        <li role="presentation"><a href="#description" data-id='description' aria-controls="description" role="tab" data-toggle="tab"><?= Yii::t('builder', 'Description') ?></a></li>
        <li role="presentation"><a href="#submit" data-id='submit' aria-controls="submit" role="tab" data-toggle="tab"><?= Yii::t('builder', 'Submit Button') ?></a></li>
      </ul>
    </li>

    <li role="presentation" class='delete'>
        <a href="#delete" data-id='delete' aria-controls="form" role="tab" data-toggle="tab"><?= Yii::t('builder', 'Delete') ?></a>
    </li>
  </ul>

  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="form"> 
        <?= $this->render('options/form', ['hide_button_form_save' => $hide_button_form_save]); ?>
    </div>

    <div role="tabpanel" id="input" class="tab-pane"><?= $this->render('options/input'); ?> </div>
    <div role="tabpanel" id="textarea" class="tab-pane"><?= $this->render('options/textarea'); ?></div>
    <div role="tabpanel" id="radio" class="tab-pane"><?= $this->render('options/multi-field'); ?></div>
    <div role="tabpanel" id="checkbox" class="tab-pane"><?= $this->render('options/multi-field'); ?></div>
    <div role="tabpanel" id="select" class="tab-pane"><?= $this->render('options/select'); ?></div>
    <div role="tabpanel" id="description" class="tab-pane"><?= $this->render('options/description'); ?></div>
    <div role="tabpanel" id="submit" class="tab-pane"><?= $this->render('options/submit'); ?></div>
</div>

<div class='hide'>

    <div id="delete">
        <?= $this->render('options/button/_back'); ?>
        <?= $this->render('options/button/_delete'); ?>
    </div>

</div>
