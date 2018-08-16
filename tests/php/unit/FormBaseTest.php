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

    }

    protected function _after() {
    }

    /**
     * Check data from DB
     * @return array
     */
    public function testCheckDataFromDB() {
        #$this->assertEquals('en', $this->form->language);
    }

    public function testOnlyCorrectDataFields() {
    }


    public function testTableSchema() {
    }


    public function testRuleType() {
        $rule1 = FormBase::ruleType($this->radio_field);
        $this->assertEquals('string', $rule1);

        $rule2 = FormBase::ruleType($this->input_field);
        $this->assertEquals('string', $rule2);
    }
}
