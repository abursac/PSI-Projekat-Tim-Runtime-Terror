<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlayerClubRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('player_club_request')->insert([
            'player_id' => '1',
            'club_id' => '1',
            'club' => '1',
            'expiry_date' => '2020-05-22'
        ]);

        DB::table('player_club_request')->insert([
            'player_id' => '1',
            'club_id' => '3',
            'club' => '1',
            'expiry_date' => '2020-05-07'
        ]);

        DB::table('player_club_request')->insert([
            'player_id' => '2',
            'club_id' => '3',
            'club' => '1',
            'expiry_date' => '2020-05-07'
        ]);

        DB::table('player_club_request')->insert([
            'player_id' => '3',
            'club_id' => '1',
            'club' => '1',
            'expiry_date' => '2020-05-22'
        ]);

    }
}
