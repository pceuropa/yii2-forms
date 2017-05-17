<?php 

$I = new FunctionalTester($scenario);


$I->wantTo('Not access for quest to forms/module/user');
$I->amOnRoute('forms/module/user');
$I->see('I forgot password.');

$I->wantTo('Not access for quest to forms/module/create');
$I->amOnRoute('forms/module/create');
$I->see('I forgot password.');

