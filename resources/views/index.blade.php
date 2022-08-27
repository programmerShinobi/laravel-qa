@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h2>
                            Article
                        </h2>
                        <div class="ml-auto">
                            <a href="{{ route('posts.create') }}" class="btn btn-outline-secondary">New Post</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @include('layouts._messages')

                    @foreach ($posts as $post)
                      @if ($post->status == "Publish")
                      <div class="media">
                          <div class="media-body">
                              <div class="d-flex align-items-center">
                                  <h3 class="mt-0">{{ $post->title }}</h3>
                              </div>
                              <p class="lead">
                                  Category
                                  {{ $post->category }}
                                  <h6 class="text-muted">{{ $post->created_date }}</h6>
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
