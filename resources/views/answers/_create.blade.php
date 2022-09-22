    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3>Your Answer</h3>
                    </div>
                    <hr>
                    <form action="{{ route('questions.answers.store', $question->id) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <textarea class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}" name="body" id="" rows="7">
                            </textarea>
                            @if ($errors->has('body'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('body') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            @if (Auth::id())
                                <button class="btn btn-lg btn-outline-primary" type="submit">Submit</button>
                            @else
                                <a class="btn btn-lg btn-outline-primary" href="{{ route('login') }}">Submit</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>