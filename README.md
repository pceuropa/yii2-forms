FormBuilder module for Yii2
===================

[![Latest Stable Version](https://poser.pugx.org/pceuropa/yii2-forms/v/stable)](https://packagist.org/packages/pceuropa/yii2-forms) [![Total Downloads](https://poser.pugx.org/pceuropa/yii2-forms/downloads)](https://packagist.org/packages/pceuropa/yii2-forms) [![License](https://poser.pugx.org/pceuropa/yii2-forms/license)](https://packagist.org/packages/pceuropa/yii2-forms)

[FormBuilder DEMO](https://pceuropa.net/yii2-extensions/yii2-forms)

## Features


1. Generate forms, surveys, polls, questionnaires (class FormBuilder)
 * Drag and drop - Sorting, editing, and deleting items
 * CRUD operations by AJAX
 * Built-in RBAC component

 
2. Form render  widget (class Form)
 * Validation forms (dynamic model)

3. Storage data submited from form in databases
 * List of forms (GridView)
 * Create database tables after create form 
 * Delete database tables after delete form
 * Add table column after add field to form 
 * Rename table column after change the name of field
 * Drop table column after delete field in form

## Installation Form Builder
```
composer require pceuropa/yii2-forms
```

## Configuration Form Builder
Make sure that you have properly configured `db` application component in config file and run the following command:
```bash
$ php yii migrate/up --migrationPath=@vendor/pceuropa/yii2-forms/migrations
```

Add the following code in your configuration file:
```php
'modules' => [
    'forms' => [
          'class' => 'pceuropa\forms\Module',
     ],
]
```

##  Usage
URLs for the translating tool:

```
/forms/module/index                    // List of all forms                     
/forms/module/user                     // List user's forms
/forms/module/view                     // Preview form
/forms/module/create                   // Create form - FormBuilder 
/forms/module/update                   // Update form 
/forms/module/delete                   // Delete form
```

## Full example configuration Form Builder

```
'modules' => [
      'forms' => [
          'class' => 'pceuropa\forms\Module',
          'db' => 'db',
          'formsTable' => '{{%forms}}',
          'formDataTable' => 'form_',
          'sendEmail' => true, 
          'emailSender' => 'info@email.net',
          'rules' => [
                [
                    'actions' => [ 'update', 'delete', 'clone'],
                    'allow' => true,
                    'roles' => ['updateOwnForm'],   // rule only owner can edit form
                ],
                [
                    'actions' => ['user'],
                    'allow' => true,
                    'roles' => ['user'],     // role only authenticated user can see user's forms
                ],
                [
                    'actions' => ['create'],
                    'allow' => true,
                    'roles' => ['@'],        // role only logged user can create form
                ]
            ]
      ]
],

'components' => [
	  'authManager' => ['class' => 'yii\rbac\DbManager',],
]
```

## Form renderer widget
```
use pceuropa\forms\Form;
echo Form::widget([
     'body' => '[[{"field": "input", "type": "text", "width": "col-md-5", "name": "email", "placeholder": "email"},{"field": "input", "name": "pass", "type": "text", "placeholder": "pass", "width": "col-md-5"},{"field": "submit", "width": "col-md-2", "backgroundcolor": "btn-info", "label": "Submit"}]]',
     'typeRender' => 'php'
     ]);
```
or
```
  echo Form::widget([
     'formId' => 1, // equivalennt 'form' => FormModel::findOne(1)->body
  ]);
```

## Configure RBAC Component
To use generator console, add fallowing code to console config (console.php)
```
'controllerMap' => [
  'formsrbac' => [
      'class' => 'pceuropa\forms\migrations\RbacController',
  ],
],
```


To use RBAC dont forget add fallowing code to app config (web.php or main.php)
```
'components' => [
	  'authManager' => ['class' => 'yii\rbac\DbManager',],
]
```

Create rbac tables in the database
```yii migrate --migrationPath=@yii/rbac/migrations```

Create RBAC rules and roles. Asssign role user to all users. You can add assign role acction in SignupController
```php yii formsrbac/generate```


## Tests
Php tests run 
```
vendor/bin/codecept run -c vendor/pceuropa/yii2-forms
```
or
```
cd vendor/pceuropa/yii2-forms
../../bin/codecept run
```

JavaScript tests run
On begining install depencies:
```
cd vendor/pceuropa/yii2-forms
npm install
```

run test
```
cd vendor/pceuropa/yii2-forms
karma start
//or if you use karma localy
npm run test
```
## ex. Menu
```
[
'label' => 'forms',
    'items' => [
        ['label' => 'List of all forms', 'url' => ['/forms/module/index']],
        ['label' => 'User\'s forms', 
            'url' => ['/forms/module/user'],
            'visible' => !Yii::$app->user->isGuest
        ],
        ['label' => 'Create form', 'url' => ['/forms/module/create']],
    ],
],
```
