<?php 
namespace pceuropa\forms;

class FormBuilderAsset extends \yii\web\AssetBundle {
    public $sourcePath = '@vendor/pceuropa/yii2-forms/assets/form-builder';
    public $baseUrl = '@web';
    public $js = [
        'js/forms/Sortable.min.js',
		'js/forms/forms.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}


