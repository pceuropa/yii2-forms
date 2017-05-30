<?php
class FormsCest
{
    public function _before(\FunctionalTester $I) {
        $I->amOnRoute('forms/index');
    }

    public function openIndexPage(\FunctionalTester $I) {
        $I->seeElement('a.navbar-brand');
    }
    public function openCreatePage(\FunctionalTester $I) {
      $I->amOnRoute('forms/create');
      $I->seeElement('a.navbar-brand');
    }

}
