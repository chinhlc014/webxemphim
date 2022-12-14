<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Cate;
use App\Models\Link;
use App\Models\Rate;
use App\Models\User;
use App\Models\Year;
use App\Models\Image;
use App\Models\Movie;
use App\Models\Nation;
use App\Models\Comment;
use App\Models\Payment;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Requests\LinkRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\MovieRequest;
use Illuminate\Support\Facades\File;
use App\Http\Requests\EditMovieRequest;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function detailmovie($id)
    {
        
        if (session('username_minmovies')) {
            $username = session('username_minmovies');
            $user = User::where('username', $username)->first();
            $user_id = $user->id;
        } else
            $user_id = 0;
        $cate = Cate::all();
        $nation = Nation::all();
        $year = Year::all();
        $language = Language::all();
        $movie = Movie::find($id);
        $cate_id = $movie->cate_id;
        $slider = Movie::where('cate_id', $cate_id)->where('id', '!=', $id)->latest()->limit(10)->get();
        $comment = Comment::where('movie_id', $id)->get();
        $user = User::all();
        $rate = Rate::where('movie_id', $id)->get();
        if ($rate->isEmpty()) {
            # code...
            $averageRate = 0;
            $totalRate = 0;
        } else {
            # code...
            $totalRatePoint = 0;
            $totalRate = count($rate);
            $averageRate = 0;
            foreach ($rate as $item) {
                # code...
                $totalRatePoint += $item->rate;
            }
            $averageRate = number_format((float)($totalRatePoint / $totalRate), 1, '.', '');
        }


        return view('user.detailmovie', compact('slider', 'id', 'movie', 'cate', 'nation', 'year', 'language', 'user', 'comment', 'user_id', 'averageRate', 'totalRate'));
    }
    public function watchmovie($id, $server)
    {
        $bought = 0;
        if (session('username_minmovies')) {
            $username = session('username_minmovies');
            $user = User::where('username', $username)->first();
            $user_id = $user->id;
        }
        $language = Language::all();
        $cate = Cate::all();
        $nation = Nation::all();
        $year = Year::all();
        $movie = Movie::find($id);
        $cate_id = $movie->cate_id;
        $suggest = Movie::latest()->limit(6)->get();
        $sliderCate = Movie::where('cate_id', $cate_id)->where('id', '!=', $id)->latest()->limit(10)->get();
        $slider = Movie::latest()->limit(10)->get();
        $link = Link::all();
        $comment = Comment::where('movie_id', $id)->get();
        $user = User::all();
        return view('user.watchmovie', compact('suggest', 'id', 'movie', 'cate', 'nation', 'year', 'link', 'server', 'slider', 'language', 'user', 'comment', 'sliderCate'));
    }


    public function getlist()
    {
        $language = Language::all();
        $cate = Cate::all();
        $nation = Nation::all();
        $year = Year::all();
        $movie = Movie::latest()->paginate(24);
        return view('user.list', compact('movie', 'cate', 'nation', 'year', 'language'));
    }
    public function gettrailer()
    {
        $cate = Cate::all();
        $nation = Nation::all();
        $year = Year::all();
        $movie = Movie::latest()->paginate(24);
        return view('user.trailer', compact('movie', 'cate', 'nation', 'year'));
    }

    public function index()
    {
        //
        $movie = Movie::latest()->get();
        $cate = Cate::all();
        $nation = Nation::all();
        $year = Year::all();
        return view('admin.movie.list', compact('movie', 'cate', 'nation', 'year'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $cate = Cate::all();
        $nation = Nation::all();
        $year = Year::all();
        $language = Language::all();
        return view('admin.movie.add', compact(['cate', 'nation', 'year', 'language']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MovieRequest $request, LinkRequest $requestlink)
    {
        //
        $filename = $request->poster->getClientOriginalName();
        $movie = new Movie;
        $movie->vie_name = $request->txtViename;
        $movie->eng_name = $request->txtEngname;
        $movie->cate_id = $request->cate_id;
        $movie->nation_id = $request->nation_id;
        $movie->year_id = $request->year_id;
        $movie->language_id = $request->language_id;
        $movie->poster_image = $filename;
        $movie->information = $request->txtInfo;
        $movie->director = $request->txtDirector;
        $movie->point = $request->txtPoint;
        $movie->time = $request->txtTime . ' Ph??t';
        $movie->quality = $request->txtQuality;
        $movie->actor = $request->txtActor;
        $movie->eng_name = $request->txtEngname;
        $movie->save();
        $request->poster->storeAs('poster', $filename);
        $link = new Link;
        $link->movie_id = $movie->id;
        $link->link1 = $requestlink->txtServer1;
        $link->save();
        return redirect()->route('admin.movie.list')->with(['thongbao_level' => 'success', 'thongbao' => 'Th??m phim th??nh c??ng!']);
    }

    public function postSearch(Request $request)
    {
        $language = Language::all();
        $cate = Cate::all();
        $nation = Nation::all();
        $year = Year::all();
        $search = $request->search;
        $searchSort = $request->searchSort;
        $movie = Movie::where('vie_name', 'like', '%' . $request->search . '%')->orWhere('eng_name', 'like', '%' . $request->search . '%')->latest()->paginate(24);
        return view('user.search', compact('cate', 'nation', 'year', 'movie', 'search', 'language', 'searchSort'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $movie = Movie::find($id);
        $cate = Cate::all();
        $nation = Nation::all();
        $year = Year::all();
        $language = Language::all();
        $link = Link::all();
        return view('admin.movie.edit', compact('movie', 'cate', 'nation', 'year', 'language', 'link', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(EditMovieRequest $request, LinkRequest $requestlink, $id)
    {
        //
        $movie = Movie::find($id);
        if ($request->poster) {
            $myFile = 'public/poster/' . $movie->poster_image;
            File::delete($myFile);
            $file = $request->file('poster');
            $originalFile = $file->getClientOriginalName();
            $filename = rand(1000, 9999) . '-' . $originalFile;
            $file->move('public/poster', $filename);
            $movie->poster_image = $filename;
        }
        $movie->vie_name = $request->txtViename;
        $movie->eng_name = $request->txtEngname;
        $movie->cate_id = $request->cate_id;
        $movie->nation_id = $request->nation_id;
        $movie->year_id = $request->year_id;
        $movie->language_id = $request->language_id;
        $movie->information = $request->txtInfo;
        $movie->director = $request->txtDirector;
        $movie->point = $request->txtPoint;
        $movie->time = $request->txtTime;
        $movie->quality = $request->txtQuality;
        $movie->actor = $request->txtActor;
        $movie->eng_name = $request->txtEngname;
        $movie->save();
        $link = new Link;
        $arr['movie_id'] = $movie->id;
        $arr['link1'] = $requestlink->txtServer1;
        $link::where('movie_id', $movie->id)->update($arr);
        return redirect()->route('admin.movie.list')->with(['thongbao_level' => 'success', 'thongbao' => 'S???a phim th??nh c??ng!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $movie = Movie::find($id);
        $movie->delete();
        return redirect()->route('admin.movie.list')->with(['thongbao_level' => 'success', 'thongbao' => 'Xo?? phim th??nh c??ng!']);
    }
    public function getBoughtMovie()
    {
        $cate = Cate::all();
        $nation = Nation::all();
        $year = Year::all();
        $language = Language::all();
        $username = session('username_minmovies');
        $user = User::where('username', $username)->first();
        $user_id = $user->id;
        $movie = Movie::all();
        return view('user.boughtMovie', compact('cate', 'nation', 'year', 'payment', 'movie', 'language'));
    }
    public  function getHint($q)
    {
        $hint = "";
        // Tim tat ca cac hint co trong Array neu tham so $q khac ""
        if ($q !== "") {
            $q = strtolower($q);
            $len = strlen($q);
            $movie = Movie::where('vie_name', 'like', '%' . $q . '%')->orWhere('eng_name', 'like', '%' . $q . '%')->get();
            foreach ($movie as $item) {
                if ($hint === "") {
                    $hint =  "<div class='searchHint'>
                    <a href='movie/detail/$item->id'>" . $item->vie_name . '</a></div>';
                } else {
                    $hint .= "<div class='searchHint'>
                    <a href='movie/detail/$item->id'>" . $item->vie_name . '</a></div>';
                }
            }
        }
        // Ket qua "Khong co suggestion nao" neu khong tim thay bat ky hint nao trong Array
        echo $hint === "" ? "Kh??ng t??m th???y phim!" : $hint;
    }
}
