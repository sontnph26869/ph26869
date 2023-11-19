<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateRoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $room = Room::create([
            'name' => 'A101',
            'cinema_id' => '1',
            'room_type_id' => '1',
            'description' => '1',
            'status' => '1',
        ]);
        $room_type = RoomType::create([
            'name' => 'vip',
            'slug' => 'vip',
            'image' => 'url',
            'description' => '1',
            'status' => '1',
        ]);
    }
}
