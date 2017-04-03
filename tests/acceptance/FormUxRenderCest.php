<?php

use yii\helpers\Url as Url;

class FormUxRenderCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/contact'));
    }

    public function contactPageWorks(AcceptanceTester $I)
    {
        $I->wantTo('ensure that contact page works');
        $I->see('Contact', 'h1');
    }

    public function _after(AcceptanceTester $I)
    {
    }


}
