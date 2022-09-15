@extends('layouts.dashboard')

@section('content')
    <h1>create</h1>
    
    <form action="{{route('admin.posts.store')}}" method="post" enctype="multipart/form-data">
        @csrf

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
            <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}">
        </div>

        {{-- category --}}
        <div class="mb-3">
            <label for="category_id">category</label>
            <select class="form-select" id="category_id" name="category_id">
                <option value="">no category</option>
                @foreach ($categories as $category)
                    <option value="{{$category->id}}" {{old('category_id') == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                @endforeach
            </select>
        </div>

        {{-- tags --}}
        <div class="mb-3">
            <div>tags:</div>
            
            @foreach ($tags as $tag)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="{{$tag->id}}" id="tag-{{$tag->id}}" name="tags[]" {{in_array($tag->id, old('tags', [])) ? 'checked' : ''}}>
                    <label class="form-check-label" for="tag-{{$tag->id}}">
                        {{$tag->name}}
                    </label>
                </div>
            @endforeach
            
        </div>

        {{-- content --}}
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="7">{{old('content')}}</textarea>
        </div>

        {{-- cover --}}
        <div class="mb-3">
            <label for="image" class="form-label">image</label>
            <input class="form-control" type="file" id="image" name="image">
        </div>

        <input class="btn btn-primary" type="submit" value="Save">
    </form>
@endsection