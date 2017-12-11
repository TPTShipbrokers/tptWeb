<?php

use yii\db\Migration;

/**
 * Class m170224_114938_create_positions_tables
 */
class m170224_114938_create_positions_tables extends Migration
{
    /**
     * @return bool
     */
    public function up()
    {
        $this->execute('ALTER TABLE `Vessel` CHANGE `name` `name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                          CHANGE `size` `size` ENUM(\'mr\',\'handy\',\'lr\') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                          CHANGE `status` `status` ENUM(\'open\',\'on_subs\') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                          CHANGE `location` `location` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                          CHANGE `last` `last` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
                          CHANGE `hull` `hull` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
                          CHANGE `sire` `sire` ENUM(\'yes\',\'no\') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;');

        $this->execute('CREATE TABLE IF NOT EXISTS `WafPositions` (
                          `vessel_id` BIGINT(20) UNSIGNED NOT NULL,
                          `name` VARCHAR(255) NOT NULL,
                          `size` ENUM(\'mr\',\'handy\',\'lr\') NOT NULL,
                          `grade` ENUM(\'clean\',\'dirty\') DEFAULT NULL,
                          `built` YEAR(4) NOT NULL,
                          `status` ENUM(\'open\',\'on_subs\') NOT NULL,
                          `open_date` DATETIME NOT NULL,
                          `location` TEXT NOT NULL,
                          `cbm` INT(11) DEFAULT NULL,
                          `dwt` INT(11) DEFAULT NULL,
                          `loa` DOUBLE DEFAULT NULL,
                          `last` TEXT,
                          `imo` INT(11) DEFAULT NULL,
                          `hull` TEXT,
                          `sire` ENUM(\'yes\',\'no\') DEFAULT NULL,
                          `intake` INT(11) DEFAULT NULL,
                          `tema_suitable` TEXT CHARACTER SET latin1,
                          `cabotage` TEXT CHARACTER SET latin1,
                          `nigerian_cab` TEXT CHARACTER SET latin1,
                          `comments` TEXT CHARACTER SET latin1,
                          `last_update` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                          `broker_id` BIGINT(20) UNSIGNED DEFAULT NULL,
                          `positions_visible` SMALLINT(6) NOT NULL DEFAULT \'1\'
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;');

        $this->execute('ALTER TABLE `WafPositions`
                          ADD PRIMARY KEY (`vessel_id`),
                          ADD UNIQUE KEY `name` (`name`),
                          ADD KEY `broker_id` (`broker_id`);');

        $this->execute('ALTER TABLE `WafPositions`
                          MODIFY `vessel_id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT;');

        $this->execute('ALTER TABLE `WafPositions`
                          ADD CONSTRAINT `fk_WafPositions_broker` FOREIGN KEY (`broker_id`)
                          REFERENCES `User` (`user_id`) ON DELETE SET NULL;');

        $this->execute('CREATE TABLE IF NOT EXISTS `AraPositions` (
                          `vessel_id` BIGINT(20) UNSIGNED NOT NULL,
                          `name` VARCHAR(255) NOT NULL,
                          `size` ENUM(\'mr\',\'handy\',\'lr\') NOT NULL,
                          `grade` ENUM(\'clean\',\'dirty\') DEFAULT NULL,
                          `built` YEAR(4) NOT NULL,
                          `status` ENUM(\'open\',\'on_subs\') NOT NULL,
                          `open_date` DATETIME NOT NULL,
                          `location` TEXT NOT NULL,
                          `cbm` INT(11) DEFAULT NULL,
                          `dwt` INT(11) DEFAULT NULL,
                          `loa` DOUBLE DEFAULT NULL,
                          `last` TEXT,
                          `imo` INT(11) DEFAULT NULL,
                          `hull` TEXT,
                          `sire` ENUM(\'yes\',\'no\') DEFAULT NULL,
                          `intake` INT(11) DEFAULT NULL,
                          `tema_suitable` TEXT CHARACTER SET latin1,
                          `cabotage` TEXT CHARACTER SET latin1,
                          `nigerian_cab` TEXT CHARACTER SET latin1,
                          `comments` TEXT CHARACTER SET latin1,
                          `last_update` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                          `broker_id` BIGINT(20) UNSIGNED DEFAULT NULL,
                          `positions_visible` SMALLINT(6) NOT NULL DEFAULT \'1\'
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;');

        $this->execute('ALTER TABLE `AraPositions`
                          ADD PRIMARY KEY (`vessel_id`),
                          ADD UNIQUE KEY `name` (`name`),
                          ADD KEY `broker_id` (`broker_id`);');

        $this->execute('ALTER TABLE `AraPositions`
                          MODIFY `vessel_id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT;');

        $this->execute('ALTER TABLE `AraPositions`
                          ADD CONSTRAINT `fk_AraPositions_broker` FOREIGN KEY (`broker_id`)
                          REFERENCES `User` (`user_id`) ON DELETE SET NULL;');

        $this->execute('INSERT INTO `WafPositions` SELECT * FROM `Vessel`');

        return true;
    }

    /**
     * @return bool
     */
    public function down()
    {
        echo "m170224_114938_create_positions_tables cannot be reverted.\n";

        return false;
    }
}
