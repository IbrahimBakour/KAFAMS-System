@php
    $layout = match (auth()->user()->type) {
        'admin' => 'layouts.mainAdmin-layout',
        'parent' => 'layouts.mainParent-layout',
        'student' => 'layouts.main-layout',
    };
@endphp

@extends($layout)

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>List Of Bulletins</h2>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg-12">
            <form action="{{ route('bulletin.indexBulletin') }}" method="GET" class="form-inline">
                <div class="form-group mx-sm-3 mb-2">
                    <label for="category" class="mr-2">Filter by Category:</label>
                    <select name="category" id="category" class="form-control">
                        <option value="all" {{ $category == 'all' ? 'selected' : '' }}>All</option>
                        <option value="events" {{ $category == 'events' ? 'selected' : '' }}>Events</option>
                        <option value="announcement" {{ $category == 'announcement' ? 'selected' : '' }}>Announcement</option>
                        <option value="news" {{ $category == 'news' ? 'selected' : '' }}>News</option>
                    </select>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="sort" class="mr-2">Sort by:</label>
                    <select name="sort" id="sort" class="form-control" onchange="this.form.submit()">
                        <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Newest</option>
                        <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Oldest</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mb-2">Filter</button>
            </form>
        </div>
    </div>

    <div class="row">
        @foreach ($bulletins as $bulletin)
            <div class="col-md-4 d-flex align-items-stretch mb-4">
                <!-- Bulletin Card -->
                <div class="card flex-fill shadow-sm border-light" data-toggle="modal" data-target="#bulletinModal{{ $bulletin->id }}">
                    <img src="{{ asset('images/' . $bulletin->bulletin_image) }}" class="card-img-top bulletin-image" alt="{{ $bulletin->bulletin_title }}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $bulletin->bulletin_title }}</h5>
                        <p class="card-text">{{ Str::limit($bulletin->bulletin_desc, 150) }}</p>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="bulletinModal{{ $bulletin->id }}" tabindex="-1" role="dialog" aria-labelledby="bulletinModalLabel{{ $bulletin->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="bulletinModalLabel{{ $bulletin->id }}">{{ $bulletin->bulletin_title }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <img src="{{ asset('images/' . $bulletin->bulletin_image) }}" class="img-fluid" alt="{{ $bulletin->bulletin_title }}">
                                <p>{{ $bulletin->bulletin_desc }}</p>
                                <p><strong>Category:</strong> {{ $bulletin->bulletin_category }}</p>
                                <p><strong>Date Created:</strong> {{ $bulletin->created_at->format('F j, Y') }}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
 </div>
</div>
@endsection

<style>
    .bulletin-image {
        height: 200px; /* Set a fixed height for the images */
        object-fit: cover; /* Ensure the image covers the area without distortion */
    }

    .card {
        transition: transform 0.2s;
        height: 100%; /* Ensure cards take full height of the column */
    }

    .card:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .modal-body img {
        max-width: 100%; /* Ensure modal image is responsive */
        height: auto; /* Maintain aspect ratio */
    }
</style>