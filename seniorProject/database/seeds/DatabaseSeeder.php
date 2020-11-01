<?php

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
        $this->call(StudentsSeeder::class);
        $this->call(TeachersSeeder::class);
        $this->call(AASeeder::class);
        $this->call(RubricSeeder::class);
        $this->call(AssignmentSeeder::class);
        $this->call(AnnouncementSeeder::class);
        $this->call(NotificationSeeder::class);
    }
}
