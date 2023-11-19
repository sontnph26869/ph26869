<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use App\Models\Book;
use App\Models\Province;
use App\Models\Room;
use App\Models\ShowTime;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MovieTicketPlanController extends Controller
{


    public function index(Request $request, $id, $slug)
    {
        $selectedDate = $request->input('selected_date'); // Lấy ngày đã chọn từ query parameter
        $selectedProvinceId = $request->input('province_id'); // Lấy province_id từ query parameter
        $selectedCinemaId = $request->input('cinema_id'); // Lấy cinema_id từ query parameter

        $movie = Book::where('id', $id)->where('slug', $slug)->first();

        if ($movie) {
      
            


            if (!$selectedDate) {
                $selectedDate = Carbon::now()->format('Y-m-d'); // Nếu không có ngày được chọn, sử dụng ngày hiện tại
            }

            $currentDateTime = Carbon::now(); // Thời gian hiện tại



      
            }

            return view('client.books.movie-ticket-plan', compact( 'movie'));
        }
    }

