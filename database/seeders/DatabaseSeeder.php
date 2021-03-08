<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /**
         *  User Types Creations
         */
       $patient_type =  \App\Models\UserType::create(['description'=>'Patient']);
       $doctor_type =  \App\Models\UserType::create(['description'=>'Doctor']);
       $admin_type = \App\Models\UserType::create(['description'=>'Admin']);

        /**
         * Patient User
         */
        \App\Models\User::create([
            'email'=>'jonh.patient@email.com',
            'name' => 'Jonh Patient',
            'password'=> bcrypt('secret'),
            'user_type_id' => $patient_type->id
        ]);

        /**
         * Doctor User
         */
        \App\Models\User::create([
            'email'=>'jonh.doctor@email.com',
            'name' => 'Jonh Doctor',
            'password'=> bcrypt('secret'),
            'user_type_id' => $doctor_type->id
        ]);

        /**
         * Admin User
         */
        \App\Models\User::create([
            'email'=>'jonh.admin@email.com',
            'name' => 'Jonh Admin',
            'password'=> bcrypt('secret'),
            'user_type_id' =>  $admin_type->id
        ]);
    }
}
