@csrf
<div class="form-group">
    <label for="post-title">Title</label>
    <input type="text" name="title" value="{{ old('title', $post->title) }}" id="post-title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}">

    @if ($errors->has('title'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('title') }}</strong>
        </div>
    @endif
</div>

<div class="form-group">
    <label for="post-title">Category</label>
    <input type="text" name="category" value="{{ old('category', $post->category) }}" id="post-category" class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}">

    @if ($errors->has('category'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('category') }}</strong>
        </div>
    @endif
</div>

<div class="form-group">
    <label for="post-content">Content</label>
    <textarea name="content" id="post-content" rows="10" class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}">{{ old('content', $post->content) }}</textarea>

    @if ($errors->has('content'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('content') }}</strong>
        </div>
    @endif
</div>

<div class="form-group">
    <label for="post-status">Status</label>

    <select id="post-status" name="status"  class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}">
        <?php $status_now = old('status', $post->status) ?>
        <option >-- Pilih status --</option>
        <option  value="Publish" <?php if ( $status_now == 'Publish') {echo 'selected';}?> >Publish</option>
        <option value="Draft" <?php if ($status_now == 'Draft')  {echo 'selected';} ?>>Draft</option>
    </select>

    @if ($errors->has('status'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('status') }}</strong>
        </div>
    @endif
</div>

<div class="form-group">
    <button type="submit" class="btn btn-outline-primary btn-lg">{{ $buttonText }}</button>
</div>