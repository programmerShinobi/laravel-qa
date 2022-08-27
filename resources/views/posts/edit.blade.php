@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h2>
                            Edit Post
                        </h2>
                        <div class="ml-auto">
                            <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">Back to All Post</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('posts.update', $post->id) }}" method="post">
                        {{ method_field('PUT') }}
                        @include('posts._form', ['buttonText' => 'Update Post'])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
