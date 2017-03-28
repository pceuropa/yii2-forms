<?php 
namespace pceuropa\forms;

class FormAsset extends \yii\web\AssetBundle {
    public $sourcePath = '@vendor/pceuropa/yii2-forms/assets/form';
    public $baseUrl = '@web';
    public $js = [
        'js/forms/helpers.js',
        'js/forms/form.js',
        'js/forms/field.js',
 //       'js/forms/form.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}


