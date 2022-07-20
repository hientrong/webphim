<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use Carbon\Carbon;
use File;
use Storage;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Movie::with('category', 'movie_genre', 'country','genre')->orderBy('id', 'DESC')->get();

        $path = public_path()."/json/";
        if (!is_dir($path)){
            mkdir($path,0777,true);
        }
        File::put($path.'movies.json', json_encode($list));

        return view('admincp.movie.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::pluck('title', 'id');
        $genre = Genre::pluck('title', 'id');
        $country = Country::pluck('title', 'id');
        $list_genre = Genre::all();
        $list = Movie::with('category', 'genre', 'country')->orderBy('id', 'DESC')->get();
        return view('admincp.movie.form', compact('category', 'genre', 'country', 'list_genre'));
    }
    public function update_year(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->year = $data['year'];
        $movie->save();
    }
    public function update_season(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->season = $data['season'];
        $movie->save();
    }
    public function update_topview(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->topview = $data['topview'];
        $movie->save();
    }
    public function filter_topview(Request $request){
        $data = $request->all();
        $movie = Movie::where('topview', $data['value'])->orderBy('ngaycapnhat', 'DESC')->take(5)->get();
        $output = '';
        foreach ($movie as $key => $mov) {
            $output .='
                        <div class="item">
                              <a href="'.url('phim/'.$mov->slug).'" title="'.$mov->title.'">
                                 <div class="item-link">
                                    <img src="'.url('public/uploads/movies/'.$mov->image).'" class="lazy post-thumb" alt="'.$mov->title.'" title="'.$mov->title.'" />
                                    <span class="is_trailer"><i class="fa fa-play" aria-hidden="true"></i>Vietsub</span>
                                 </div>
                                 <p class="title">'.$mov->title.'</p>
                              </a>
                              <div class="viewsCount" style="color: #9d9d9d;">3.2K lượt xem</div>
                              <div style="float: left;">
                                 <span class="user-rate-image post-large-rate stars-large-vang" style="display: block;/* width: 100%; */">
                                 <span style="width: 0%"></span>
                                 </span>
                              </div>
                           </div>
                    ';
        }
        echo $output;
    }
    public function filter_default(Request $request){
        $data = $request->all();
        $movie = Movie::where('topview', 0)->orderBy('ngaycapnhat', 'DESC')->take(6)->get();
        $output = '';
        foreach ($movie as $key => $mov) {
            $output .='
                        <div class="item">
                              <a href="'.url('phim/'.$mov->slug).'" title="'.$mov->title.'">
                                 <div class="item-link">
                                    <img src="'.url('public/uploads/movies/'.$mov->image).'" class="lazy post-thumb" alt="'.$mov->title.'" title="'.$mov->title.'" />
                                    <span class="is_trailer"><i class="fa fa-play" aria-hidden="true"></i>Vietsub</span>
                                 </div>
                                 <p class="title">'.$mov->title.'</p>
                              </a>
                              <div class="viewsCount" style="color: #9d9d9d;">3.2K lượt xem</div>
                              <div style="float: left;">
                                 <span class="user-rate-image post-large-rate stars-large-vang" style="display: block;/* width: 100%; */">
                                 <span style="width: 0%"></span>
                                 </span>
                              </div>
                           </div>
                    ';
        }
        echo $output;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->All();

        $movie = new Movie();
        $movie->title = $data['title'];
        $movie->sotap = $data['sotap'];
        $movie->trailer = $data['trailer'];
        $movie->tags = $data['tags'];
        $movie->phim_hot = $data['phim_hot'];
        $movie->thoiluong = $data['thoiluong'];
        $movie->slug = $data['slug'];
        $movie->name_eng = $data['name_eng'];
        $movie->description = $data['description'];
        $movie->status = $data['status'];
        $movie->category_id = $data['category_id'];

        foreach($data['genre'] as $key => $genr){
            $movie->genre_id = $genr[0];
        }
        // $movie->genre_id = $data['genre_id'];

        $movie->country_id = $data['country_id'];
        $movie->ngaytao = Carbon::now('Asia/Ho_Chi_Minh');
        $movie->ngaycapnhat = Carbon::now('Asia/Ho_Chi_Minh');

        $get_image = $request->file('image');
        $path = 'public/uploads/movies/';
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,9999).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path, $new_image);
            $movie->image = $new_image;
        }
        $movie->save();
        //them nhieu the loai
        $movie->movie_genre()->attach($data['genre']);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::pluck('title', 'id');
        $genre = Genre::pluck('title', 'id');
        $country = Country::pluck('title', 'id');
        $list_genre = Genre::all();
        $movie = Movie::find($id);
        $movie_genre = $movie->movie_genre;
        return view('admincp.movie.form', compact('category', 'genre', 'country','movie','list_genre', 'movie_genre'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->All();
        // return response()->json($data['genre']);
        $movie = Movie::find($id);
        $movie->title = $data['title'];
        $movie->sotap = $data['sotap'];
        $movie->trailer = $data['trailer'];
        $movie->tags = $data['tags'];
        $movie->phim_hot = $data['phim_hot'];
        $movie->thoiluong = $data['thoiluong'];
        $movie->slug = $data['slug'];
        $movie->name_eng = $data['name_eng'];
        $movie->description = $data['description'];
        $movie->status = $data['status'];
        $movie->category_id = $data['category_id'];
        // $movie->genre_id = $data['genre_id'];
        $movie->country_id = $data['country_id'];
        $movie->ngaycapnhat = Carbon::now('Asia/Ho_Chi_Minh');

        $get_image = $request->file('image');
        $path = 'public/uploads/movies/';
        if($get_image){
            if(!empty($movie->image)){
            unlink('public/uploads/movies/'.$movie->image);
            }
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,9999).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path, $new_image);
            $movie->image = $new_image;
        }
        $movie->save();
        $movie->movie_genre()->sync($data['genre']);
        return redirect()->to('movie');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movie = Movie::find($id);
        if(!empty($movie->image)){
            unlink('public/uploads/movies/'.$movie->image);
        }
        $movie->delete();
        return redirect()->back();

    }
}
