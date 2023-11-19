<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\PostTypeController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\BookController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Auth\AuthAdminController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\VouchersController;
use App\Http\Controllers\Client\BookingController;
use App\Http\Controllers\Client\PostController;
use App\Http\Controllers\Client\BookControllerClient;
use App\Http\Controllers\Client\CheckoutControllerClient;

use App\Http\Controllers\Client\ProfileController;
Route::get('/', [HomeController::class, 'index'])->name('index');

// sách
Route::prefix('phim')->group(function () {
    Route::get('/danh-sach', [BookControllerClient::class, 'list'])->name('book.danh-sach');
    Route::get('/{slug}/{id}', [BookControllerClient::class, 'detail'])->name('book.detail');
    Route::post('/filter', [BookControllerClient::class, 'filter'])->name('movie.filter')->middleware('web');
    Route::post('/search', [BookControllerClient::class, 'search'])->name('movie.search');
});

// routes/web.php

Route::middleware(['auth'])->group(function () {
    Route::prefix('cart')->group(function () {
        Route::get('/',[BookControllerClient::class,'viewCart'] )->name('cart.view');
        Route::get('/add/{id}', [BookControllerClient::class,'addToCart'] )->name('cart.add');
        Route::post('/cart/update', [BookControllerClient::class, 'updateCart'])->name('cart.update');
        
        });
});

//checkout
Route::post('/checkout', [CheckoutControllerClient::class,'index'])->name('checkout');
// Route::post('/checkout/store', [CheckoutControllerClient::class,'store'])->name('checkout.store');

Route::middleware(['auth'])->group(function () {
    Route::post('/checkout/store', [CheckoutControllerClient::class,'store'])->name('checkout.store');
});
// danh mục mã giảm giá trang người dùng
Route::prefix('vouchers')->group(function () {
    Route::get('/voucher-list', [VouchersController::class, 'vouchers'])->name('home.voucher.list');
    Route::get('/voucher-detail/{id}', [VouchersController::class, 'detailVouchers'])->name('home.voucher.detail');
    Route::post('/apllyVouchers', [VouchersController::class, 'apllyVouchers'])->name('home.voucher.apllyVouchers');

});

