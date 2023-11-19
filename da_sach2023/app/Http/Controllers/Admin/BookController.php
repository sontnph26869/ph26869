<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Models\Genre;
use App\Models\Book;
use App\Models\BookGenre;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BookRequest $request)
    {
//        $moviesWithGenres = Movie::with('genres')->get();
        $query = Book::query();
        // Tìm kiếm theo name
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }
        // Lọc theo status
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status == 1 || $status == 0) {
                $query->where('status', $status);
            } else if ($status == 'all') {
                $query->get();
            }
        }
        $books = $query->orderBy('id', 'DESC')->paginate(5);

        return view('admin.book.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genres = Genre::all();
        return view('admin.book.add', compact('genres'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $imageNames = [];
            if ($request->hasFile('poster') && $request->file('poster')->isValid()) {
                $request->poster = uploadFile('image', $request->file('poster'));
            } else {
                $request->poster = null;
            }
            if (!$request->slug) {
                $request->slug = Str::slug($request->name);
            }
            $book = new Book();
            $book->fill($request->all());
            // dd($request->genre_id);
            $book->save();
            if (empty($request->genre_id)) {
                // Trường hợp khi mảng danh mục rỗng
                $book_genre = new BookGenre();
                $book_genre->book_id = $book->id;
                // dd($post_type_posts->post_id);
                $book_genre->genre_id ==null;
                
            } else {
                // Trường hợp khi mảng danh mục không rỗng
                foreach ($request->genre_id as $genre_id) {
                    $book_genre = new BookGenre();
                    $book_genre->book_id = $book->id;
                    $book_genre->genre_id = $genre_id;
                    $book_genre->save();
                }
            }
            
                toastr()->success('Thêm mới sách thành công', 'success');
                return redirect()->route('book.index');
            
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] === 1062) { // Lỗi duplicate entry
                return redirect()->back()->withErrors(['slug' => 'Slug đã bị trùng lặp. Vui lòng sửa đường dẫn']);
            }
        }
    }
    


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
    {
        $genres = Genre::all();
        $book = Book::find($id);
        $book_genre =  BookGenre::where('book_id', $id)->get(); 
        return view('admin.book.edit', compact('genres', 'book','book_genre'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
 function update(Request $request, $id){
    {
        try {
            $book = Book::find($id);
            
            // Validate and update the slug
            if (!$request->slug) {
                $params['slug'] = Str::slug($request->name);
            }
    
            $params = $request->except('_token', 'poster');
            
            // Handle poster image
            if ($request->hasFile('poster') && $request->file('poster')->isValid()) {
                // Delete the old poster file
                if ($book->poster) {
                    Storage::delete('/public/' . $book->poster);
                }
    
                // Upload and save the new poster
                $params['poster'] = uploadFile('image', $request->file('poster'));
            }
    
            // Update the book record
            $book->update($params);
    
            // Sync the associated genres
            if (empty($request->genre_id)) {
                // Trường hợp khi mảng danh mục rỗng
                $book_genre = new BookGenre();
                $book_genre->book_id = $book->id;
                // dd($post_type_posts->post_id);
                $book_genre->genre_id ==null;
                
            } else {
                // Trường hợp khi mảng danh mục không rỗng
                foreach ($request->genre_id as $genre_id) {
                    $book_genre = new BookGenre();
                    $book_genre->book_id = $book->id;
                    $book_genre->genre_id = $genre_id;
                    $book_genre->save();
                }
            }
    
            toastr()->success('Cập nhật sách thành công!', 'success');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] === 1062) {
                return redirect()->back()->withErrors(['slug' => 'Slug đã bị trùng lặp. Vui lòng nhập tên khác']);
            }
            toastr()->error('Có lỗi xảy ra!', 'error');
        }
    
        return redirect()->route('book.index');
    }
       return redirect()->route('book.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        if ($id) {
            $deleted = Book::where('id', $id)->delete();
            if ($deleted) {
                toastr()->success('Xóa phim thành công!', 'success');
            } else {
                toastr()->error('Có lỗi xảy ra', 'error');
            }
            return redirect()->route('book.index');
        }
    }

    public
    function trash(BookRequest $request)
    {
        $deleteItems = Book::onlyTrashed();

        // Tìm kiếm theo name trong trash
        if ($request->has('search')) {
            $search = $request->input('search');
            $deleteItems->where('name', 'like', '%' . $search . '%');
        }
        // Lọc theo status trong trash
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status == 0 || $status == 1) {
                $deleteItems->where('status', $status);
            } else if ($status == 'all') {
                $deleteItems->get();
            }
        }

        $deleteItems = $deleteItems->orderBy('id', 'DESC')->paginate(5);
        return view('admin.book.trash', compact('deleteItems'));
    }

    public
    function updateStatus($id, Request $request)
    {
        $item = Book::find($id);

        if (!$item) {
            return response()->json(['message' => 'Không tìm thấy mục'], 404);
        }
        $newStatus = $request->input('status');
        $item->status = $newStatus;
        $item->save();
        return response()->json(['message' => 'Cập nhật trạng thái thành công'], 200);
    }

    public
    function restore($id)
    {
        if ($id) {
            $restore = Book::withTrashed()->find($id);
            $restore->restore();
            toastr()->success('Khôi phục phim thành công', 'success');
            return redirect()->route('book.trash');
        }
    }

    public
    function delete($id)
    {
        if ($id) {
            $deleted = Book::onlyTrashed()->find($id);
            $deleted->forceDelete();
            toastr()->success('Xóa vĩnh viễn phim thành công', 'success');
            return redirect()->route('book.trash');
        }
    }

    public
    function deleteAll(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            Book::whereIn('id', $ids)->delete();
            toastr()->success('Thành công xoá các phim đã chọn');
        } else {
            toastr()->warning('Không tìm thấy các phim đã chọn');
        }

    }

    public
    function restoreSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $voucher = Book::withTrashed()->whereIn('id', $ids);
            $voucher->restore();
            toastr()->success('Thành công', 'Thành công khôi phục phim');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các phim đã chọn');
        }
        return redirect()->route('book.trash');
    }

    public
    function permanentlyDeleteSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $voucher = Book::withTrashed()->whereIn('id', $ids);
            $voucher->forceDelete();
            toastr()->success('Thành công', 'Thành công xoá vĩnh viễn phim');

        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các phim đã chọn');
        }
        return redirect()->route('book.trash');
    }
}
