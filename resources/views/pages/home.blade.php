@extends('layout')
@section('content')
<div class="row container" id="wrapper">
   <div class="halim-panel-filter">
      <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
         <div class="ajax"></div>
      </div>
   </div>
   <div id="halim_related_movies-2xx" class="wrap-slider">
      <div class="section-bar clearfix">
         <h3 class="section-title"><span>PHIM HOT</span></h3>
      </div>
      <div id="halim_related_movies-2" class="owl-carousel owl-theme related-film">
         @foreach($phim_hot as $key => $hot)
         <article class="thumb grid-item post-38498">
            <div class="halim-item">
               <a class="halim-thumb" href="{{route('movie',$hot->slug)}}" title="{{$hot->title}}">
                  <figure><img class="lazy img-responsive" src="{{asset('public/uploads/movies/'.$hot->image)}}" alt="{{$hot->title}}" title="{{$hot->title}}"></figure>
                  <span class="status">HD</span>
                  <span class="episode"><i class="fa fa-play" aria-hidden="true"></i>
                     Vietsub
                     @if($hot->season!=0)
                        - Season {{$hot->season}}
                     @endif

                  </span>  
                  <div class="icon_overlay"></div>
                  <div class="halim-post-title-box">
                     <div class="halim-post-title ">
                        <p class="entry-title">{{$hot->title}}</p>
                        <p class="original_title">{{$hot->name_eng}}</p>
                     </div>
                  </div>
               </a>
            </div>
         </article>
         @endforeach
      </div>
   </div>
   <main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
      @foreach ($category_home as $key => $cate_home)
      <section id="halim-advanced-widget-2">
         <div class="section-heading">
            <a href="{{route('category',$cate_home->slug)}}" title="Phim Bộ">
            <span class="h-text">{{$cate_home->title}}</span>
            </a>
         </div>
         <div id="halim-advanced-widget-2-ajax-box" class="halim_box">
            @foreach ($cate_home->movie->take(10) as $key => $mov) 
            <article class="col-md-3 col-sm-3 col-xs-6 thumb grid-item post-37606">
               <div class="halim-item">
                  <a class="halim-thumb" href="{{route('movie',$mov->slug)}}">
                     <figure><img class="lazy img-responsive" src="{{asset('public/uploads/movies/'.$mov->image)}}" alt="{{$mov->title}}" title="{{$mov->title}}"></figure>
                     <span class="status">HD</span><span class="episode"><i class="fa fa-play" aria-hidden="true"></i>Vietsub</span> 
                     <div class="icon_overlay"></div>
                     <div class="halim-post-title-box">
                        <div class="halim-post-title ">
                           <p class="entry-title">{{$mov->title}}</p>
                           <p class="original_title">{{$mov->name_eng}}</p>
                        </div>
                     </div>
                  </a>
               </div>
            </article>
            @endforeach
         </div>
      </section>
      <div class="clearfix"></div>
      @endforeach
   </main>
   @include('pages.include.sidebar')
</div>
@endsection