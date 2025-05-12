<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Entities\User;

class ExampleUser extends Seeder
{
    public function run()
    {
        
        // Load settings
        helper('setting');

        // Get the User Provider (UserModel by default)
        $users = auth()->getProvider();

        $random_number = rand(1000, 9999);


        // Add user
        $user = new User([
            'username' => 'example-'. $random_number,
            'email'    => 'example-'.$random_number.'@youdomain.tld',
            'password' => 'top-secret'
        ]);

        $users->save($user);

        // Get latest user id
        $user_id = $users->getInsertID();

        // To get the complete user object with ID, we need to get from the database
        $user = $users->findById($user_id);

        // Add to default group
        $users->addToDefaultGroup($user);

    }
}