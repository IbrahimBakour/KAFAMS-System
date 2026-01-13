@php
    $layout = match (auth()->user()->type) {
        'admin' => 'layouts.mainAdmin-layout',
        'parent' => 'layouts.mainParent-layout',
        'student' => 'layouts.main-layout',
    };
@endphp

@extends($layout)

@section('content')
<div class="row mb-4">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Edit Bulletin</h2>
        </div>
    </div>
</div>

<style>
    .form-control, .custom-file-label {
        border: 2px solid black;
        height: auto;
    }

    .card-header {
        border-bottom: 2px solid black;
    }

    .card {
        border: 2px solid black;
        border-radius: 10px;
    }

    .btn-primary {
        width: 100px;
    }
</style>

@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif

<form action="{{ route('bulletin.update', $bulletin->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('POST')
    <div style="border: 2px solid black;" class="card">
        <div class="card-header">
            <strong>Edit Bulletin</strong>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="bulletin_title">Bulletin Title:</label>
                <input type="text" name="bulletin_title" class="form-control" value="{{ $bulletin->bulletin_title }}">
            </div>
            <div class="form-group">
                <label for="bulletin_image">Bulletin Image:</label>
                <div class="custom-file">
                    <input type="file" name="bulletin_image" class="custom-file-input" id="customFile">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
                <img style="margin-top:10px; width:150px; border-radius:10px;" src="{{ asset('images/' . $bulletin->bulletin_image) }}" width="100" alt="{{ $bulletin->bulletin_title }}">
            </div>
            <div class="form-group">
                <label for="bulletin_desc">Description:</label>
                <textarea name="bulletin_desc" class="form-control">{{ $bulletin->bulletin_desc }}</textarea>
            </div>
            <div class="form-group">
                <label for="bulletin_category">Category:</label>
                <select name="bulletin_category" class="form-control">
                    <option value="Events" {{ $bulletin->bulletin_category == 'events' ? 'selected' : '' }}>Events</option>
                    <option value="Announcement" {{ $bulletin->bulletin_category == 'announcement' ? 'selected' : '' }}>Announcement</option>
                    <option value="News" {{ $bulletin->bulletin_category == 'news' ? 'selected' : '' }}>News</option>
                </select>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <button type="submit" class="btn btn-primary mr-2">Save</button>
            <a class="btn btn-secondary" href="{{ route('bulletin.indexBulletinAdmin') }}">Cancel</a>
        </div>
    </div>
</form>
@endsection
