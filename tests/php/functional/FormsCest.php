<?php
class FormsCest
{

    /**
     * @var string Logo of page
     */
    public $logo = 'a.navbar-brand';

    /**
     * @var string title form builder on create and update
     */

    public $formBuilderTitle = 'Form Builder';
    /**
     * @var string Header title on form view
     */
    public $formPreview = 'Form preview:';
    
    /**
     * @var string Header title on page end registration
     */
    public $endRegistration = 'End registration';
    
    /**
     * @var string Message for logged or onwer form 
     */
    public $notAllow = 'You are not allowed to perform this action.';
    
    /**
     * @var string Only post method for delete
     */
    public $onlyPost = 'Method Not Allowed. This url can only handle the following request methods: POST.';
    
    
    /**
     * @var string Message on site/login page
     */
    public $siteLogin= 'I forgot password.';
    
    /**
     * @var string index
     */
    public $index = 'forms/module/index';

    /**
     * @var string list rout
     */
    public $list = 'forms/module/list';


    /**
     * @var string create rout
     */
    public $create = 'forms/module/create';

    /**
     * @var string update rout
     */
    public $update = 'forms/module/update';

    /**
     * @var string delete form action
     */
    public $delete = 'forms/module/delete';

    /**
     * @var string view
     */
    public $view = 'forms/module/view';




    public function _before(\FunctionalTester $I) {
    }

    // otwieramy strony normalnie dostepne
    public function openFormsPages(\FunctionalTester $I) {

        $I->amOnRoute($this->index); $I->seeElement($this->logo);

        $I->amOnPage([$this->list, 'id' => 15]); $I->seeElement($this->logo);

        $I->amOnRoute($this->create); $I->see($this->siteLogin);

        $I->amOnPage([$this->update, 'id' => 1]); $I->see($this->siteLogin);
        $I->amOnPage([$this->delete, 'id' => 1]); $I->see($this->siteLogin);

        $I->amOnPage([$this->view, 'url' => 'url']); $I->see($this->formPreview);
    }

    // otwieramy strony dostepne tylko dla user 1
    public function openFormsOnlyLoggedUser(\FunctionalTester $I) {
        $I->amLoggedInAs(1);

        $I->amOnRoute($this->index); $I->see('Forms');

        $I->amOnRoute($this->list); $I->seeElement($this->logo);

        $I->amOnRoute($this->create); $I->see($this->formBuilderTitle);

        $I->amOnPage([$this->update, 'id' => 1]); $I->see($this->formBuilderTitle);
        $I->amOnPage([$this->delete, 'id' => 1]); $I->see($this->onlyPost);

        $I->amOnPage([$this->view, 'url' => 'url']); $I->see($this->formPreview);
    }

    // otwieramy strony jako user 2 dostepne tylkoa dla 1
    public function openFormsPageByAnotherUser(\FunctionalTester $I) {
        $I->amLoggedInAs(2);

        $I->amOnRoute($this->index); $I->see('Forms');

        $I->amOnRoute($this->list); $I->seeElement($this->logo);

        $I->amOnRoute($this->create); $I->see($this->formBuilderTitle);

        $I->amOnPage([$this->update, 'id' => 1]); $I->see($this->notAllow);
        $I->amOnPage([$this->delete, 'id' => 20]); $I->see($this->onlyPost);

        $I->amOnPage([$this->view, 'url' => 'url']); $I->see($this->formPreview);
    }

    public function openFormsEndRegistration(\FunctionalTester $I) {

        $I->amOnPage([$this->view, 'url' => 'date']);
        $I->see($this->endRegistration);

        $I->amOnPage([$this->view, 'url' => 'maximum']);
        $I->see($this->endRegistration);

        $I->amOnPage([$this->view, 'url' => 'date-and-maximum']);
        $I->see($this->endRegistration);

        $I->amOnPage([$this->view, 'url' => 'date-null']);
        $I->see($this->endRegistration);

        $I->amOnPage([$this->view, 'url' => 'url']);
        $I->see($this->formPreview);
    }
}

