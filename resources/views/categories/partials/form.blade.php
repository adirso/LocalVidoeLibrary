<!-- resources/views/categories/partials/form.blade.php -->

<div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $category->name ?? '') }}" required>
</div>

<button type="submit" class="btn btn-primary">{{ $submitButtonText }}</button>
<a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

