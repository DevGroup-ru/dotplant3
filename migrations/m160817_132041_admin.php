<?php

use yii\db\Migration;

class m160817_132041_admin extends Migration
{
    public function up()
    {
        $user = new \DevGroup\Users\models\User();
        $user->username = 'admin';
        $user->password = 'admin';
        if ($user->save() === false) {
            print_r($user->errors);
            return false;
        }
        return true;
    }

    public function down()
    {
        $user = \DevGroup\Users\models\User::findOne(['username' => 'admin']);
        if ($user !== null) {
            $user->delete();
        }
    }
}
