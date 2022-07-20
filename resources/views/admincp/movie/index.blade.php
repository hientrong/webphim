@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                
                <div class="card-header">Quản lý phim</div>
                <a href="{{route('movie.create')}}" class="btn btn-warning">Thêm phim</a>
            </div>
            <table class="table" id="tablephim">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Title</th>
                  <th scope="col">Tags</th>
                  <th scope="col">Thời lượng phim</th>
                  <th scope="col">Image</th>
                  <th scope="col">HOT</th>
                  <th scope="col">Slug</th>
                  <th scope="col">Trailer</th>
                  <!-- <th scope="col">Active/Inactive</th> -->
                  <th scope="col">Category</th>
                  <th scope="col">Country</th>
                  <th scope="col">Số tập</th>
                  <th scope="col">Genre</th>
                  <th scope="col">Name English</th>
                  <!-- <th scope="col">Ngày tạo</th>
                  <th scope="col">Ngày cập nhật</th> -->
                  <th scope="col">Năm phim</th>
                  <th scope="col">Top views</th>
                  <th scope="col">Season</th>
                  <th scope="col">Manage</th>
                </tr>
              </thead>
              <tbody>
                @foreach($list as $key => $cate)
                <tr>
                  <th scope="row">{{$key}}</th>
                  <td>{{$cate->title}}</td>
                  <td>
                     @if($cate->tags != NULL)
                        {{substr($cate->tags,0,50)}}...
                    @else
                        Chưa có từ khóa nào cho phim
                    @endif
                  </td>
                  <td>{{$cate->thoiluong}}</td>
                  <td><img width="60%" src="{{asset('public/uploads/movies/'.$cate->image)}}"></td>
                  <td>
                    @if($cate->phim_hot)
                        Có
                    @else
                        Không
                    @endif
                  </td>
                  <td>{{$cate->slug}}</td>
                  <td>{{$cate->trailer}}</td>
                  <!-- <td>
                    @if($cate->status)
                        Hiển thị
                    @else
                        Không hiển thị
                    @endif
                  </td> -->
                  <td>{{$cate->category->title}}</td>
                  <td>{{$cate->country->title}}</td>
                  <td>{{$cate->sotap}}</td>

                  <td>
                  @foreach ($cate->movie_genre as $gen)
                    <span class="badge badge-dark">{{$gen->title}}</span>
                  @endforeach
                  </td>
                  <td>{{$cate->name_eng}}</td>
                  <!-- <td>{{$cate->ngaytao}}</td> -->
                  <!-- <td>{{$cate->ngaycapnhat}}</td> -->
                  <td>
                      {!! Form::selectYear('year', 2000, 2022, isset($cate->year) ? $cate->year : '', ['class'=>'select-year', 'id'=>$cate->id]) !!}
                  </td>
                  <td>
                    @csrf
                    {!! Form::select('topview', ['0'=>'Ngày','1'=>'Tuần','2'=>'Tháng'],isset($cate->topview) ? $cate->topview : '', ['class'=>'select-topview', 'id'=>$cate->id]) !!}
                  </td>
                  <td>
                    @csrf
                      {!! Form::selectRange('season', 0, 20, isset($cate->season) ? $cate->season : '', ['class'=>'select-season', 'id'=>$cate->id]) !!}
                  </td>
                  <td>
                      {!! Form::open([
                        'method'=>'DELETE',
                        'route'=>['movie.destroy', $cate->id], 'onsubmit'=>'return confirm("Xóa?")']
                      ) !!}
                      {!! Form::submit('Xóa', ['class'=>'btn btn-danger']) !!}
                      {!! Form::close() !!}

                      <a href="{{route('movie.edit', $cate->id)}}" class="btn btn-warning">Sửa</a>

                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
