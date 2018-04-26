@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>
                {{ (optional($category)->exists )? 'Post de '.$category->name : 'Post' }}
            </h1>
        </div>
    </div>
    <div class="row">

        @include('post.sidebar')

        <div class="col-md-10">
            {!! Form::open(['method'=> 'get', 'class'=> 'form form-inline']) !!}

                {!! Form::select('orden', config('options.post-order'),request()->get('orden'), ['class'=> 'form-control'] ) !!}
                <button type="submit" class="btn btn-default">Ordenar</button>
            {!! Form::close() !!}

            @each('post.item', $posts, 'post')

            {{ $posts->appends(array_filter(request()->only(['orden'])))->render() }}
        </div>
    </div>
@endsection