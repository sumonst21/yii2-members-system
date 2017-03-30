<?php

use yii\db\Schema;
use yii\db\Migration;

use common\models\User;
use backend\models\Admin;

/**
 * Handles inserting default users and admins
 */
class m170324_211444_insert_users_admins extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $user = [
            'username' => 'user',
            'email' => 'user@example.com',
            'password_hash' => Yii::$app->security->generatePasswordHash('123456'),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'created_at' => time(),
            'updated_at' => time()
        ];
        $this->insert('{{%user}}', $user);

        $userProfile = [
            'user_id' => $this->db->getLastInsertID(),
            'firstname' => 'User',
            'created_at' => time(),
            'updated_at' => time()
        ];
        $this->insert('{{%user_profile}}', $userProfile);

        $root = [
            'username' => 'root',
            'firstname' => 'Root',
            'email' => 'root@example.com',
            'password_hash' => Yii::$app->security->generatePasswordHash('123456'),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'role' => Admin::ROLE_ROOT,
            'created_at' => time(),
            'updated_at' => time()
        ];
        $this->insert('{{%admin}}', $root);

        $super = [
            'username' => 'super',
            'firstname' => 'Super',
            'email' => 'super@example.com',
            'password_hash' => Yii::$app->security->generatePasswordHash('123456'),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'role' => Admin::ROLE_SUPER,
            'created_at' => time(),
            'updated_at' => time()
        ];
        $this->insert('{{%admin}}', $super);

        $admin = [
            'username' => 'admin',
            'firstname' => 'Admin',
            'email' => 'admin@example.com',
            'password_hash' => Yii::$app->security->generatePasswordHash('123456'),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'role' => Admin::ROLE_ADMIN,
            'created_at' => time(),
            'updated_at' => time()
        ];
        $this->insert('{{%admin}}', $admin);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $user = $this->db->createCommand("SELECT id FROM {{%user}} WHERE username = :username", ['username' => 'user'])->queryOne();
        $userId = $user['id'];

        if ( $userId === null ) {
            echo "m170324_211444_insert_users_admins down(): error finding user id!\n";
            return false;
        }

        $this->delete('{{%user_profile}}', ['user_id' => $userId]);
        $this->delete('{{%user}}', ['username' => 'user']);
        $this->delete('{{%admin}}', ['username' => 'admin']);
        $this->delete('{{%admin}}', ['username' => 'super']);
        $this->delete('{{%admin}}', ['username' => 'root']);
    }
}
