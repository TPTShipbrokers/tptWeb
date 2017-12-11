<?php

use yii\db\Migration;

class m170322_173608_add_auth_key extends Migration
{
    public function up()
    {
        $this->addColumn('User', 'auth_key', $this->string(32)->defaultValue(null));
    }

    public function down()
    {
        echo "m170322_173608_add_auth_key cannot be reverted.\n";

        return false;
    }
}
