<?php
#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net
use yii\db\Schema;
/**
 * Migration tools
 *
 * Create table forms and optionaly rules RBAC
 *
 * @author Rafal Marguzewicz
 * @licence MIT
 */

class m170101_000000_create_form_table extends \yii\db\Migration {

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%forms}}', [
            'form_id' => $this->integer(11)->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'body' => $this->text()->notNull(),
            'title' => $this->string(255)->notNull(),
            'author' => $this->integer(11),
            'date_start' => $this->date(),
            'date_end' => $this->dateTime(),
            'maximum' => $this->integer(11),
            'meta_title' => $this->string(255),
            'url' => $this->string(255)->notNull(),
            'response' => $this->text(),
            'answer' => $this->integer(11)->notNull()->defaultValue('0'),
            'method' => $this->string(4)->defaultValue('post'),
            'language' => $this->string(11)->defaultValue('en'),
        ], $tableOptions);
    }
}
