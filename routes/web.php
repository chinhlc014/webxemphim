<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\CabinetController;
use App\Http\Controllers\CateController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\NationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\YearController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Admin routes

Route::group(['prefix' => 'admin'], function () {

    //Admin login, index ,logout
    Route::get('/', [AdminController::class, 'checkLogin']);
    Route::get('login', [AdminController::class, 'getLogin'])->name('admin.getLogin');
    Route::post('login', [AdminController::class, 'postLogin'])->name('admin.postLogin');
    Route::get('index', [AdminController::class, 'index'])->name('admin.index')->middleware('AdminMiddleware');
    Route::get('logout', [AdminController::class, 'logout'])->name('admin.logout');

    //Admin manage cate

    Route::group(['prefix' => 'cate'], function () {
        Route::get('add', [CateController::class, 'create'])->name('admin.cate.create');
        Route::post('add', [CateController::class, 'store'])->name('admin.cate.store');
        Route::get('list', [CateController::class, 'index'])->name('admin.cate.list');
        Route::get('del/{id}', [CateController::class, 'destroy'])->name('admin.cate.del');
        Route::get('edit/{id}', [CateController::class, 'edit'])->name('admin.cate.edit');
        Route::post('edit/{id}', [CateController::class, 'update'])->name('admin.cate.update');
    });

    //Admin manage nation

    Route::group(['prefix' => 'nation', 'middleware' => 'AdminMiddleware'], function () {
        Route::get('add', [NationController::class, 'create'])->name('admin.nation.create');
        Route::post('add', [NationController::class, 'store'])->name('admin.nation.store');
        Route::get('list', [NationController::class, 'index'])->name('admin.nation.list');
        Route::get('del/{id}', [NationController::class, 'destroy'])->name('admin.nation.del');
        Route::get('edit/{id}', [NationController::class, 'edit'])->name('admin.nation.edit');
        Route::post('edit/{id}', [NationController::class, 'update'])->name('admin.nation.update');
    });

    //Admin manage year

    Route::group(['prefix' => 'year', 'middleware' => 'AdminMiddleware'], function () {
        Route::get('add', [YearController::class, 'create'])->name('admin.year.create');
        Route::post('add', [YearController::class, 'store'])->name('admin.year.store');
        Route::get('list', [YearController::class, 'index'])->name('admin.year.list');
        Route::get('del/{id}', [YearController::class, 'destroy'])->name('admin.year.del');
        Route::get('edit/{id}', [YearController::class, 'edit'])->name('admin.year.edit');
        Route::post('edit/{id}', [YearController::class, 'update'])->name('admin.year.update');
    });

    //Admin manage movie

    Route::group(['prefix' => 'movie', 'middleware' => 'AdminMiddleware'], function () {
        Route::get('add', [MovieController::class, 'create'])->name('admin.movie.create');
        Route::post('add', [MovieController::class, 'store'])->name('admin.movie.store');
        Route::get('list', [MovieController::class, 'index'])->name('admin.movie.list');
        Route::get('del/{id}', [MovieController::class, 'destroy'])->name('admin.movie.del');
        Route::get('edit/{id}', [MovieController::class, 'edit'])->name('admin.movie.edit');
        Route::post('edit/{id}', [MovieController::class, 'update'])->name('admin.movie.update');
    });

    //Admin manage user

    Route::group(['prefix' => 'user', 'middleware' => 'AdminMiddleware'], function () {
        Route::get('add', [UserController::class, 'create'])->name('admin.user.create');
        Route::post('add', [UserController::class, 'store'])->name('admin.user.store');
        Route::get('list', [UserController::class, 'index'])->name('admin.user.list');
        Route::get('del/{id}', [UserController::class, 'destroy'])->name('admin.user.del');
        Route::get('edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
        Route::post('edit/{id}', [UserController::class, 'update'])->name('admin.user.update');
    });

    //Admin manage cabinet

    Route::group(['prefix' => 'cabinet', 'middleware' => 'AdminMiddleware'], function () {
        Route::get('list', [CabinetController::class, 'index'])->name('admin.cabinet.list');
        Route::get('del/{id}', [CabinetController::class, 'destroy'])->name('admin.cabinet.del');
    });

    //Admin manage comment

    Route::group(['prefix' => 'comment', 'middleware' => 'AdminMiddleware'], function () {
        Route::get('list', [CommentController::class, 'index'])->name('admin.comment.list');
        Route::get('del/{id}', [CommentController::class, 'adminDelComment'])->name('admin.comment.del');
    });

    //Admin manage charge wallet

    Route::group(['prefix' => 'wallet', 'middleware' => 'AdminMiddleware'], function () {
        Route::get('list', [WalletController::class, 'walletCharge'])->name('admin.walletCharge.list');
    });

    //Admin manage payment

    Route::group(['prefix' => 'payment', 'middleware' => 'AdminMiddleware'], function () {
        Route::get('list', [PaymentController::class, 'paymentList'])->name('admin.payment.list');
    });

    //Admin manage statistic

    Route::group(['prefix' => 'statistic', 'middleware' => 'AdminMiddleware'], function () {
        Route::get('payment', [AdminController::class, 'statisticPayment'])->name('admin.statistic.payment');
        Route::post('payment', [AdminController::class, 'sortPayment'])->name('admin.statistic.sort_payment');
        Route::get('charge', [AdminController::class, 'statisticCharge'])->name('admin.statistic.charge');
        Route::post('charge', [AdminController::class, 'sortCharge'])->name('admin.statistic.sort_charge');
    });
});

//User routes
///Home

Route::get('', [HomeController::class, 'index'])->name('user.index');
Route::get('about', [HomeController::class, 'about'])->name('user.about');

///Movie

Route::group(['prefix' => 'movie'], function () {
    Route::get('detail/{id}', [MovieController::class, 'detailmovie'])->name('user.movie');
    Route::get('watch/{id}/{server}', [MovieController::class, 'watchmovie'])->name('user.movie.watch');
});
Route::get('list', [MovieController::class, 'getlist'])->name('user.list');
Route::get('trailer', [MovieController::class, 'gettrailer'])->name('user.trailer');
Route::get('search', [MovieController::class, 'getSearch']);
Route::get('getHint/{q}', [MovieController::class, 'getHint'])->name('user.getHint');
Route::post('search', [MovieController::class, 'postSearch'])->name('user.search');
Route::get('bought', [MovieController::class, 'getBoughtMovie'])->name('user.boughtMovie')->middleware('UserMiddleware');

///Cate

Route::get('cate/{id}', [CateController::class, 'getcate'])->name('user.cate');

///Nation

Route::get('nation/{id}', [NationController::class, 'getnation'])->name('user.nation');

///Year

Route::get('year/{id}', [YearController::class, 'getyear'])->name('user.year');

///User action - login - logout - sign up - profile

Route::get('login', [UserController::class, 'getlogin']);
Route::post('login', [UserController::class, 'loginuser'])->name('user.postlogin');
Route::get('logout', [UserController::class, 'logoutuser'])->name('user.logout')->middleware('UserMiddleware');
Route::get('signup', [UserController::class, 'getsignup']);
Route::post('signup', [UserController::class, 'signupuser'])->name('user.signup');
Route::get('profile', [UserController::class, 'getProfile'])->name('user.getProfile')->middleware('UserMiddleware')->middleware('UserMiddleware');
Route::post('profile', [UserController::class, 'postProfile'])->name('user.postProfile')->middleware('UserMiddleware')->middleware('UserMiddleware');
Route::get('history', [UserController::class, 'historyPayment'])->name('user.historyPayment')->middleware('UserMiddleware')->middleware('UserMiddleware');


///Recover password

Route::get('recoverpassword', [ForgotPasswordController::class, 'getrecoverpassword'])->name('user.getrecoverpassword');
Route::post('recoverpassword', [ForgotPasswordController::class, 'postrecoverpassword'])->name('user.postrecoverpassword');
Route::get('checkrecover/{token}', [ForgotPasswordController::class, 'checkrecover'])->name('user.checkrecover');
Route::post('checkrecover/{token}', [ForgotPasswordController::class, 'postRecoverNewPassword'])->name('user.postRecoverNewPassword');

///Cabinet

Route::get('cabinet', [CabinetController::class, 'getCabinet'])->name('user.getCabinet')->middleware('UserMiddleware');
Route::get('addCabinet/{username}/{movie_id}', [CabinetController::class, 'addCabinet'])->name('user.addCabinet')->middleware('UserMiddleware');
Route::get('deleteCabinet/{username}/{movie_id}', [CabinetController::class, 'deleteCabinet'])->name('user.deleteCabinet')->middleware('UserMiddleware');

///Comment

Route::post('comment/{movie_id}', [CommentController::class, 'postComment'])->name('user.postComment');
Route::post('editComment/{comment_id}', [CommentController::class, 'editComment'])->name('user.editComment');
Route::get('delComment/{comment_id}', [CommentController::class, 'delComment'])->name('user.delComment');

//Rate
Route::post('rate/{movie_id}/{user_id}', [RateController::class, 'postRate'])->name('user.postRate');

///Wallet

Route::group(['prefix' => 'wallet', 'middleware' => 'UserMiddleware'], function () {
    Route::get('/', [WalletController::class, 'getWallet'])->name('user.getWallet');
    Route::get('charge', [WalletController::class, 'getChargeWallet'])->name('user.getChargeWallet');
    Route::post('charge', [WalletController::class, 'postChargeWallet'])->name('user.postChargeWallet');
    Route::get('saveChargeWallet/{username}', [WalletController::class, 'saveChargeWallet'])->name('user.saveChargeWallet');
});

///Buy movie

Route::group(['prefix' => 'payment', 'middleware' => 'UserMiddleware'], function () {
    Route::get('buy/{movie_id}', [PaymentController::class, 'buyMovie'])->name('user.buyMovie');
});

///Reject All

Route::get('{all?}', function () {
    return redirect()->route('user.index')->with(['thongbao_level' => 'danger', 'thongbao' => "<b>Trang bạn vừa truy cập không tồn tại!</b>"]);
});
