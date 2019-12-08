<?php namespace pceuropa\forms\models;

use Yii;
use yii\base\DynamicModel;
use pceuropa\forms\{Module, FormBase};


/**
 * Dynamic Form
 *
 * @author Rafal Marguzewicz
 * @licence MIT
 */
class DynamicFormModel extends DynamicModel {
    use \yii\db\SchemaBuilderTrait;

    public $module = null;

    public static function getDb() {

        if (Module::getInstance()) {
            return Yii::$app->get(Module::getInstance()->db);
        } 

        return Yii::$app->db;
    }


    /**
    * Create or clone table
    *
    * @param string $table_name Name of table
    * @param array $table_schema List of columns and types thus
    *
    */
    public function createTable(string $table_name, array $table_schema)
    {
        $db = $this->getDb();
        $command = $db->createCommand();
        $tableOptions = null;
        if ($db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $query = $command->createTable($table_name, array_merge([
            'id' => $this->primaryKey() ?? 'pk',
            '_ip' => $this->string(15),
            '_csrf' => $this->char(88),
            '_user_agent' => $this->string(),
            '_same_site' => $this->string(),
            '_finger_print' => $this->string(),
            '_number_fraud' => $this->tinyInteger()->unsigned()->notNull()->defaultValue('0'),
            '_form_created' => $this->dateTime()->notNull(),
            '_datetime_response' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $table_schema), $tableOptions);

        if ($query->execute($query)) {
            $command->createIndex('finger_print', $table_name, '_finger_print', true)->execute();
            $command->createIndex('csrf', $table_name, '_csrf', true)->execute();
        }
    }
}
