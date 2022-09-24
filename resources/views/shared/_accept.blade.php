@can('accept', $model)
    <a title="Mark this answer as best answer"
    class="{{ $model->status }} mt-2"
    onclick="event.preventDefault(); document.getElementById('accept-answer-{{ $model->id }}').submit();"
    >
        <i class="fa-solid fa-check fa-2x"></i>                                    
    </a>
    <form action="{{ route('answers.accept', $model->id) }}" id="accept-answer-{{ $model->id }}" method="POST" style="display: none;">
        @csrf
    </form>
@else
    @if ($model->is_best)
        <a title="The questoin owner accepted this answer as best answer"
        class="{{ $model->status }} mt-2">
            <i class="fa-solid fa-check fa-2x"></i>                                    
        </a>
    @endif
@endcan