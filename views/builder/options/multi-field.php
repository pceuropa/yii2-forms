<!--  Copyright (c) 2017 Rafal Marguzewicz pceuropa.net -->
<span class='input-field'>
  	<?php
		require('fields/_name.php');
		require('fields/_label.php');
		require('fields/_help-block.php');
		require('fields/_width-and-require.php');
		require('fields/_id.php');
		require('fields/_class.php');
	?>
</span>


<div class="input-item well">
	<b><?= Yii::t('builder', 'Items') ?></b>

	<?php
		require('items/_text.php');
		require('items/_value.php');
		require('items/_checked.php');
    ?>

    <div class="create-buttons row">
        <div class="col-md-5">
            <?php require('buttons/_add-item.php'); ?>
        </div>
        <div class="select-item-to-change col-md-7"></div>
    </div>


    <div class="update-buttons">
        <?php
            require('buttons/_back.php');
            require('buttons/_clone-item.php');
            require('buttons/_delete-item.php');
	    ?>
    </div>

</div>

<?php require('buttons/_add-to-form.php'); ?>
