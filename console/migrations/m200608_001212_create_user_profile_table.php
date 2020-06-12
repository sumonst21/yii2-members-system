<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_profile}}`.
 */
class m200608_001212_create_user_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_profile}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->unique(),
            'firstname' => $this->string(30),
            'lastname' => $this->string(30),
            'bio' => $this->text()->defaultValue(null),

            'receive_emails' => $this->boolean()->defaultValue(1),
            'share_details_team' => $this->boolean()->defaultValue(1),
            'share_details_public' => $this->boolean()->defaultValue(0),

            'phone' => $this->string(50)->defaultValue(null),
            'skype' => $this->string(50)->defaultValue(null),
            'address1' => $this->string(100)->defaultValue(null),
            'address2' => $this->string(100)->defaultValue(null),
            'city' => $this->string(100)->defaultValue(null),
            'state' => $this->string(100)->defaultValue(null),
            'zip' => $this->string(20)->defaultValue(null),
            'country' => $this->string(100)->defaultValue(null),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fk_user_profile_user_id', '{{%user_profile}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_user_profile_user_id', '{{%user_profile}}');
        $this->dropTable('{{%user_profile}}');
    }
}
