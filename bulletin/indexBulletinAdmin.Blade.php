@php
    $layout = 'layouts.mainAdmin-layout';
@endphp

@extends($layout)

@section('content')
<div class="container">

    {{-- HEADER --}}
    <div class="row mb-4">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h2>List Of Bulletins</h2>
            <a href="{{ route('bulletin.createBulletin') }}" class="btn btn-success">
                Create Bulletin
            </a>
        </div>
    </div>

            {{-- SUCCESS MESSAGE --}}
            @if(session('success'))
            <div id="success-alert" class="alert alert-success">
                {{ session('success') }}
            </div>

            <script>
                setTimeout(function() {
                    const alert = document.getElementById('success-alert');
                    if(alert){
                        alert.style.transition = "opacity 0.5s";
                        alert.style.opacity = "0";
                        setTimeout(() => alert.remove(), 500); // remove after fade
                    }
                }, 3000); // 3000ms = 3 seconds
            </script>
        @endif


    {{-- FILTER & SORT --}}
<form method="GET" action="{{ route('bulletin.indexBulletinAdmin') }}" class="mb-4">
    <div class="row align-items-end">

        {{-- CATEGORY FILTER --}}
        <div class="col-md-4">
            <label class="font-weight-bold">Category</label>
            <select name="category" class="form-control">
                <option value="all" {{ request('category') == 'all' ? 'selected' : '' }}>
                    All
                </option>
                <option value="News" {{ request('category') == 'News' ? 'selected' : '' }}>
                    News
                </option>
                <option value="Events" {{ request('category') == 'Events' ? 'selected' : '' }}>
                    Events
                </option>
                <option value="Announcements" {{ request('category') == 'Announcements' ? 'selected' : '' }}>
                    Announcements
                </option>
            </select>
        </div>

        {{-- SORT --}}
        <div class="col-md-4">
            <label class="font-weight-bold">Sort By</label>
            <select name="sort" class="form-control">
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>
                    Latest
                </option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                    Oldest
                </option>
            </select>
        </div>

        {{-- SUBMIT --}}
        <div class="col-md-4">
            <button class="btn btn-primary w-100">
                Apply Filter
            </button>
        </div>

    </div>
</form>


    {{-- BULLETIN GRID --}}
    <div class="row">
        @foreach ($bulletins as $bulletin)

        {{-- ================= CARD ================= --}}
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm bulletin-card"
                 data-toggle="modal"
                 data-target="#bulletinModal{{ $bulletin->id }}">

                <img src="{{ asset('images/' . $bulletin->bulletin_image) }}"
                     class="card-img-top bulletin-image">

                <div class="card-body text-center">

                    {{-- STATUS --}}
@if($bulletin->status === 'pending')
    <span class="badge badge-warning mb-2">PENDING APPROVAL</span>
@elseif($bulletin->status === 'approved')
    <span class="badge badge-success mb-2">APPROVED</span>
@elseif($bulletin->status === 'rejected')
    <span class="badge badge-danger mb-2">REJECTED</span>
@endif

                    {{-- CREATED BY --}}
                    @if($bulletin->created_by === 'muip_admin')
                        <small class="text-info d-block mb-1">
                            Created by <strong>MUIP Admin</strong>
                        </small>
                    @endif

                    <h5 class="mt-2">{{ $bulletin->bulletin_title }}</h5>

                    <p class="bulletin-desc">
                        {{ Str::limit($bulletin->bulletin_desc, 120) }}
                    </p>

                    <small class="text-muted">
                        {{ $bulletin->created_at->format('d M Y') }}
                    </small>

                </div>
            </div>
        </div>

        {{-- ================= MODAL ================= --}}
        <div class="modal fade" id="bulletinModal{{ $bulletin->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    {{-- MODAL HEADER --}}
                    <div class="modal-header justify-content-center position-relative">
                        <h5 class="modal-title w-100 text-center">
                            {{ $bulletin->bulletin_title }}
                        </h5>
                        <button type="button"
                                class="close position-absolute"
                                style="right:15px"
                                data-dismiss="modal">
                            &times;
                        </button>
                    </div>

                    {{-- MODAL BODY --}}
                    <div class="modal-body text-center">

                        <img src="{{ asset('images/' . $bulletin->bulletin_image) }}"
                             class="img-fluid rounded mb-3 mx-auto d-block">

                                          {{-- STATUS --}}
                                @if($bulletin->status === 'pending')
                                    <span class="badge badge-warning mb-3">PENDING APPROVAL</span>
                                @elseif($bulletin->status === 'approved')
                                    <span class="badge badge-success mb-3">APPROVED</span>
                                @elseif($bulletin->status === 'rejected')
                                    <span class="badge badge-danger mb-3">REJECTED</span>
                                @endif

                                {{-- CREATED BY --}}
                                @if($bulletin->created_by === 'muip_admin')
                                    <p class="text-info mb-4">
                                        <strong>Created by:</strong> MUIP Admin
                                    </p>
                                @endif


                        {{-- DESCRIPTION --}}
                      <div class="bulletin-desc-modal">
    <p>
        {{ $bulletin->bulletin_desc }}
    </p>
</div>

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

                        <hr>

                        <p>
                            <strong>Bulletin Created at:</strong>
                            {{ $bulletin->created_at->format('d M Y, h:i A') }}
                        </p>


                           
                    </div>

                    {{-- MODAL FOOTER --}}
                    <div class="modal-footer">

                        {{-- EDIT & DELETE (KAFA ADMIN SAHAJA + BULLETIN SENDIRI) --}}
                        @if(auth()->user()->type === 'kafa_admin' && $bulletin->created_by === 'kafa_admin')
                            <a href="{{ route('bulletin.updateBulletin', $bulletin->id) }}"
                               class="btn btn-primary btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('bulletin.destroy', $bulletin->id) }}"
                                  method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete this bulletin?')">
                                    Delete
                                </button>
                            </form>
                        @endif

                        <button class="btn btn-secondary btn-sm" data-dismiss="modal">
                            Close
                        </button>

                    </div>

                </div>
            </div>
        </div>
        {{-- =============== END MODAL =============== --}}

        @endforeach
    </div>
</div>
@endsection

{{-- ================= STYLE ================= --}}
<style>
.bulletin-card {
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
}

.bulletin-card:hover {
    transform: scale(1.03);
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
}

.bulletin-image {
    height: 200px;
    object-fit: cover;
}


</style>
