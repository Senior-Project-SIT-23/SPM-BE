<?php

use Illuminate\Database\Seeder;
use App\Model\User;
use Illuminate\Support\Arr;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = (array) array(
            [
                'id' => '60130500104',
                'user_name' => 'pepea',
                'department' => 'IT'
            ],
            [
                'id' => '60130500105',
                'user_name' => 'IAMIN',
                'department' => 'IT'
            ],
            [
                'id' => '60130500106',
                'user_name' => '????',
                'department' => 'IT'
            ],
            [
                'id' => '01',
                'user_name' => 'Zompong',
                'department' => ''
            ]
        );

        foreach ($users as $user) {
            $temp_user = new User;
            $temp_user->user_id = Arr::get($user, 'id');
            $temp_user->user_name = Arr::get($user, 'user_name');
            $temp_user->department = Arr::get($user, 'department');
            $temp_user->save();
        }
    }
}
