<!-- resources/views/series/partials/form.blade.php -->

<div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $series->name ?? '') }}" required>
</div>

<div class="form-group">
    <label for="description">Description</label>
    <textarea name="description" class="form-control" required>{{ old('description', $series->description ?? '') }}</textarea>
</div>

<div class="form-group">
    <label for="path">Path</label>
    <input type="text" name="path" class="form-control" value="{{ old('path', $series->path ?? '') }}" required>
</div>

<div class="form-group">
    <label for="photo">Photo</label>
    <input type="text" name="photo" class="form-control" value="{{ old('photo', $series->photo ?? '') }}" required>
</div>

<div class="form-group">
    <label for="season">Season</label>
    <input type="number" name="season" class="form-control" value="{{ old('season', $series->season ?? 1) }}" required>
</div>

<div class="form-group">
    <label for="episode">Episode</label>
    <input type="number" name="episode" class="form-control" value="{{ old('episode', $series->episode ?? 1) }}" required>
</div>

<div class="form-group">
    <label for="progress_time">Progress Time</label>
    <input type="number" name="progress_time" class="form-control" value="{{ old('progress_time', $series->progress_time ?? 0) }}" required>
</div>

<div class="form-group">
    <label for="category_id">Category</label>
    <select name="category_id" class="form-control" required>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ (old('category_id', $series->category_id ?? '') == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
        @endforeach
    </select>
</div>

<button type="submit" class="btn btn-primary">{{ $submitButtonText }}</button>
<a href="{{ route('series.index') }}" class="btn btn-secondary">Cancel</a>
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
