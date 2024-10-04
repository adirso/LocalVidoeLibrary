<!-- resources/views/movies/partials/form.blade.php -->

<div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $movie->name ?? '') }}" required>
</div>

<div class="form-group">
    <label for="description">Description</label>
    <textarea name="description" class="form-control" required>{{ old('description', $movie->description ?? '') }}</textarea>
</div>

<div class="form-group">
    <label for="path">Path</label>
    <input type="text" name="path" class="form-control" value="{{ old('path', $movie->path ?? '') }}" required>
</div>

<div class="form-group">
    <label for="photo">Photo</label>
    <input type="text" name="photo" class="form-control" value="{{ old('photo', $movie->photo ?? '') }}" required>
</div>

<div class="form-group">
    <label for="progress_time">Progress Time</label>
    <input type="number" name="progress_time" class="form-control" value="{{ old('progress_time', $movie->progress_time ?? 0) }}" required>
</div>

<div class="form-group">
    <label for="category_id">Category</label>
    <select name="category_id" class="form-control" required>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ (old('category_id', $movie->category_id ?? '') == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
        @endforeach
    </select>
</div>

<button type="submit" class="btn btn-primary">{{ $submitButtonText }}</button>
<a href="{{ route('movies.index') }}" class="btn btn-secondary">Cancel</a>
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
