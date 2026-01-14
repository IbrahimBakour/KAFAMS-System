
@extends('layouts.mainTeacher-layout')

@section('content')
<div class="container">

    {{-- HEADER --}}
    <div class="row mb-4">
        <div class="col-lg-12">
            <h2>List Of Bulletins</h2>
        </div>
    </div>

    {{-- FILTER & SORT --}}
    <form method="GET" action="{{ route('bulletin.indexBulletin') }}" class="mb-4">
        <div class="row align-items-end">
            <div class="col-md-4">
                <label class="font-weight-bold">Category</label>
                <select name="category" class="form-control">
                    <option value="all" {{ request('category') == 'all' ? 'selected' : '' }}>All</option>
                    <option value="News" {{ request('category') == 'News' ? 'selected' : '' }}>News</option>
                    <option value="Events" {{ request('category') == 'Events' ? 'selected' : '' }}>Events</option>
                    <option value="Announcements" {{ request('category') == 'Announcements' ? 'selected' : '' }}>Announcements</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="font-weight-bold">Sort By</label>
                <select name="sort" class="form-control">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                </select>
            </div>

            <div class="col-md-4">
                <button class="btn btn-primary w-100">Apply Filter</button>
            </div>
        </div>
    </form>

    {{-- BULLETIN GRID --}}
    <div class="row">
        @foreach ($bulletins as $bulletin)
            @php
               $canView =
    $bulletin->status === 'approved' ||
    ($user && $user->type === 'kafa_admin' && $bulletin->created_by === 'kafa_admin');

            @endphp

            @if($canView)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm bulletin-card" data-toggle="modal" data-target="#bulletinModal{{ $bulletin->id }}">
                    <img src="{{ asset('images/' . $bulletin->bulletin_image) }}" class="card-img-top bulletin-image">
                    <div class="card-body text-center">
                        @if($bulletin->status === 'pending')
                            <span class="badge badge-warning mb-2">PENDING APPROVAL</span>
                        @endif

                        <h5 class="card-title">{{ $bulletin->bulletin_title }}</h5>
                        <p class="card-text">{{ Str::limit($bulletin->bulletin_desc, 120) }}</p>
                        <small class="text-muted">{{ $bulletin->created_at->format('d M Y') }}</small>
                    </div>
                </div>
            </div>

            {{-- MODAL --}}
            <div class="modal fade" id="bulletinModal{{ $bulletin->id }}">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header justify-content-center position-relative">
                            <h5 class="modal-title w-100 text-center">{{ $bulletin->bulletin_title }}</h5>
                            <button type="button" class="close position-absolute" style="right:15px" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="{{ asset('images/' . $bulletin->bulletin_image) }}" class="img-fluid rounded mb-3 mx-auto d-block">
                            @if($bulletin->status === 'pending')
                                <span class="badge badge-warning mb-3">PENDING APPROVAL</span>
                            @endif
                            <p class="bulletin-desc-modal">{{ $bulletin->bulletin_desc }}</p>
                            <hr>

                                <p><strong>Category:</strong> {{ $bulletin->bulletin_category }}</p>

                                {{-- EVENTS --}}
                                @if($bulletin->bulletin_category === 'Events')
                                    <p>
                                        <strong>Event Date:</strong>
                                        {{ \Carbon\Carbon::parse($bulletin->event_date)->format('d M Y') }}
                                    </p>

                                    @if($bulletin->event_time)
                                        <p>
                                            <strong>Time:</strong>
                                            {{ \Carbon\Carbon::parse($bulletin->event_time)->format('h:i A') }}
                                        </p>
                                    @endif

                                {{-- ANNOUNCEMENT --}}
                                @elseif($bulletin->bulletin_category === 'Announcement')
                                    <p>
                                        <strong>Date From:</strong>
                                        {{ \Carbon\Carbon::parse($bulletin->start_date)->format('d M Y') }}
                                    </p>

                                    @if($bulletin->end_date)
                                        <p>
                                            <strong>Date To:</strong>
                                            {{ \Carbon\Carbon::parse($bulletin->end_date)->format('d M Y') }}
                                        </p>
                                    @endif

                                {{-- NEWS --}}
                                @elseif($bulletin->bulletin_category === 'News')
                                    <p>
                                        <strong>Date:</strong>
                                        {{ \Carbon\Carbon::parse($bulletin->news_date)->format('d M Y') }}
                                    </p>
                                @endif

                                <p>
                                    <strong>Bulletin Created at:</strong>
                                    {{ $bulletin->created_at->format('d M Y, h:i A') }}
                                </p>
                                                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </div>
</div>
@endsection

<style>
.bulletin-card {
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
}

.bulletin-card .card-text {
    text-align: justify;
    text-justify: inter-word;
}

.bulletin-card:hover {
    transform: scale(1.03);
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
}

.bulletin-image {
    height: 200px;
    object-fit: cover;
}

.bulletin-desc-modal {
    max-height: 300px;
    overflow-y: auto;
    text-align: justify;
    white-space: pre-line;
    padding: 0 5px;
}
</style>
