@php
    $layout = match (auth()->user()->type) {
        'admin', 'kafa_admin' => 'layouts.mainAdmin-layout',
        'muip_admin' => 'layouts.mainAdmin-layout', // kalau MUIP juga guna same layout
        'parent' => 'layouts.mainParent-layout',
        'student' => 'layouts.main-layout',
        default => 'layouts.mainAdmin-layout',
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
    <img id="previewImage" style="margin-top:10px; width:150px; border-radius:10px;"
         src="{{ asset('images/' . $bulletin->bulletin_image) }}"
         alt="{{ $bulletin->bulletin_title }}">
</div>

<script>
    const inputFile = document.getElementById('customFile');
    const preview = document.getElementById('previewImage');

    inputFile.addEventListener('change', function(event) {
        const [file] = inputFile.files;
        if (file) {
            preview.src = URL.createObjectURL(file); // update preview
        }
    });
</script>

            <div class="form-group">
                <label for="bulletin_desc">Description:</label>
                <textarea name="bulletin_desc" class="form-control">{{ $bulletin->bulletin_desc }}</textarea>
            </div>

            <div class="form-group">
                <label for="bulletin_category">Category:</label>
                <select name="bulletin_category" id="bulletin_category" class="form-control">
                    <option value="Events" {{ strtolower($bulletin->bulletin_category) == 'events' ? 'selected' : '' }}>Events</option>
                    <option value="Announcement" {{ strtolower($bulletin->bulletin_category) == 'announcement' ? 'selected' : '' }}>Announcement</option>
                    <option value="News" {{ strtolower($bulletin->bulletin_category) == 'news' ? 'selected' : '' }}>News</option>
                </select>
            </div>

            {{-- EVENT FIELDS --}}
            <div id="event-fields" style="display:none;">
                <label>Event Date</label>
                <input type="date" name="event_date" class="form-control" value="{{ $bulletin->event_date }}">

                <label class="mt-2">Time</label>
                <input type="time" name="event_time" class="form-control" value="{{ $bulletin->event_time }}">
            </div>

            {{-- ANNOUNCEMENT FIELDS --}}
            <div id="announcement-fields" style="display:none;">
                <label>Date From</label>
                <input type="date" name="start_date" class="form-control" value="{{ $bulletin->start_date }}">

                <label class="mt-2">Date To</label>
                <input type="date" name="end_date" class="form-control" value="{{ $bulletin->end_date }}">
            </div>

            {{-- NEWS FIELDS --}}
            <div id="news-fields" style="display:none;">
                <label>News Date</label>
                <input type="date" name="news_date" class="form-control" value="{{ $bulletin->news_date }}">
            </div>

        </div>
        <div class="card-footer d-flex justify-content-end">
            <button type="submit" class="btn btn-primary mr-2">Save</button>
            <a class="btn btn-secondary" href="{{ route('bulletin.indexBulletinAdmin') }}">Cancel</a>
        </div>
    </div>
</form>

<script>
function showCategoryFields() {
    const category = document.getElementById('bulletin_category').value;

    document.getElementById('event-fields').style.display = 'none';
    document.getElementById('announcement-fields').style.display = 'none';
    document.getElementById('news-fields').style.display = 'none';

    if(category === 'Events') document.getElementById('event-fields').style.display = 'block';
    if(category === 'Announcement') document.getElementById('announcement-fields').style.display = 'block';
    if(category === 'News') document.getElementById('news-fields').style.display = 'block';
}

// run on change
document.getElementById('bulletin_category').addEventListener('change', showCategoryFields);

// run on page load to show correct fields
document.addEventListener('DOMContentLoaded', showCategoryFields);
</script>

@endsection
