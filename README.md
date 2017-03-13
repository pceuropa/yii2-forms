[![Latest Stable Version](https://poser.pugx.org/pceuropa/yii2-forms/v/stable)](https://packagist.org/packages/pceuropa/yii2-forms) [![Total Downloads](https://poser.pugx.org/pceuropa/yii2-forms/downloads)](https://packagist.org/packages/pceuropa/yii2-forms) [![Latest Unstable Version](https://poser.pugx.org/pceuropa/yii2-forms/v/unstable)](https://packagist.org/packages/pceuropa/yii2-forms) [![License](https://poser.pugx.org/pceuropa/yii2-forms/license)](https://packagist.org/packages/pceuropa/yii2-forms)

Form Builder for Yii2 (beta)
===================


[DEMO](https://pceuropa.net/yii2-extensions/yii2-forms)

## Features


1. Creating forms polls questionnaires e.g backend (class FormBuilder)
* Form generator
 * Drag and drop - Sorting, editing, and deleting items of form
 * CRUD operations by jQuery Ajax
 * List of forms (GridView)
 
2. Storage data submited from form in databases
 * Creating database tables after create form (yii\db\Command::createTable)
 * Delete database tables after delete form (yii\db\Command::dropColumn)
 * Rename column after change the name of field   (yii\db\Command::renameColumn)
 * Add column after add new field to form  (yii\db\Command:: addColumn)
 * Drop column after delete field in form  (yii\db\Command:: dropColumn)
 
 
3. Render forms e.g frontend (class Form)
 * Validation forms (dynamic model)
 * Save data from forms in database
 * GridView of submitted data from the form.
 
## Installation Form Builder
```
composer require pceuropa/yii2-forms "dev-master"
```

## Configuration Form Builder

### 1. Create database schema

Make sure that you have properly configured `db` application component and run the following command:

```bash
$ php yii migrate/up --migrationPath=@vendor/pceuropa/yii2-forms/migrations

```


### 2. Add the following code to view file Yii2
```php

echo \pceuropa\forms\FormBuilder::widget([
		'test_mode' => false
]);

```

### 3. Add the following code to controller view file Yii2

```php
// beta code you can see on my page

```



### 3. Getting started
- [/forms/index](https://pceuropa.net/yii2-extensions/yii2-forms/create)
- [/forms/view](https://pceuropa.net/yii2-extensions/yii2-forms/questions)
- [/forms/create](https://pceuropa.net/yii2-extensions/yii2-forms/create)
- [/forms/update](https://pceuropa.net/yii2-extensions/yii2-forms/update/1)
- /forms/delete
- [/forms/list](https://pceuropa.net/yii2-extensions/yii2-forms/list/1)

 
 ### 3. FormBuilder as module
 ```php
'modules' => [
		'formbuilder' => [
		        'class' => '\pceuropa\forms\Module',
		],
		
    ],
 
```


![preview](https://stats.pceuropa.net/piwik.php?idsite=21&rec=1)
