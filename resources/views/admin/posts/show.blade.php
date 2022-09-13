@extends('layouts.dashboard')

@section('content')
    <h1>{{ $post->title }}</h1>
    <div>slug: {{$post->slug}}</div>
    <div>created on {{$post->created_at->format('l d F Y')}}</div>
    <div>last edit: {{$post->updated_at->format('l d F Y')}}</div>
    <div>category: {{$post->category ? $post->category->name : 'no category'}}</div>
    <div>
        tags: 

        @forelse ($post->tags as $tag)
            {{$tag->name}}{{!$loop->last ? ',' : ''}}
        @empty
            no tags
        @endforelse
    </div>

    <h4>content:</h4>
    <p>{{ $post->content }}</p>
    
    {{-- link per modificare post --}}
    <a class="btn btn-primary" href="{{route('admin.posts.edit', ['post' => $post->id])}}">Edit post</a>

    {{-- input per eliminare il post --}}
    <form class="mt-2" action="{{route('admin.posts.destroy', ['post' => $post->id])}}" method="post">
        @csrf
        @method('DELETE')

        <input class="btn btn-danger" type="submit" value="Delete post" onClick="return confirm('Are you sure you want to delete this post')">
    </form>
@endsection