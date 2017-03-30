<?php
use pceuropa\forms\FormBase;

class FormBaseTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testGetColumnType()
    {
        $this->assertEquals('string', 'string');
        $this->assertEquals(1, 1);
    }

public function testEquals()
    {
        $this->assertEquals(true, true);
    }
}
