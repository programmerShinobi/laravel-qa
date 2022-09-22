@extends('layouts.app')

@section('content')   
<div class="container">
    <div class="row justify-content-center">
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h1>Editing answer for question :
                                <strong>
                                    {{ $question->title }}
                                </strong>
                            </h1>
                            <div class="ml-auto">
                                <a href="{{ route('questions.show', $question->slug) }}" class="btn btn-outline-secondary">Back to Question</a>
                            </div>
                        </div>
                        <hr>
                        <form action="{{ route('questions.answers.update', [$question->id, $answer->id]) }}" method="post">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <textarea class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}" name="body" id="" rows="7">{{ old('body', $answer->body) }}</textarea>
                                @if ($errors->has('body'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <button class="btn btn-lg btn-outline-primary" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection