<span class='input-field'>
  	<?php
		require('field/_name.php');
		require('field/_label.php');
		require('field/_help-block.php');
		require('field/_width-and-require.php');
		require('field/_id.php');
		require('field/_class.php');
	?>
</span>

<div class="input-item well">
	<?= Yii::t('builder', 'Items') ?>

	<?php
		require('item/_text.php');
		require('item/_value.php');
		require('item/_checked.php');
    ?>

    <div class="create-buttons row">
        <div class="col-md-5">
            <?php require('button/_add-item.php'); ?>
        </div>
        <div class="select-item-to-change col-md-7"></div>
    </div>


    <div class="update-buttons">
        <?php
            require('button/_back.php');
            require('button/_clone-item.php');
            require('button/_delete-item.php');
	    ?>
    </div>

</div>

<?php require('button/_add-to-form.php'); ?>
