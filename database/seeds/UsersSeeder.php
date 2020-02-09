<?php

use Illuminate\Database\Seeder;

use App\Models\{
    User
};

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'userLogin' => 'superadmin',
                'userPass' => 'pass',
                'userEmail' => 'su@shiza.id',
                'levelId' => 1
            ],
            [
                'userLogin' => 'admin',
                'userPass' => 'pass',
                'userEmail' => 'admin@shiza.id',
                'levelId' => 2
            ]
        ];

        foreach($data AS $d) {
            $this->create($d);
        }
    }

    public function create($data) {
        $user = new User;
        $user->userLogin = $data['userLogin'];
        $user->userPass = bcrypt($data['userPass']);
        $user->levelId = $data['levelId'];
        $user->userEmail = $data['userEmail'];
        $user->save();
    }
}
