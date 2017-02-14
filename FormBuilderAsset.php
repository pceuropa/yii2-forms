<?php 
namespace pceuropa\forms;

class FormBuilderAsset extends \yii\web\AssetBundle {
    public $sourcePath = '@vendor/pceuropa/yii2-forms/assets/form-builder';
    public $baseUrl = '@web';
    public $css = [
    	'https://cdn.bootcss.com/font-awesome/4.6.3/css/font-awesome.min.css',
    ];
    public $js = [
        'js/forms/Sortable.min.js',
		//'js/forms/forms.min.js',
		'js/forms/helpers.js',
		'js/forms/form.js',
		'js/forms/field.js',
		'js/forms/controller.js',
		'js/forms/examples.js',
		'js/forms/test.js',
		'https://cdn.bootcss.com/vue/1.0.26/vue.min.js',
		'js/editor/vue-html5-editor.js',
		
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}


