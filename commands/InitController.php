<?php namespace pceuropa\forms\commands;

use yii\console\Controller;
use yii\helpers\Console;
use yii\rbac\DbManager;
use yii\rbac\Permission;
use yii\rbac\Role;
use yii\rbac\Rule;
use yii\db\Query;

/**
 * Rbac init
 * Create rbac rules and role
 * @author Rafal Marguzewicz
 * @licence MIT
 */
class InitController extends  Controller {

    const CREATE_FORM = 'createForm';
    const UPDATE_FORM = 'updateForm';
    const DELETE_FORM = 'deleteForm';
    const VIEWDATA_FORM = 'viewdataForm';
    const USER = 'user';
    const UPDATE_OWN_FORM = 'updateOwnForm';

    public function actionIndex($message = 'hello world from module yii2-forms') {
        echo $message . "\n";
    }

    /**
     * Generate rules rbas
     * @return void
     */
    public function actionRbac() {

        $authManager = new DbManager();
        $permission = self::CREATE_FORM;

        try {
            $createForm = $authManager->getPermission($permission);
        } catch (\yii\db\Exception $e) {
            echo $this->ansiFormat($e->errorInfo[2], Console::FG_RED);echo "\n";
            echo $this->ansiFormat('Rbac migration:  php yii migrate/up --migrationPath=@yii/rbac/migrations', Console::FG_YELLOW);echo "\n";
            return false;

        }

        if (!($createForm instanceof Permission)) {
            $createForm = $authManager->createPermission($permission);
            $createForm->description = 'Create forms';
            $authManager->add($createForm);
            echo $this->ansiFormat('Permision `'.$permission .'` added successfully', Console::FG_GREEN);
            echo "\n";
        } else {
            echo $this->ansiFormat('Permision `'.$permission .'` exist', Console::FG_YELLOW);
            echo "\n";
        }

        $permission = self::UPDATE_FORM;
        $updateForm = $authManager->getPermission($permission);
        if (!($updateForm instanceof Permission)) {
            $updateForm = $authManager->createPermission($permission);
            $updateForm->description = 'update forms';
            $authManager->add($updateForm);
            echo $this->ansiFormat('Permision `'.$permission .'` added successfully', Console::FG_GREEN); echo "\n";
        } else {
            echo $this->ansiFormat('Permision `'.$permission.'` exist', Console::FG_YELLOW); echo "\n";
        }

        $permission = self::DELETE_FORM;
        $deleteForm = $authManager->getPermission($permission);
        if (!($deleteForm instanceof Permission)) {
            $deleteForm = $authManager->createPermission($permission);
            $deleteForm->description = 'delete forms';
            $authManager->add($deleteForm);
            echo $this->ansiFormat('Permision `'.$permission .'` added successfully', Console::FG_GREEN);
            echo "\n";
        } else {
            echo $this->ansiFormat('Permision `'.$permission .'` exist', Console::FG_YELLOW);
            echo "\n";
        }

        $permission = self::VIEWDATA_FORM;
        $viewdataForm = $authManager->getPermission($permission);
        if (!($viewdataForm instanceof Permission)) {

            $viewdataForm = $authManager->createPermission($permission);
            $viewdataForm->description = 'view data forms';
            $authManager->add($viewdataForm);

            echo $this->ansiFormat('Permision `'.$permission .'` added successfully', Console::FG_GREEN);
            echo "\n";
        } else {
            echo $this->ansiFormat('Permision `'.$permission .'` exist', Console::FG_YELLOW);
            echo "\n";
        }

        $role = self::USER;
        $userForm = $authManager->getRole($role);
        if (!($userForm instanceof role)) {

            $userForm = $authManager->createrole($role);
            $userForm->description = 'user role';
            $authManager->add($userForm);

            $authManager->addchild($userForm, $createForm);
            $authManager->addchild($userForm, $deleteForm);
            $authManager->addchild($userForm, $updateForm);

            echo $this->ansiformat('Role `'.$role .'` added successfully', console::FG_GREEN);
            echo "\n";
        } else {
            echo $this->ansiformat('Role `'.$role .'` exist', console::FG_YELLOW);
            echo "\n";
        }

        $rule = new \pceuropa\forms\rbac\AuthorFormRule;	// added successfully the rule
        $updateOwnForm = $authManager->getRule($rule->name);
        if (!($updateOwnForm instanceof Rule)) {
            $authManager->add($rule);

            echo $this->ansiFormat('Rule `'.$rule->name .'` added successfully', Console::FG_GREEN);
            echo "\n";
        } else {
            echo $this->ansiFormat('Rule `'.$rule->name .'` exist', Console::FG_YELLOW);

            echo "\n";
        }


        $permission = self::UPDATE_OWN_FORM;
        $updateOwnForm = $authManager->getPermission($permission);
        if (!($updateOwnForm instanceof Permission)) {

            // added successfully the "updateOwnForm" permission and associate the rule with it.
            $updateOwnForm = $authManager->createPermission($permission);
            $updateOwnForm->description = 'Update own form';
            $updateOwnForm->ruleName = $rule->name;
            $authManager->add($updateOwnForm);

            $authManager->addChild($userForm, $updateOwnForm);


            echo $this->ansiFormat('Permision `'.$permission .'` added successfully', Console::FG_GREEN);
            echo "\n";
        } else {
            echo $this->ansiFormat('Permision `'.$permission .'` exist', Console::FG_YELLOW);
            echo "\n";
        }

        if ($this->confirm("Could you assign role `user` to all users.")) {
            $query = (new Query())->from('user');
            $count = $query->count();
            echo $this->ansiFormat($count .' users in database', Console::FG_RED);
            echo "\n";

            $ids = $query->select('id')->all();
            foreach ($ids as $key => $value) {
                try {

                    $authManager->assign($userForm, $value['id']);
                    echo $this->ansiFormat('Assign role `'.$userForm->name.'` to user id: '. $value['id'] , Console::FG_GREEN);
                    echo "\n";
                } catch (\yii\db\IntegrityException $e) {
                    echo $this->ansiFormat('Not assign role `'.$userForm->name.'` to user id: '. $value['id'].'. Maybe exist' , Console::FG_RED);
                    echo "\n";
                }
            }
        }
    }
}
?>
