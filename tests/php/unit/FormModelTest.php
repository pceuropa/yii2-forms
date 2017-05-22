<?php
use pceuropa\forms\models\FormModel;
use Codeception\Test\Unit;

class FormModelTest extends Unit {

    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testDb() {
      $db = FormModel::getDb();
      $this->assertEquals('mysql:host=localhost;dbname=yii2_basic_tests', $db->dsn);
    }

    public function testTable() {
      $tableName = FormModel::tableName();
      $this->assertEquals('forms', $tableName);
    }
    public function testModelFindById() {
      $form = FormModel::findModel(15);
      $this->assertEquals('title', $form->title);
    }
    public function testModelFindByUrl() {
      $form = FormModel::findModelByUrl('url');
      $this->assertEquals('title', $form->title);
    }
}
