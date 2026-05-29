<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class FollowsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // follower => [following, ...]
        $data = [
            'carlosruiz'    => ['marcosdiaz', 'brokenstrings', 'sarajimenez'],
            'lauragomez'    => ['carlosruiz', 'brokenstrings', 'anatorres'],
            'marcosdiaz'    => ['carlosruiz', 'brokenstrings'],
            'anatorres'     => ['davidmoreno', 'lauragomez'],
            'davidmoreno'   => ['anatorres', 'carlosruiz', 'brokenstrings'],
            'sarajimenez'   => ['brokenstrings', 'marcosdiaz'],
            'pablovega'     => ['carlosruiz', 'marcosdiaz', 'brokenstrings', 'davidmoreno'],
        ];
 
        foreach ($data as $followerUsername => $followingUsernames) {
            $follower = User::where('username', $followerUsername)->first();
 
            if (!$follower) continue;
 
            foreach ($followingUsernames as $followingUsername) {
                $following = User::where('username', $followingUsername)->first();
 
                if (!$following) continue;
 
                $follower->following()->attach($following->id, [
                    'status' => 'accepted',
                ]);
            }
        }
    }
}
