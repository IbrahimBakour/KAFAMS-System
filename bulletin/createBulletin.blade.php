@php
    $layout = match (auth()->user()->type) {
    'muip_admin' => 'layouts.mainAdmin-layout',
    'kafa_admin' => 'layouts.mainAdmin-layout',
    'parent' => 'layouts.mainParent-layout',
    'student' => 'layouts.main-layout',
};

 $cancelRoute = match(auth()->user()->type) {
        'kafa_admin' => route('bulletin.indexBulletinAdmin'),
        'muip_admin' => route('bulletin.indexMUIPAdmin'),
        default => url()->previous(),
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
                @if(auth()->user()->type === 'kafa_admin')
<div class="alert alert-warning">
    <strong>Note:</strong> Bulletin created by KAFA Admin requires MUIP Admin approval before it is published.
</div>
@endif

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
                <select name="bulletin_category" class="form-control" id="bulletin_category">
    <option value="Events" selected>Events</option>
    <option value="Announcement">Announcement</option>
    <option value="News">News</option>
</select>

            </div>
            
            <div id="event-fields" style="display:none;">
                <label>Event Date</label>
                <input type="date" name="event_date" class="form-control">

                <label class="mt-2">Time</label>
                <input type="time" name="event_time" class="form-control">
            </div>

            <div id="announcement-fields" style="display:none;">
                <label>Date From</label>
                <input type="date" name="start_date" class="form-control">

                <label class="mt-2">Date To</label>
                <input type="date" name="end_date" class="form-control">
            </div>

            <div id="news-fields" style="display:none;">
                <label>News Date</label>
                <input type="date" name="news_date" class="form-control">
            </div>



        </div>
        <div class="card-footer d-flex justify-content-end">
            <button type="submit" class="btn btn-primary mr-2">Create</button>
<a class="btn btn-secondary" href="{{ $cancelRoute }}">Cancel</a>
        </div>
    </div>
</form>

            <script>
            document.addEventListener('DOMContentLoaded', function () {
                const categorySelect = document.querySelector('[name="bulletin_category"]');

                function toggleFields(category) {
                    document.getElementById('event-fields').style.display = 'none';
                    document.getElementById('announcement-fields').style.display = 'none';
                    document.getElementById('news-fields').style.display = 'none';

                    if (category === 'Events') {
                        document.getElementById('event-fields').style.display = 'block';
                    } else if (category === 'Announcement') {
                        document.getElementById('announcement-fields').style.display = 'block';
                    } else if (category === 'News') {
                        document.getElementById('news-fields').style.display = 'block';
                    }
                }

                // 🔥 RUN SEKALI MASA PAGE LOAD
                toggleFields(categorySelect.value);

                // 🔁 RUN BILA USER TUKAR CATEGORY
                categorySelect.addEventListener('change', function () {
                    toggleFields(this.value);
                });
            });
            </script>



@endsection
