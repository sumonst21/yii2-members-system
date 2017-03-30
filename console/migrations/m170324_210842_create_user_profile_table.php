<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_profile`.
 */
class m170324_210842_create_user_profile_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
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
            'bio' => $this->text(),

            'receive_emails' => $this->boolean()->defaultValue(1),
            'share_details' => $this->boolean()->defaultValue(1),

            'phone' => $this->string(50),
            'skype' => $this->string(50),
            'address1' => $this->string(100),
            'address2' => $this->string(100),
            'city' => $this->string(100),
            'state' => $this->string(100),
            'zip' => $this->string(20),
            'country' => $this->string(100),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addForeignKey('fk_user_profile_user_id', '{{%user_profile}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_user_profile_user_id', '{{%user_profile}}');
        $this->dropTable('{{%user_profile}}');
    }
}
