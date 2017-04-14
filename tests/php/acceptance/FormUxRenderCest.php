<?php

use yii\helpers\Url;


class FormUxRenderCest {
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/forms/create'));
    }

    public function contactPageWorks(AcceptanceTester $I)
    {
        $I->wantTo('ensure that index page works');
        $I->see('Form Builder', 'h1');
    }

    public function _after(AcceptanceTester $I)
    {
    }


}
