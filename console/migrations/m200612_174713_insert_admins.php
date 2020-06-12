<?php

use yii\db\Migration;

use backend\models\Admin;

/**
 * Class m200612_174713_insert_admins
 */
class m200612_174713_insert_admins extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $time = time();

        $admins = [
            [
                'username' => 'root',
                'firstname' => 'Root',
                'email' => 'root@example.com',
                'password' => '123456',
                'role' => Admin::ROLE_ROOT,
            ],
            [
                'username' => 'super',
                'firstname' => 'Super',
                'email' => 'super@example.com',
                'password' => '123456',
                'role' => Admin::ROLE_SUPER,
            ],
            [
                'username' => 'admin',
                'firstname' => 'Admin',
                'email' => 'admin@example.com',
                'password' => '123456',
                'role' => Admin::ROLE_ADMIN,
            ],
        ];

        foreach ( $admins as $admin )
        {
            $data = [
                'username' => $admin['username'],
                'firstname' => $admin['firstname'],
                'email' => $admin['email'],
                'password_hash' => Yii::$app->security->generatePasswordHash($admin['password']),
                'auth_key' => Yii::$app->security->generateRandomString(),
                'role' => $admin['role'],
                'created_at' => $time,
                'updated_at' => $time
            ];

            $this->insert('{{%admin}}', $data);
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200612_174713_insert_admins cannot be reverted.\n";

        return false;
    }
}
