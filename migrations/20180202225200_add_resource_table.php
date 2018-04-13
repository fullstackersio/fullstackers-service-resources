<?php


use \Fullstackersio\Migration\Migration;

class AddResourceTable extends Migration
{
    public function change()
    {
        $table = $this->table('resource');
        $table->addColumn('resource_id', 'integer')
              ->addColumn('created', 'datetime')
              ->create();
    }
}

/*
CREATE TABLE resources
(
  id BIGINT
  , type VARCHAR(100) NOT NULL
  , paid_ind SMALLINT NOT NULL DEFAULT 0
  , date_created DATE NOT NULL DEFAULT '3999-12-31'
  , date_uploaded TIMESTAMP
  , url TEXT NOT NULL
  , summary TEXT
  , user_id BIGINT
  , approved_status SMALLINT NOT NULL DEFAULT 1000
  , flagged_status SMALLINT NOT NULL DEFAULT 1000
  , delete_status SMALLINT NOT NULL DEFAULT 1000
  , PRIMARY KEY (id)
  , FOREIGN KEY (user_id) REFERENCES users (id) 
);
*/