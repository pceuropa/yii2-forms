<?php
namespace pceuropa\forms\rbac;

use Yii;
use yii\rbac\Rule;
use yii\db\Query;
use pceuropa\forms\Module;

/**
 * Checks if authorID matches user passed via params
 */
class AuthorFormRule extends Rule
{
    public $name = 'isAuthor';

    /**
     * @param string|integer $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params) {

        $id = Yii::$app->request->get('id');
        $query = (new Query)->select('author')->where(['form_id' => $id])->from(Module::getInstance()->formTable)->one();
        return $query['author'] == $user;
    }
}

