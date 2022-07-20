<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Country;
use App\Models\Episode;
use App\Models\Movie_Genre;
use DB;

class IndexController extends Controller
{
    public function home(){
        $phim_hot = Movie::where('phim_hot', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->get();
        $phim_hot_sidebar = Movie::where('phim_hot', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take('5')->get();
        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'DESC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $category_home = Category::with('movie')->orderBy('id', 'DESC')->where('status', 1)->get();
        return view('pages.home', compact('category', 'genre', 'country', 'category_home','phim_hot','phim_hot_sidebar'));
    }
    public function category($slug){
        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
        $phim_hot_sidebar = Movie::where('phim_hot', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take('5')->get();
        $genre = Genre::orderBy('id', 'DESC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $cate_slug = Category::where('slug',$slug)->first();
        $movie = Movie::where('category_id', $cate_slug->id)->orderBy('ngaycapnhat', 'DESC')->paginate(40);
        return view('pages.category', compact('category', 'genre', 'country','cate_slug', 'movie','phim_hot_sidebar'));
    }
    public function year($year){
        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'DESC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $phim_hot_sidebar = Movie::where('phim_hot', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take('5')->get();
        $year = $year;
        $movie = Movie::where('year', $year)->orderBy('ngaycapnhat', 'DESC')->paginate(40);
        return view('pages.year', compact('category', 'genre', 'country','year', 'movie', 'phim_hot_sidebar'));
    }
    public function tag($tag){
        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'DESC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $phim_hot_sidebar = Movie::where('phim_hot', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take('5')->get();
        $tag = $tag;
        $movie = Movie::where('tags', 'LIKE', '%'.$tag.'%')->orderBy('ngaycapnhat', 'DESC')->paginate(40);
        return view('pages.tags', compact('category', 'genre', 'country','tag', 'movie', 'phim_hot_sidebar'));
    }
    public function genre($slug){
        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'DESC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $genre_slug = Genre::where('slug',$slug)->first();

        $movie_genre = Movie_Genre::where('genre_id', $genre_slug->id)->get();
        $many_genre = [];
        foreach($movie_genre as $key => $value){
            $many_genre[] = $value->movie_id;
        }

        $phim_hot_sidebar = Movie::where('phim_hot', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take('5')->get();
        $movie = Movie::whereIn('id', $many_genre)->orderBy('ngaycapnhat', 'DESC')->paginate(40);
        return view('pages.genre', compact('category', 'genre', 'country','genre_slug', 'movie', 'phim_hot_sidebar'));
    }
    public function country($slug){
        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'DESC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $country_slug = Country::where('slug',$slug)->first();
        $phim_hot_sidebar = Movie::where('phim_hot', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take('5')->get();
        $movie = Movie::where('country_id', $country_slug->id)->orderBy('ngaycapnhat', 'DESC')->paginate(40);
        return view('pages.country', compact('category', 'genre', 'country','country_slug', 'movie', 'phim_hot_sidebar'));
    }
    public function movie($slug){
        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'DESC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $movie = Movie::with('category', 'genre', 'country','movie_genre')->where('slug', $slug)->where('status', 1)->first();
        $episode_tapdau = Episode::with('movie')->where('movie_id', $movie->id)->orderBy('episode', 'ASC')->take(1)->first();

        $phim_hot_sidebar = Movie::where('phim_hot', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take('5')->get();

        $related = Movie::with('category', 'genre', 'country')->where('category_id', $movie->category->id)->orderBy('ngaycapnhat', 'DESC')->orderBy(DB::raw('RAND()'))->whereNotIn('slug', [$slug])->get();
        $episode = Episode::with('movie')->where('movie_id', $movie->id)->orderBy('episode','DESC')->take(5)->get();
        return view('pages.movie', compact('category', 'genre', 'country', 'movie', 'related', 'phim_hot_sidebar','episode','episode_tapdau'));
    }
    public function timkiem(){
        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
            $phim_hot_sidebar = Movie::where('phim_hot', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take('5')->get();
            $genre = Genre::orderBy('id', 'DESC')->get();
            $country = Country::orderBy('id', 'DESC')->get();
            
            $movie = Movie::where('title','LIKE', '%'.$search.'%')->orderBy('ngaycapnhat', 'DESC')->paginate(40);
            return view('pages.timkiem', compact('category', 'genre', 'country','search', 'movie','phim_hot_sidebar'));
        }else{
            return redirect()->to('/');
        }
        
    }
    public function watch($slug){
        if($_GET['tap-phim']){
            $tapphim = $_GET['tap-phim'];
        }else{
            $tapphim = 1;
        }
        $tapphim = substr($tapphim, 0,9);
        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'DESC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $movie = Movie::with('category', 'genre', 'country', 'episode')->where('slug', $slug)->where('status', 1)->first();
        $phim_hot_sidebar = Movie::where('phim_hot', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take('5')->get();

        $related = Movie::with('category', 'genre', 'country')->where('category_id', $movie->category->id)->orderBy('ngaycapnhat', 'DESC')->orderBy(DB::raw('RAND()'))->whereNotIn('slug', [$slug])->get();

        $episode = Episode::where('movie_id', $movie->id)->where('episode', $tapphim)->first();
        $episode_tap = Episode::with('movie')->where('movie_id', $movie->id)->orderBy('episode','ASC')->get();
        return view('pages.watch', compact('category', 'genre', 'country', 'movie', 'phim_hot_sidebar', 'related','episode','episode_tap'));
    }
    public function espisode(){
        return view('pages.espisode');
    }
}
