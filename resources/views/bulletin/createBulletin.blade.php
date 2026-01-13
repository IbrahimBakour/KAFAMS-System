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
    <div class="col-lg-12 margin-tb">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Create Bulletin</h2>
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

<form action="{{ route('bulletin.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card shadow-sm">
        <div class="card-header">
            <strong>Fill in the form</strong>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="bulletin_title">Bulletin Title:</label>
                <input type="text" name="bulletin_title" class="form-control" placeholder="Enter title">
            </div>
            <div class="form-group">
                <label for="bulletin_image">Bulletin Image:</label>
                <input style="height: auto;" type="file" name="bulletin_image" class="form-control">
            </div>
            <div class="form-group">
                <label for="bulletin_desc">Description:</label>
                <textarea name="bulletin_desc" class="form-control" placeholder="Enter description" rows="5"></textarea>
            </div>
            <div class="form-group">
                <label for="bulletin_category">Category:</label>
                <select name="bulletin_category" class="form-control">
                    <option value="Events">Events</option>
                    <option value="Announcement">Announcement</option>
                    <option value="News">News</option>
                </select>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <button type="submit" class="btn btn-primary mr-2">Create</button>
            <a class="btn btn-secondary" href="{{ route('bulletin.indexBulletinAdmin') }}">Cancel</a>
        </div>
    </div>
</form>
@endsection
