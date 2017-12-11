<?php

use yii\db\Migration;

class m160710_164409_alter_chartering extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        //$this->addColumn('{{Chartering}}', 'vessel_name', 'varchar(255)');
        //$this->dropForeignKey('fk_chartering_vessel', '{{Chartering}}');

        $this->execute('UPDATE {{Chartering}} chartering INNER JOIN {{Vessel}} vessel ON vessel.vessel_id = chartering.vessel_id SET vessel_name = vessel.name');
    }

    public function safeDown()
    {
        $this->dropColumn('{{Chartering}}', 'vessel_name');
        $this->addForeignKey(
            'fk_chartering_vessel',
            'Chartering',
            'vessel_id',
            'Vessel',
            'vessel_id',
            'RESTRICT',
            'RESTRICT'
        );
    }
}
