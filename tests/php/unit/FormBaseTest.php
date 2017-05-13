<?php
use pceuropa\forms\FormBase;
use yii\helpers\Json;
use Codeception\Test\Unit;

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

    protected function _before(){
        $this->form = Json::decode('{
            "title": "test",
            "method": "post",
            "language": "English",
            "body": [
                [
                    {
                        "field": "description",
                        "width": "col-md-12",
                        "textdescription": "<h1>Questionnaire</h1>",
                        "": "1"
                    },
                    {
                        "field": "input",
                        "name": "thinking",
                        "type": "text",
                        "label": "what are you thinking about",
                        "width": "col-md-12",
                        "require": true
                    },
                    {
                        "field": "radio",
                        "width": "col-md-6",
                        "items": [
                            {
                                "text": "No",
                                "value": "no",
                                "checked": true
                            },
                            {
                                "text": "Yes",
                                "value": "yes"
                            }
                        ],
                        "name": "trump",
                        "label": "Do you like Trump?"
                    },
                    {
                        "field": "radio",
                        "width": "col-md-6",
                        "items": [
                            {
                                "text": "No",
                                "value": "no",
                                "checked": true
                            },
                            {
                                "text": "Yes",
                                "value": "yes"
                            }
                        ],
                        "name": "eat",
                        "label": "You eat meat?"
                    }
                ],
                [
                    {
                        "field": "textarea",
                        "name": "ceta",
                        "width": "col-md-12",
                        "label": "What do you think about CETA?",
                        "require": true
                    }
                ],
                [
                    {
                        "field": "input",
                        "name": "age",
                        "type": "number",
                        "label": "Age",
                        "width": "col-md-4",
                        "require": true
                    },
                    {
                        "field": "select",
                        "width": "col-md-4",
                        "items": [
                            {
                                "text": "Female",
                                "value": "female"
                            },
                            {
                                "text": "Male",
                                "value": "male"
                            },
                            {
                                "text": "I do not know",
                                "value": "0",
                                "checked": true
                            }
                        ],
                        "name": "sex",
                        "label": "Sex"
                    },
                    {
                        "field": "input",
                        "name": "color",
                        "type": "color",
                        "label": "Favorite color",
                        "width": "col-md-4",
                        "require": true,
                        "value": "#EAAE1B"
                    }
                ],
                [
                    {
                        "field": "checkbox",
                        "width": "col-md-12",
                        "items": [
                            {
                                "text": "C++",
                                "value": "c"
                            },
                            {
                                "text": "Python",
                                "value": "python"
                            },
                            {
                                "text": "JavaScript",
                                "value": "javascript"
                            },
                            {
                                "text": "PHP",
                                "value": "php"
                            },
                            {
                                "text": "Fortran",
                                "value": "fortran"
                            }
                        ],
                        "name": "framework",
                        "label": "What languages you know?"
                    }
                ],
                [],
                [
                    {
                        "field": "submit",
                        "width": "col-md-6",
                        "backgroundcolor": "btn-success",
                        "label": "Submit"
                    }
                ]
            ],
            "url": "testtt"
        }');
        $this->form = $this->form['body'];
        
    }

protected function _after(){
    }

public function testOnlyCorrectDataFields(){
        $data_fields = FormBase::onlyCorrectDataFields($this->form);
        $this->assertTrue(is_array($data_fields));
    }
       

public function testTableShema(){
        $data_fields = FormBase::tableSchema($this->form);
        $this->assertTrue(is_array($data_fields));
    }

 public function testGetColumnType(){
        $type1 = FormBase::getColumnType($this->input_field);
        $this->assertTrue(is_string($type1));
        $this->assertEquals('string', $type1);
        $this->assertArrayHasKey('field', $this->input_field);
        $this->assertArrayHasKey('name', $this->input_field);

        $type2 = FormBase::getColumnType($this->radio_field); 
        $this->assertTrue(is_string($type2));
        $this->assertEquals('string', $type2);
        $this->assertArrayHasKey('field', $this->radio_field);
        $this->assertArrayHasKey('name', $this->radio_field);
    }

 public function testRuleType(){
        $rule1 = FormBase::ruleType($this->radio_field);
        $this->assertEquals('string', $rule1);
        $rule2 = FormBase::ruleType($this->input_field);
        $this->assertEquals('string', $rule2);
        
    }
}

