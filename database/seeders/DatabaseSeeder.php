<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class DatabaseSeeder
 * 
 * @package Database\Seeders
 */
class DatabaseSeeder extends Seeder
{
    protected $toTruncate = ['users'];

    public function run()
    {
        Model::unguard();

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        foreach ($this->toTruncate as $table) {
            DB::table($table)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->call(UsersTableSeeder::class);

        Model::reguard();
    }
}
