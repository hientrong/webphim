@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                
                <div class="card-header">Quản lý tập phim</div>
                <a href="{{route('episode.create')}}" class="btn btn-warning">Thêm tập phim</a>
            </div>
            <table class="table" id="tablephim">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Tên phim</th>
                  <th scope="col">Hình ảnh phim</th>
                  <th scope="col">Tập phim</th>
                  <th scope="col">Link phim</th>
                  <th scope="col">Manage</th>
                </tr>
              </thead>
              <tbody>
                @foreach($list_movie as $key => $episode)
                <tr>
                  <th scope="row">{{$key}}</th>
                  <td>{{$episode->movie->title}}</td>
                  <td><img width="60%" src="{{asset('public/uploads/movies/'.$episode->movie->image)}}"></td>
                  <td>{{$episode->episode}}</td>
                  <td>
                    <iframe width="560" height="315" src="{!!$episode->linkphim!!}" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                  </td>
                  <td>
                      {!! Form::open([
                        'method'=>'DELETE',
                        'route'=>['episode.destroy', $episode->id], 'onsubmit'=>'return confirm("Xóa?")']
                      ) !!}
                      {!! Form::submit('Xóa', ['class'=>'btn btn-danger']) !!}
                      {!! Form::close() !!}

                      <a href="{{route('episode.edit', $episode->id)}}" class="btn btn-warning">Sửa</a>

                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
