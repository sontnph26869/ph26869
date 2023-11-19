<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MoviesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('movies')->insert([
            'name' => 'Tên phim 1',
            'slug' => 'ten-phim-1',
            'language' => 'Ngôn ngữ 1',
            'poster' => 'poster1.jpg',
            'trailer' => 'trailer1.mp4',
            'director' => 'Đạo diễn 1',
            'actor' => 'Diễn viên 1',
            'manufacturer' => 'Nhà sản xuất 1',
            'duration' => '120 phút',
            'start_date' => now(),
            'view' => 0,
            'description' => 'Mô tả phim 1',
            'country_id' => 1, // ID của quốc gia
            'status' => 1, // Trạng thái phim (ví dụ: 1 cho phim đang chiếu)
        ]);

        // Thêm dữ liệu cho phim khác tại đây

        // Ví dụ thêm phim thứ hai
        DB::table('movies')->insert([
            'name' => 'Tên phim 2',
            'slug' => 'ten-phim-2',
            'language' => 'Ngôn ngữ 2',
            'poster' => 'poster2.jpg',
            'trailer' => 'trailer2.mp4',
            'director' => 'Đạo diễn 2',
            'actor' => 'Diễn viên 2',
            'manufacturer' => 'Nhà sản xuất 2',
            'duration' => '150 phút',
            'start_date' => now(),
            'view' => 0,
            'description' => 'Mô tả phim 2',
            'country_id' => 2, // ID của quốc gia khác
            'status' => 1,
        ]);
    }
}
