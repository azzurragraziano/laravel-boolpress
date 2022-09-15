@extends('layouts.dashboard')

@section('content')
    <h1>edit</h1>

    <form action="{{route('admin.posts.update', ['post' => $post->id])}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- title --}}
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{old('title', $post->title)}}">
        </div>

        {{-- category --}}
        <div class="mb-3">
            <label for="category_id">category</label>
            <select class="form-select" id="category_id" name="category_id">
                <option value="">no category</option>
                @foreach ($categories as $category)
                    <option value="{{$category->id}}" {{old('category_id', $post->category_id) == $category->id ? 'selected' : ''}} >{{$category->name}}</option>
                @endforeach
            </select>
        </div>

        {{-- tags --}}
        <div class="mb-3">
            <div>tags:</div>
            
            @foreach ($tags as $tag)
                @if ($errors->any())
                {{-- se ci sono errori di validazione  --}}
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{$tag->id}}" id="tag-{{$tag->id}}" name="tags[]" {{in_array($tag->id, old('tags', [])) ? 'checked' : ''}}>
                        <label class="form-check-label" for="tag-{{$tag->id}}">
                            {{$tag->name}}
                        </label>
                    </div>
                @else
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{$tag->id}}" id="tag-{{$tag->id}}" name="tags[]" {{$post->tags->contains($tag) ? 'checked' : ''}}>
                        <label class="form-check-label" for="tag-{{$tag->id}}">
                            {{$tag->name}}
                        </label>
                    </div>
                @endif
            @endforeach
            
        </div>

        {{-- content --}}
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="7">{{old('content', $post->content)}}</textarea>
        </div>

        {{-- cover --}}
        <div class="mb-3">
            
            <label for="image" class="form-label">image</label>
            <input class="form-control" type="file" id="image" name="image">
            

            @if ($post->cover)
                <div class="mt-3">current image:</div>
                {{-- mostro l'immagine caricata al momento --}}
                <img class="w-25 mt-2" src="{{asset('storage/' . $post->cover)}}" alt="{{$post->title}}">
            @endif
        </div>

        <input class="btn btn-primary" type="submit" value="Save changes">
    </form>
@endsection