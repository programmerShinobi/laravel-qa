@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h2>
                            All Posts
                        </h2>
                        <div class="ml-auto">
                            <a href="{{ route('posts.create') }}" class="btn btn-outline-secondary">New Post</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @include('layouts._messages')

                    @foreach ($posts as $post)
                        <div class="media">
                            <div class="media-body">
                                <div class="d-flex align-items-center">
                                    <h3 class="mt-0">{{ $post->title }}</h3>
                                    <div class="ml-auto">
                                        @can ('update', $post)
                                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-outline-info">Edit</a>
                                        @endcan

                                        @can ('delete', $post)
                                            <form class="form-delete" action="{{ route('posts.destroy', $post->id) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                                <p class="lead">
                                    Category
                                    {{ $post->category }}
                                    <small class="text-muted">{{ $post->created_date }}</small>
                                </p>
                                {{ str_limit($post->content, 100) }}
                            </div>
                        </div>
                        <hr>
                   @endforeach

                   <div class="mx-auto">
                       {{ $posts->links() }}
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
