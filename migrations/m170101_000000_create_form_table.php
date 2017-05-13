<?php
#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net
use yii\db\Schema;

class m170101_000000_create_form_table extends \yii\db\Migration {
	protected $table = 'forms';
	
    public function up(){
    	
    	$options = null;
        if ($this->db->driverName === 'mysql'){
            $options = 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1';
        }
    
    
		$this->createTable($this->table, [
            'form_id' => $this->primaryKey(),
            'body' => $this->text(),
            'title' => $this->string(),
            'author' => $this->string(),
            'date_start' => $this->datetime(),
            'date_end' => $this->datetime(),
            'maximum' => $this->integer(),
            'meta_title' => $this->string(),
            'url' => $this->string(),
            'response' => $this->text(),
            'answer' => $this->integer(),
        ], $options);
    }

 	public function down(){
        $this->dropTable($this->table);
    }
}
