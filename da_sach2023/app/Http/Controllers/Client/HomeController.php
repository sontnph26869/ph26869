<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\DB;
use App\Models\moviefavorite;
use App\Models\User;
use App\Models\Genre;
use App\Models\Cinema;
use App\Models\Province;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $userID = auth()->user()->id;
            $books = Book::all();
            $currentDate = Carbon::now()->format('d/m/Y'); // Lấy ngày hiện tại
            $sevenDaysLater = Carbon::now()->addDays(7)->format('d/m/Y'); // Lấy ngày 7 ngày sau


            return view('client.index', compact('books', 'currentDate', 'sevenDaysLater', 'userID'));
        }

        $books = Book::all();
       

        $currentDate = Carbon::now()->format('d/m/Y'); // Lấy ngày hiện tại
        $sevenDaysLater = Carbon::now()->addDays(7)->format('d/m/Y'); // Lấy ngày 7 ngày sau


        return view('client.index', compact('books','currentDate', 'sevenDaysLater'));
    }
}
