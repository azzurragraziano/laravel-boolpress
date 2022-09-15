@extends('layouts.dashboard')

@section('content')
    <h1>lista post</h1>

    @if ($show_deleted_message === 'yes')
        <div class="alert alert-success" role="alert">
            post deleted
        </div>
    @endif

    <div class="row row-cols-3">

        {{-- stampo i post --}}
        @foreach ($posts as $post)
            <div class="col">
                <div class="card mt-2">
                    <div class="card-body">

                        {{-- cover --}}
                        @if ($post->cover)
                            <img class="w-100" src="{{asset('storage/' . $post->cover)}}" alt="{{ $post->title }}"> 
                        @endif

                        {{-- title --}}
                        <h5 class="card-title">{{ $post->title }}</h5>

                        {{-- created --}}
                        <div>created on {{$post->created_at->format('l d F Y')}}</div>

                        {{-- find out more btn --}}
                        <a href="{{route('admin.posts.show', ['post' => $post->id])}}" class="btn btn-primary mt-2">Find out more</a>
                    </div>
                </div>
            </div>
        @endforeach
        
    </div>

    <div class="mt-3">
        {{ $posts->links() }}
    </div>
@endsection