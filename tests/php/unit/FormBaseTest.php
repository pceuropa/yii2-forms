<?php

use Codeception\Test\Unit;

use pceuropa\forms\FormBase;
use pceuropa\forms\models\FormModel;

use yii\helpers\Json;
use yii\helpers\ArrayHelper;

class FormBaseTest extends Unit {
    /**
     * @var \UnitTester
     */
    protected $tester;
    protected $form = '{}';

    protected $input_field = [
                                 "field" => "input",
                                 "name"=> "thinking",
                                 "type"=> "text",
                                 "label"=> "what are you thinking about",
                                 "width"=> "col-md-12",
                                 "require" => true
                             ];

    protected $radio_field = [
                                 "field"=> "radio",
                                 "width"=> "col-md-6",
                                 "items"=> [
                                     [
                                         "text"=> "No",
                                         "value"=> "no",
                                         "checked"=> true
                                     ],
                                     [
                                         "text"=> "Yes",
                                         "value"=> "yes"
                                     ]
                                 ],
                                 "name"=> "eat",
                                 "label"=> "You eat meat?"
                             ];

    protected function _before() {
        $this->form = FormModel::findModel(1);
        $this->form->body = Json::decode($this->form->body);

    }

    protected function _after() {
    }

    /**
     * Check data from DB
     * @return array
     */
    public function testCheckDataFromDB() {
        $this->assertEquals('en', $this->form->language);
    }

    public function testOnlyCorrectDataFields() {
        $data_fields = FormBase::onlyCorrectDataFields( $this->form->body);
        $this->asserttrue(is_array($data_fields));

        $list_name_fields = ArrayHelper::getColumn($data_fields, 'name');
        $this->assertEquals(['text', 'radio', 'checkbox'], $list_name_fields);
    }


    public function testTableSchema() {
        $table_schema = FormBase::tableSchema($this->form->body);
        $this->assertTrue(is_array($table_schema));
        $this->assertEquals([
                                'id' => 'pk',
                                'text' => 'string',
                                'radio' => 'string',
                                'checkbox' => 'string'
                            ], $table_schema);
    }

    public function testGetColumnType() {
        $type1 = FormBase::getColumnType($this->input_field);
        $this->assertEquals('string', $type1);
        $this->assertArrayHasKey('name', $this->input_field);

        $type2 = FormBase::getColumnType($this->radio_field);
        $this->assertEquals('string', $type2);
        $this->assertArrayHasKey('field', $this->radio_field);
    }

    public function testRuleType() {
        $rule1 = FormBase::ruleType($this->radio_field);
        $this->assertEquals('string', $rule1);

        $rule2 = FormBase::ruleType($this->input_field);
        $this->assertEquals('string', $rule2);

    }
}





