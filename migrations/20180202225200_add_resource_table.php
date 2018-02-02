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
