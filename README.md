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
composer require pceuropa/yii2-forms "dev-master"
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
/forms/module/user                     // List of user forms
/forms/module/view                     // Preview form
/forms/module/create                   // FormBuilder - create form
/forms/module/update                   // Update form 
/forms/module/delete                   // Delete form
```

## Full example configuration Form Builder

```
'forms' => [
          'class' => 'pceuropa\forms\Module',
          'db' => 'db',
          'formsTable' => '{{%forms}}',
          'formDataTable' => '{{%form_}}',
          'rules' => [
                [
                    'actions' => [ 'update', 'delete', 'clone'],
                    'allow' => true,
                    'roles' => ['updateOwnForm'],   // rule only owner can edit form
                ],
                [
                    'actions' => ['user', 'create'],
                    'allow' => true,
                    'roles' => ['user'],            // role only authenticated user can
                ]
            ]
      ],
```

Widget render forms
```
echo \pceuropa\forms\Form::widget([
	'form' => $form_body,
	'typeRender' => 'php'
])
```
## Configure RBAC Component

Before you can go on you need to create those tables in the database.

```
yii migrate --migrationPath=@yii/rbac/migrations
```

Building autorization data

To use generator console, add fallowing code to config console file
```
'controllerMap' => [
  'formsrbac' => [
      'class' => 'pceuropa\forms\migrations\RbacController',
  ],
],
```
Create rbac tables in the database
```
yii migrate --migrationPath=@yii/rbac/migrations
```
Create rules and roles for form module
```
php yii formsrbac/generate
```

## Tests
For tests run 
```
composer exec -v -- codecept -c vendor/pceuropa/forms run
```
or
```
cd vendor/pceuropa/yii2-forms
codecept run
```
