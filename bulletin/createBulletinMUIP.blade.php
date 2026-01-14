@php
    $layout = 'layouts.mainAdmin-layout';
    $cancelRoute = route('bulletin.indexMUIPAdmin');
@endphp

@extends($layout)

@section('content')
<div class="row mb-4">
    <div class="col-lg-12 margin-tb">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Create Bulletin (MUIP Admin)</h2>
        </div>
    </div>
</div>

{{-- STYLE --}}
<style>
    .form-control, .custom-file-label {
        border: 2px solid #00796B; /* MUIP green */
        height: auto;
    }

    .card-header {
        border-bottom: 2px solid #00796B;
        background-color: #00796B; /* MUIP darker header */
        color: white;
    }

    .card {
        border: 2px solid #00796B;
        border-radius: 10px;
    }

    .btn-primary {
        width: 100px;
        background-color: #00796B;
        border-color: #00796B;
    }

    .btn-primary:hover {
        background-color: #004d40;
        border-color: #004d40;
    }

    .btn-secondary {
        width: 100px;
    }
</style>

{{-- SUCCESS MESSAGE --}}
@if ($message = Session::get('success'))
    <div id="success-alert" class="alert alert-success">{{ $message }}</div>
    <script>
        setTimeout(function() {
            const alert = document.getElementById('success-alert');
            if(alert){
                alert.style.transition = "opacity 0.5s";
                alert.style.opacity = "0";
                setTimeout(() => alert.remove(), 500);
            }
        }, 3000);
    </script>
@endif

<form action="{{ route('bulletin.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card shadow-sm">
        <div class="card-header">
            <strong>Fill in the form</strong>
        </div>
        <div class="card-body">
            {{-- TITLE --}}
            <div class="form-group">
                <label for="bulletin_title">Bulletin Title:</label>
                <input type="text" name="bulletin_title" class="form-control" placeholder="Enter title">
            </div>

            {{-- IMAGE --}}
            <div class="form-group">
                <label for="bulletin_image">Bulletin Image:</label>
                <input type="file" name="bulletin_image" class="form-control" style="height:auto;">
            </div>

            {{-- DESCRIPTION --}}
            <div class="form-group">
                <label for="bulletin_desc">Description:</label>
                <textarea name="bulletin_desc" class="form-control" placeholder="Enter description" rows="5"></textarea>
            </div>

            {{-- CATEGORY --}}
            <div class="form-group">
                <label for="bulletin_category">Category:</label>
                <select name="bulletin_category" id="bulletin_category" class="form-control">
                    <option value="Events">Events</option>
                    <option value="Announcement">Announcement</option>
                    <option value="News">News</option>
                </select>
            </div>

            {{-- EVENT FIELDS --}}
            <div id="event-fields" style="display:none;">
                <label>Event Date</label>
                <input type="date" name="event_date" class="form-control">
                <label class="mt-2">Time</label>
                <input type="time" name="event_time" class="form-control">
            </div>

            {{-- ANNOUNCEMENT FIELDS --}}
            <div id="announcement-fields" style="display:none;">
                <label>Date From</label>
                <input type="date" name="start_date" class="form-control">
                <label class="mt-2">Date To</label>
                <input type="date" name="end_date" class="form-control">
            </div>

            {{-- NEWS FIELDS --}}
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

{{-- SCRIPT TO TOGGLE CATEGORY FIELDS --}}
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

document.getElementById('bulletin_category').addEventListener('change', showCategoryFields);
document.addEventListener('DOMContentLoaded', showCategoryFields);
</script>
@endsection