Route::group(['middleware' => 'guest'], function () {
    Route::match(['GET', 'POST'], '/login', [App\Http\Controllers\Auth\AuthClientController::class, 'login'])->name('login');
    Route::match(['GET', 'POST'], '/register', [App\Http\Controllers\Auth\AuthClientController::class, 'register'])->name('register');
    Route::match(['GET', 'POST'], '/forgot-password', [App\Http\Controllers\Auth\AuthClientController::class, 'forgotPassword'])->name('forgotPassword');
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('food')->group(function () {
        Route::match(['GET', 'POST'], '/', [FoodController::class, 'food'])->name('food');
        Route::get('/get-food-by-type/{foodTypeId}', [FoodController::class, 'getFoodByType']);
    });
});


 


    // Spatie
    Route::match(['GET', 'POST'], '/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    //blogs
    Route::get('bai-viet', [PostController::class, 'index'])->name('blog');
    Route::get('/bai-viet-chi-tiet/{slug}/{id}', [PostController::class, 'show'])->name('blog-detail');
    Route::post('them-binh-luan-bai-viet', [PostController::class, 'store'])->name('blog-cmt.store');
    Route::post('tra-loi-binh-luan-bai-viet', [PostController::class, 'repStore'])->name('replie.repStore');



////
//profile
Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
Route::get('/lich-su-giao-dich-ve', [ProfileController::class, 'transaction_history'])->name('profile.history');
Route::get('/chi-tiet/lich-su-giao-dich-ve/{id}', [ProfileController::class, 'transaction_history_detail'])->name('transaction.history.detail');
Route::match(['GET', 'POST'], '/change-password', [ProfileController::class, 'change_password'])->name('profile.changePassword');
Route::match(['GET', 'POST'], '/edit-profile', [ProfileController::class, 'edit_profile'])->name('profile.edit');
Route::match(['GET', 'POST'], '/points', [ProfileController::class, 'points'])->name('profile.points');
Route::match(['GET', 'POST'], '/member', [ProfileController::class, 'member'])->name('profile.member');


// route cua google
Route::get('auth/google', [SocialController::class, 'signInwithGoogle'])->name('login_google');
Route::get('callback/google', [SocialController::class, 'callbackToGoogle']);
// ket thuc route google
// route logout
Route::get('logout', [SocialController::class, 'logout'])->name('logout');

// ket thuc route mang xa hoi
Route::prefix('admin')->group(function () {
    //login
    Route::match(['GET', 'POST'], '/login', [AuthAdminController::class, 'login'])->name('login.admin');
    //dashboard
    Route::match(['GET', 'POST'], '/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    //role
    Route::prefix('role')->group(function () {
        Route::match(['GET', 'POST'], '/', [RoleController::class, 'index'])->name('role.list');
        Route::match(['GET', 'POST'], '/store', [RoleController::class, 'store'])->name('role.add');
        Route::match(['GET', 'POST'], '/create', [RoleController::class, 'create'])->name('role.form-add');
        Route::match(['GET', 'POST'], '/edit/{id}', [RoleController::class, 'update'])->name('role.update');
        Route::match(['GET', 'POST'], '/update/{id}', [RoleController::class, 'show'])->name('role.form-update');
        Route::match(['GET', 'POST'], '/destroy/{id}', [RoleController::class, 'destroy'])->name('role.delete');
        Route::match(['GET', 'POST'], '/deleteAll', [RoleController::class, 'deleteAll'])->name('role.delete-all');
        Route::match(['GET', 'POST'], '/bin', [RoleController::class, 'list_bin'])->name('bin.list-role');
        Route::match(['GET', 'POST'], '/restore/{id}', [RoleController::class, 'restore_bin'])->name('bin.restore-role');
        Route::match(['GET', 'POST'], '/restoreSelected', [RoleController::class, 'restore_bin_all'])->name('bin.restore-role-all');
        Route::match(['GET', 'POST'], '/delete/{id}', [RoleController::class, 'delete_bin'])->name('bin.delete-role');
        Route::match(['GET', 'POST'], '/permanentlyDeleteSelected', [RoleController::class, 'delete_bin_all'])->name('bin.delete-role-all');
    });
    //permission
    Route::prefix('permission')->group(function () {
        Route::match(['GET', 'POST'], '/', [PermissionController::class, 'index'])->name('permission.list');
        Route::match(['GET', 'POST'], '/store', [PermissionController::class, 'store'])->name('permission.add');
        Route::match(['GET', 'POST'], '/create', [PermissionController::class, 'create'])->name('permission.form-add');
        Route::match(['GET', 'POST'], '/edit/{id}', [PermissionController::class, 'update'])->name('permission.update');
        Route::match(['GET', 'POST'], '/update/{id}', [PermissionController::class, 'show'])->name('permission.form-update');
        Route::match(['GET', 'POST'], '/destroy/{id}', [PermissionController::class, 'destroy'])->name('permission.delete');
        Route::match(['GET', 'POST'], '/deleteAll', [PermissionController::class, 'deleteAll'])->name('permission.delete-all');
        Route::match(['GET', 'POST'], '/bin', [PermissionController::class, 'list_bin'])->name('bin.list-permission');
        Route::match(['GET', 'POST'], '/restore/{id}', [PermissionController::class, 'restore_bin'])->name('bin.restore-permission');
        Route::match(['GET', 'POST'], '/restoreSelected', [PermissionController::class, 'restore_bin_all'])->name('bin.restore-permission-all');
        Route::match(['GET', 'POST'], '/delete/{id}', [PermissionController::class, 'delete_bin'])->name('bin.delete-permission');
        Route::match(['GET', 'POST'], '/permanentlyDeleteSelected', [PermissionController::class, 'delete_bin_all'])->name('bin.delete-permission-all');
    });
   


    /*
     * Category Blog
     */
    Route::prefix('post-type')->group(function () {
        Route::get('/', [PostTypeController::class, 'index'])->name('post-type.index');
        Route::get('/create', [PostTypeController::class, 'create'])->name('post-type.add');
        Route::post('/store', [PostTypeController::class, 'store'])->name('post-type.store');
        Route::get('/edit/{id}', [PostTypeController::class, 'edit'])->name('post-type.edit');
        Route::post('/update/{id}', [PostTypeController::class, 'update'])->name('post-type.update');
        Route::get('/destroy/{id}', [PostTypeController::class, 'destroy'])->name('post-type.destroy');
        Route::get('/trash', [PostTypeController::class, 'trash'])->name('post-type.trash');
        Route::get('/restore/{id}', [PostTypeController::class, 'restore'])->name('post-type.restore');
        Route::get('/delete/{id}', [PostTypeController::class, 'delete'])->name('post-type.delete');
        Route::post('/update-status/{id}', [PostTypeController::class, 'updateStatus'])->name('post-type.updateStatus');
        Route::post('/deleteAll', [PostTypeController::class, 'deleteAll'])->name('post-type.deleteAll');
        Route::post('/permanentlyDeleteSelected', [PostTypeController::class, 'permanentlyDeleteSelected'])->name('post-type.permanentlyDeleteSelected');
        Route::post('/restoreSelected', [PostTypeController::class, 'restoreSelected'])->name('post-type.restoreSelected');
    });
 

    //route bài viết
    Route::prefix('post')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\Post\PostController::class, 'index'])->name('post.index');
        Route::get('/create', [App\Http\Controllers\Admin\Post\PostController::class, 'create'])->name('post.add');
        Route::post('/store', [App\Http\Controllers\Admin\Post\PostController::class, 'store'])->name('post.store');
        Route::post('/status/{id}', [App\Http\Controllers\Admin\Post\PostController::class, 'updateStatus']);
        Route::post('/deleteAll', [App\Http\Controllers\Admin\Post\PostController::class, 'deleteAll'])->name('post.deleteAll');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\Post\PostController::class, 'edit'])->name('post.edit');
        Route::get('/show/{id}', [App\Http\Controllers\Admin\Post\PostController::class, 'show'])->name('post.show');
        Route::put('/update/{id}', [App\Http\Controllers\Admin\Post\PostController::class, 'update'])->name('post.update');
        // Route::post('/destroy/{id}', [App\Http\Controllers\Admin\Post\PostController::class, 'destroy'])->name('post.destroy');
        Route::get('/destroy/{id}', [App\Http\Controllers\Admin\Post\PostController::class, 'destroy'])->name('post.destroy');
        Route::get('/trash', [App\Http\Controllers\Admin\Post\PostController::class, 'trash'])->name('post.trash');
        Route::post('/permanentlyDeleteSelected', [App\Http\Controllers\Admin\Post\PostController::class, 'permanentlyDeleteSelected'])->name('post.permanentlyDeleteSelected');
        Route::post('/restoreSelected', [App\Http\Controllers\Admin\Post\PostController::class, 'restoreSelected'])->name('post.restoreSelected');

        Route::get('/restore/{id}', [App\Http\Controllers\Admin\Post\PostController::class, 'restore'])->name('post.restore');
        Route::get('/force-delete/{id}', [App\Http\Controllers\Admin\Post\PostController::class, 'forceDelete'])->name('post.forceDelete');
    });
    ///

    Route::middleware(['auth'])->group(function () {
      
          //// Bình luận bài viết
          Route::prefix('comment')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\Post\CommentPostController::class, 'index'])->name('comment.index');
            // Route::get('/create', [App\Http\Controllers\Admin\Post\PostController::class, 'create'])->name('post.add');
            // Route::post('/store', [App\Http\Controllers\Admin\Post\PostController::class, 'store'])->name('post.store');
            Route::post('/status/{id}', [App\Http\Controllers\Admin\Post\CommentPostController::class, 'updateStatus']);
            Route::post('/deleteAll', [App\Http\Controllers\Admin\Post\CommentPostController::class, 'deleteAll'])->name('comment.deleteAll');
            // Route::get('/edit/{id}', [App\Http\Controllers\Admin\Post\PostController::class, 'edit'])->name('post.edit');
            // Route::get('/show/{id}', [App\Http\Controllers\Admin\Post\PostController::class, 'show'])->name('post.show');
            // Route::put('/update/{id}', [App\Http\Controllers\Admin\Post\PostController::class, 'update'])->name('post.update');
            // Route::post('/destroy/{id}', [App\Http\Controllers\Admin\Post\PostController::class, 'destroy'])->name('post.destroy');
            Route::get('/destroy/{id}', [App\Http\Controllers\Admin\Post\CommentPostController::class, 'destroy'])->name('comment.destroy');
            Route::get('/trash',  [App\Http\Controllers\Admin\Post\CommentPostController::class, 'trash'])->name('comment.trash');
            Route::post('/permanentlyDeleteSelected', [App\Http\Controllers\Admin\Post\CommentPostController::class, 'permanentlyDeleteSelected'])->name('comment.permanentlyDeleteSelected');
           Route::post('/restoreSelected', [App\Http\Controllers\Admin\Post\CommentPostController::class, 'restoreSelected'])->name('comment.restoreSelected');

            Route::get('/restore/{id}',  [App\Http\Controllers\Admin\Post\CommentPostController::class, 'restore'])->name('comment.restore');
            Route::get('/force-delete/{id}', [App\Http\Controllers\Admin\Post\CommentPostController::class, 'forceDelete'])->name('comment.forceDelete');
        });


        //
    });
          


    Route::middleware(['auth'])->group(function () {
        // ///// trả lời bình luận
        Route::prefix('reply')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\Post\ReplyController::class, 'index'])->name('reply.index');
            Route::post('/status/{id}', [App\Http\Controllers\Admin\Post\ReplyController::class, 'updateStatus']);
            Route::post('/deleteAll', [App\Http\Controllers\Admin\Post\ReplyController::class, 'deleteAll'])->name('reply.deleteAll');
            Route::get('/destroy/{id}', [App\Http\Controllers\Admin\Post\ReplyController::class, 'destroy'])->name('reply.destroy');
            Route::get('/trash',  [App\Http\Controllers\Admin\Post\ReplyController::class, 'trash'])->name('reply.trash');
            Route::post('/permanentlyDeleteSelected', [App\Http\Controllers\Admin\Post\ReplyController::class, 'permanentlyDeleteSelected'])->name('reply.permanentlyDeleteSelected');
           Route::post('/restoreSelected', [App\Http\Controllers\Admin\Post\ReplyController::class, 'restoreSelected'])->name('reply.restoreSelected');
            Route::get('/restore/{id}',  [App\Http\Controllers\Admin\Post\ReplyController::class, 'restore'])->name('reply.restore');
            Route::get('/force-delete/{id}', [App\Http\Controllers\Admin\Post\ReplyController::class, 'forceDelete'])->name('reply.forceDelete');
        });

        // ///////////
    });
        
    /*
     * Book Genre
     */
    Route::prefix('genre')->group(function () {
        Route::get('/', [GenreController::class, 'index'])->name('genre.index');
        Route::get('/create', [GenreController::class, 'create'])->name('genre.add');
        Route::post('/store', [GenreController::class, 'store'])->name('genre.store');
        Route::get('/edit/{id}', [GenreController::class, 'edit'])->name('genre.edit');
        Route::post('/update/{id}', [GenreController::class, 'update'])->name('genre.update');
        Route::get('/destroy/{id}', [GenreController::class, 'destroy'])->name('genre.destroy');
        Route::get('/trash', [GenreController::class, 'trash'])->name('genre.trash');
        Route::get('/restore/{id}', [GenreController::class, 'restore'])->name('genre.restore');
        Route::get('/delete/{id}', [GenreController::class, 'delete'])->name('genre.delete');
        Route::post('/update-status/{id}', [GenreController::class, 'updateStatus'])->name('genre.updateStatus');
        Route::post('/deleteAll', [GenreController::class, 'deleteAll'])->name('genre.deleteAll');
        Route::post('/permanentlyDeleteSelected', [GenreController::class, 'permanentlyDeleteSelected'])->name('genre.permanentlyDeleteSelected');
        Route::post('/restoreSelected', [GenreController::class, 'restoreSelected'])->name('genre.restoreSelected');
    });
    /*
     * Book
     */
    Route::prefix('book')->group(function () {
        Route::get('/', [BookController::class, 'index'])->name('book.index');
        Route::get('/create', [BookController::class, 'create'])->name('book.add');
        Route::post('/store', [BookController::class, 'store'])->name('book.store');
        Route::get('/edit/{id}', [BookController::class, 'edit'])->name('book.edit');
        Route::get('/show/{id}', [BookController::class, 'show'])->name('book.show');
        Route::post('/update/{id}', [BookController::class, 'update'])->name('book.update');
        Route::get('/destroy/{id}', [BookController::class, 'destroy'])->name('book.destroy');
        Route::get('/trash', [BookController::class, 'trash'])->name('book.trash');
        Route::post('/update-status/{id}', [BookController::class, 'updateStatus'])->name('book.updateStatus');
        Route::get('/restore/{id}', [BookController::class, 'restore'])->name('book.restore');
        Route::get('/delete/{id}', [BookController::class, 'delete'])->name('book.delete');
        Route::post('/deleteAll', [BookController::class, 'deleteAll'])->name('book.deleteAll');
        Route::post('/permanentlyDeleteSelected', [BookController::class, 'permanentlyDeleteSelected'])->name('book.permanentlyDeleteSelected');
        Route::post('/restoreSelected', [BookController::class, 'restoreSelected'])->name('book.restoreSelected');
    });



 
    // mã giảm giá
    Route::prefix('voucher')->group(function () {
        Route::get('/', [VoucherController::class, 'index'])->name('voucher.index');
        Route::match(['GET', 'POST'], '/store', [VoucherController::class, 'store'])->name('voucher.store');
        Route::match(['GET', 'POST'], '/update/{id}', [VoucherController::class, 'update'])->name('voucher.update');
        Route::get('/destroy/{id}', [VoucherController::class, 'destroy'])->name('voucher.destroy');
        Route::post('/deleteAll', [VoucherController::class, 'deleteAll'])->name('voucher.deleteAll');
        Route::post('/update-status/{id}', [VoucherController::class, 'updateStatus'])->name('voucher.updateStatus');
        Route::get('/trash', [VoucherController::class, 'trash'])->name('voucher.trash');
        Route::get('/permanentlyDelete/{id}', [VoucherController::class, 'permanentlyDelete'])->name('voucher.permanentlyDelete');
        Route::post('/permanentlyDeleteSelected', [VoucherController::class, 'permanentlyDeleteSelected'])->name('voucher.permanentlyDeleteSelected');
        Route::post('/restoreSelected', [VoucherController::class, 'restoreSelected'])->name('voucher.restoreSelected');
        Route::get('/restore/{id}', [VoucherController::class, 'restore'])->name('voucher.restore');
    });

    ////

    // route logo
    Route::prefix('logo')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\Logo\LogoController::class, 'index'])->name('logo.index');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\Logo\LogoController::class, 'edit'])->name('logo.edit');
        Route::put('/update/{id}', [App\Http\Controllers\Admin\Logo\LogoController::class, 'update'])->name('logo.update');
    });

    //route slider
    Route::prefix('slider')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\Slider\SliderController::class, 'index'])->name('slider.index');
        Route::get('/create', [App\Http\Controllers\Admin\Slider\SliderController::class, 'create'])->name('slider.add');
        Route::post('/store', [App\Http\Controllers\Admin\Slider\SliderController::class, 'store'])->name('slider.store');
        Route::post('/status/{id}', [App\Http\Controllers\Admin\Slider\SliderController::class, 'updateStatus']);
        Route::post('/deleteAll', [App\Http\Controllers\Admin\Slider\SliderController::class, 'deleteAll'])->name('slider.deleteAll');
        Route::post('/permanentlyDeleteSelected', [App\Http\Controllers\Admin\Slider\SliderController::class, 'permanentlyDeleteSelected'])->name('slider.permanentlyDeleteSelected');
        Route::post('/restoreSelected', [App\Http\Controllers\Admin\Slider\SliderController::class, 'restoreSelected'])->name('slider.restoreSelected');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\Slider\SliderController::class, 'edit'])->name('slider.edit');
        Route::get('/show/{id}', [App\Http\Controllers\Admin\Slider\SliderController::class, 'show'])->name('slider.show');
        Route::put('/update/{id}', [App\Http\Controllers\Admin\Slider\SliderController::class, 'update'])->name('slider.update');
        // Route::slider('/destroy/{id}', [App\Http\Controllers\Admin\Slider\SliderController::class, 'destroy'])->name('slider.destroy');
        Route::get('/destroy/{id}', [App\Http\Controllers\Admin\Slider\SliderController::class, 'destroy'])->name('slider.destroy');
        Route::get('/trash', [App\Http\Controllers\Admin\Slider\SliderController::class, 'trash'])->name('slider.trash');
        Route::get('/restore/{id}', [App\Http\Controllers\Admin\Slider\SliderController::class, 'restore'])->name('slider.restore');
        Route::get('/force-delete/{id}', [App\Http\Controllers\Admin\Slider\SliderController::class, 'forceDelete'])->name('slider.forceDelete');
    });
    // người dùng
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/create', [UserController::class, 'create'])->name('user.add');
        Route::post('/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::post('/deleteAll', [UserController::class, 'deleteAll'])->name('user.deleteAll');
        Route::post('/update-status/{id}', [UserController::class, 'updateStatus'])->name('user.updateStatus');
        Route::match(['GET', 'POST'], '/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::get('/trash', [UserController::class, 'trash'])->name('user.trash');
        Route::get('/permanentlyDelete/{id}', [UserController::class, 'permanentlyDelete'])->name('user.permanentlyDelete');
        Route::post('/permanentlyDeleteSelected', [UserController::class, 'permanentlyDeleteSelected'])->name('user.permanentlyDeleteSelected');
        Route::post('/restoreSelected', [UserController::class, 'restoreSelected'])->name('user.restoreSelected');
        Route::get('/force-delete/{id}', [UserController::class, 'forceDelete'])->name('user.forceDelete');
        Route::get('/restore/{id}', [UserController::class, 'restore'])->name('user.restore');
    });

    ///hóa đơn

    Route::prefix('order')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\OrderAdmin::class, 'index'])->name('order.index');
    });
    ///
});

//route ảnh
Route::get('{filename}', function ($filename) {
    $path = storage_path('app/public/' . $filename);

    if (!Storage::disk('public')->exists($filename)) {
        abort(404);
    }
    return response()->file($path);
})
    ->where('filename', '(.*)')
    ->name('admin.sliders.images.show');
Route::get('movie-ticket-plan', function () {
    return view('client.movies.movie-ticket-plan');
})->name('movie-ticket-plan');

Route::get('movie-checkout', function () {
    return view('client.movies.movie-checkout');
})->name('movie-checkout');




Route::get('about-us', function () {
    return view('client.pages.about-us');
})->name('about-us');

Route::get('contact', function () {
    return view('client.contacts.contact');
})->name('contact');
