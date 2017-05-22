<?php

use pceuropa\forms\FormBuilder;
use pceuropa\forms\models\FormModel;
use yii\helpers\Json;
use Codeception\Test\Unit;
use yii\base\Exception;

class FormUpdateTest extends Unit {

    /**
     * @var \UnitTester
     */
    protected $tester;
    protected $form = '';
    /**
     * @var string body form
     */
    public $bodyForm = '[[{"field":"input","type":"text","width":"col-md-6","name":"name","label":"Email","require":true},{"field":"input","name":"pass","type":"text","label":"Password","width":"col-md-6","require":true}],[],[{"field":"checkbox","width":"col-md-12","items":[{"text":"Remember me","checked":true,"value":1}],"name":"remember"}],[{"field":"description","width":"col-md-12","textdescription":"<p><a target=\"_blank\" href=\"https://pceuropa.net/blog/\">I forgot my password.</a></p>","":"https://pceuropa.net/blog/"}],[{"field":"submit","width":"col-md-12","backgroundcolor":"btn-info","label":"Submit"}]]';


    protected function _before() {
        $this->formBuilder = new FormBuilder([
                'formTable' => '{{%forms}}',
                'formDataTable' => 'form_',
                                             ]);
    }

    public function testInit() {
        $this->assertEquals( $this->formBuilder->db, 'db');
        $this->assertFalse( $this->formBuilder->test_mode);
        $this->assertTrue( $this->formBuilder->easy_mode);
        $this->assertFalse( $this->formBuilder->email_response);
    }

    public function testTableSchema() {
        $schema = $this->formBuilder->tableSchema($this->bodyForm);
        $this->assertEquals($schema, [
                                'id' => 'pk',
                                'name' => 'string',
                                'pass' => 'string',
                                'remember' => 'string'
                            ]);

    }

    public function testCreateTable() {
        $this->formBuilder->success = true;

        $form = new FormModel();
        $form->body = '[]';
        $form->url = 'test';
        $form->title = 'title';
        $form->save();
    }
    public function testAddColumn() {
    }
    public function testRenameColumn() {
    }
    public function testDropColumn() {
    }
}





