<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Cinema;
use Illuminate\Support\Facades\Log;
use App\Models\Province;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Cart;




class BookControllerClient extends Controller
{
    //
    public function list()
    {
        $books = Book::all();
        $genres = Genre::all();
        $currentDate = Carbon::now()->format('d/m/Y'); // Lấy ngày hiện tại
        $sevenDaysLater = Carbon::now()->addDays(7)->format('d/m/Y'); // Lấy ngày 7 ngày sau
        return view('client.books.book-list', compact('books', 'genres', 'currentDate', 'sevenDaysLater'));
    }
    public function detail($slug, $id)
    {
        $book = Book::find($id);
        if (auth()->check()) {
            $userID = auth()->user()->id;
            $images = $book->images;

            return view('client.books.book-detail', compact('book', 'images'));
        }
        if ($book) {
            return view('client.books.book-detail', compact('book'));
        }
    }

    public function search(Request $request)
    {
        try {
            $query = Book::query();

            if ($request->filled('start_date')) {
                $startDate = $request->input('start_date');
                $startDate = Carbon::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
                $query->whereDate('start_date', $startDate);
            }

            if ($request->filled('search_query')) {
                $searchQuery = $request->input('search_query');
                $query->where('name', 'like', "%$searchQuery%");
            }

            $movies = $query->get();

            return view('client.movies.partial-movies', compact('movies'));
        } catch (\Exception $e) {
            Log::error('Error during search: ' . $e->getMessage());
            // Xử lý exception ở đây nếu cần
        }
    }


    public function filter(Request $request)
    {
        try {
            $selectedGenres = $request->input('genres');

            $books = Book::whereHas('genres', function ($query) use ($selectedGenres) {
                $query->whereIn('genre_id', $selectedGenres);
            })->select('id', 'name', 'poster')->get();

            return view('client.movies.partial-movies', compact('books'));
        } catch (\Exception $e) {
            Log::error('Lỗi trong quá trình lọc: ' . $e->getMessage());
            // Xử lý exception ở đây
        }
    }

    // app/Http/Controllers/Client/BookControllerClient.php


    // ... (other imports)



    public function addToCart(Request $request, $id)
    {
        $user = auth()->user();

        // Find the cart item or create a new one
        $cartItem = Cart::firstOrNew([
            'user_id' => $user->id,
            'book_id' => $id,
        ]);

        // If the cart item already exists, increment the quantity
        if ($cartItem->exists) {
            $cartItem->increment('quantily');
        } else {
            // If the cart item does not exist, set the default values
            $cartItem->quantily = 1;
            $cartItem->save();
        }
        toastr()->success('Thêm vào giỏ hàng thành công!', 'success');
        return redirect()->route('book.danh-sach');
    }


    public function viewCart()
    {
        $user = auth()->user();
        $cartItems = Cart::where('user_id', $user->id)->with('book')->get();

        return view('client.cart.view', compact('cartItems'));
    }

    public function updateCart(Request $request)
    {
        // Validate the form data
        $request->validate([
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1', // Additional validation rules for quantities
        ]);

        // Get the submitted quantities
        $quantities = $request->input('quantities');
        // Loop through each item in the cart and update the quantity
        foreach ($quantities as $itemId => $quantily) {
            // You may need to adjust this logic based on your actual cart implementation
            $cartItem = Cart::find($itemId);

            if ($cartItem) {
                // Assuming you have a 'quantity' column in your cart items table
                $cartItem->update(['quantily' => $quantily]);
            }
        }

        // You can add a success message or other logic here

        // Redirect back to the cart page or wherever you want
        return redirect()->route('cart.view'); // Adjust the route name accordingly
    }
}
