<?php

use pceuropa\forms\FormBuilder;
use pceuropa\forms\models\FormModel;
use yii\helpers\Json;
use Codeception\Test\Unit;
use yii\base\Exception;

class FormCreateTest extends Unit {

    /**
     * @var \UnitTester
     */
    protected $tester;
    protected $form = '';

    /**
     * @var array  Configuration data for JavaScript assets
     * @since 1.0
     */
    public $jsConfig = [];

    /**
     * @var array configuration data for php render
     * @since 1.0
     */
    private $options = [];

    /**
     * @var string DB connections
     */
    public $db = 'db';

    /**
     * @var string The database table storing the forms
     */
    public $formTable = '{{%forms}';

    /**
     * @var string The database table storing the data from forms
     */
    public $formDataTable = 'form_';
    /**
     * @var string body form
     */
    public $bodyForm = '[[{"field":"input","type":"text","width":"col-md-6","name":"name","label":"Email","require":true},{"field":"input","name":"pass","type":"text","label":"Password","width":"col-md-6","require":true}],[],[{"field":"checkbox","width":"col-md-12","items":[{"text":"Remember me","checked":true,"value":1}],"name":"remember"}],[{"field":"description","width":"col-md-12","textdescription":"<p><a target=\"_blank\" href=\"https://pceuropa.net/blog/\">I forgot my password.</a></p>","":"https://pceuropa.net/blog/"}],[{"field":"submit","width":"col-md-12","backgroundcolor":"btn-info","label":"Submit"}]]';

    /**
     * @var array Form
     */
    public $postData = [
                          'title' => 'title',
                          'method' => 'post',
                          'language' => 'en',
                          'body' => '[[{"field":"description","width":"col-md-12","textdescription":"<h1>Questionnaire</h1>","":"1"},{"field":"input","name":"thinking","type":"text","label":"what are you thinking about","width":"col-md-12","require":true},{"field":"radio","width":"col-md-6","items":[{"text":"No","value":"no","checked":true},{"text":"Yes","value":"yes"}],"name":"trump","label":"Do you like Trump?"},{"field":"radio","width":"col-md-6","items":[{"text":"No","value":"no","checked":true},{"text":"Yes","value":"yes"}],"name":"eat","label":"You eat meat?"}],[{"field":"textarea","name":"ceta","width":"col-md-12","label":"What do you think about CETA?","require":true}],[],[{"field":"input","name":"age","type":"number","label":"Age","width":"col-md-4","require":true},{"field":"select","width":"col-md-4","items":[{"text":"Female","value":"female"},{"text":"Male","value":"male"},{"text":"I do not know","value":"0","checked":true}],"name":"sex","label":"Sex"},{"field":"input","name":"color","type":"color","label":"Favorite color","width":"col-md-4","require":true,"value":"#EAAE1B"}],[],[],[{"field":"checkbox","width":"col-md-12","items":[{"text":"C++","value":"c"},{"text":"Python","value":"python"},{"text":"JavaScript","value":"javascript"},{"text":"PHP","value":"php"},{"text":"Fortran","value":"fortran"}],"name":"framework","label":"What languages you know?"}],[],[{"field":"submit","width":"col-md-6","backgroundcolor":"btn-success","label":"Submit"}]]',
                          'url' => 'url',
                          'maximum' => 30,
                          'date_start' => '2015-11-11',
                          'date_end' => '2020-12-31'
                      ];
    /**
     * @var array Error not unique url
     */
    public $notUniqueUrl = ['url' => 'Url "url" has already been taken.'];

    protected function _before() {
        $this->form = new FormBuilder([
                                          'formTable' => $this->formTable,
                                          'formDataTable' => $this->formDataTable,
                                          'formData' => $this->postData
                                      ]);
    }

    public function testInit() {
        $this->assertEquals( $this->form->db, 'db');
        $this->assertEquals( $this->form->formDataTable, 'form_');
        $this->assertFalse( $this->form->test_mode);
        $this->assertTrue( $this->form->easy_mode);
        $this->assertTrue(is_array($this->form->formData));
    }

    public function testTableSchema() {
        $schema = $this->form->tableSchema($this->bodyForm);
        $this->assertEquals($schema, [
                                'id' => 'pk',
                                'name' => 'string',
                                'pass' => 'string',
                                'remember' => 'string'
                            ]);
    }

    public function testNotUniqueUrl() {
        $this->form->save();
        $this->form->createTable();
        $this->assertEquals( $this->notUniqueUrl, $this->form->success);
    }
}
