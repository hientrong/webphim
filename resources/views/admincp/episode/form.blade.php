@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                
                <div class="card-header">Quản lý tập phim</div>
                <a href="{{route('episode.index')}}" class="btn btn-warning">Liệt kê tập phim</a>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(!isset($episode))
                        {!! Form::open(['route'=>'episode.store','method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
                    @else    
                        {!! Form::open(['route'=>['episode.update', $episode->id],'method'=>'PUT', 'enctype'=>'multipart/form-data']) !!}
                    @endif
            
                        <div class="form-group">
                            {!! Form::label('movie', 'Chọn phim', []) !!}
                            {!! Form::select('movie_id', ['0' => 'Chọn phim', ' '=> $list_movie], isset($episode) ? $episode->movie_id: '', ['class'=>'form-control select-movie', 'placeholder'=>'.....', isset($episode) ? 'disabled' : '']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::macro('image', ['class'=>'form-control-file']) !!}
                            @if(isset($episode))
                                <img width="30%" src="{{asset('public/uploads/movies/'.$episode->movie->image)}}">
                            @endif
                        </div>
                        <div class="form-group">
                            {!! Form::label('link', 'Link phim', []) !!}
                            {!! Form::text('link', isset($episode) ? $episode->linkphim : '', ['class'=>'form-control', 'placeholder'=>'.....']) !!}
                        </div>

                        @if(isset($episode))
                            <div class="form-group">
                                {!! Form::label('episode', 'Tập phim', []) !!}
                                {!! Form::text('episode', isset($episode) ? $episode->episode : '', ['class'=>'form-control', 'placeholder'=>'.....', isset($episode) ? 'readonly' : '']) !!}
                            </div>
                        @else
                            <div class="form-group">
                                {!! Form::label('episode', 'Tập phim', []) !!}
                                <select name="episode" class="form-control" id="show_movie"></select>
                            </div>
                        @endif

                        @if(!isset($episode))
                            {!! Form::submit('Thêm dữ liệu', ['class'=>'btn-success']) !!}
                        @else
                            {!! Form::submit('Cập nhật dữ liệu', ['class'=>'btn-success']) !!}
                        @endif
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
