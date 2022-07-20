@extends('layout')
@section('content')
<div class="row container" id="wrapper">
   <div class="halim-panel-filter">
      <div class="panel-heading">
         <div class="row">
            <div class="col-xs-6">
               <div class="yoast_breadcrumb hidden-xs"><span><span><a href="">Phim theo tags</a> » <span class="breadcrumb_last" aria-current="page">{{$tag}}</span></span></span></div>
            </div>
         </div>
      </div>
      <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
         <div class="ajax"></div>
      </div>
   </div>
   <main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
      <section>
         <div class="section-bar clearfix">
            <h1 class="section-title"><span>Tag : {{$tag}}</span></h1>
         </div>
         <div class="halim_box">
            @foreach($movie as $key => $mov)
            <article class="col-md-3 col-sm-3 col-xs-6 thumb grid-item post-37606">
            <div class="halim-item">
               <a class="halim-thumb" href="{{route('movie',$mov->slug)}}" title="{{$mov->title}}">
                  <figure><img class="lazy img-responsive" src="{{asset('public/uploads/movies/'.$mov->image)}}" alt="{{$mov->title}}" title="{{$mov->title}}"></figure>
                  <span class="status">HD</span>
                  <span class="episode"><i class="fa fa-play" aria-hidden="true"></i>
                     Vietsub
                     @if($mov->season!=0)
                        - Season {{$mov->season}}
                     @endif

                  </span>  
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
         <div class="clearfix"></div>
         <div class="text-center">
            {!! $movie->links("pagination::bootstrap-4") !!}
         </div>
      </section>
   </main>
   @include('pages.include.sidebar')
</div>
@endsection