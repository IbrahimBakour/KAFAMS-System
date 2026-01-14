@php
    $layout = 'layouts.mainMuipAdmin-layout';
@endphp

@extends($layout)

@section('content')

<div class="container">

    {{-- HEADER --}}
    <div class="row mb-4">
        <div class="col-lg-12 d-flex justify-content-between">
            <h2>MUIP Bulletin Approval</h2>
            <a href="{{ route('bulletin.createBulletinMUIP') }}" class="btn btn-success">
                Create Bulletin
            </a>

        </div>
    </div>

            @if(session('success'))
            <div id="success-alert" class="alert alert-success">
                {{ session('success') }}
            </div>

            <script>
                setTimeout(function () {
                    const alert = document.getElementById('success-alert');
                    if (alert) {
                        alert.style.transition = "opacity 0.5s ease";
                        alert.style.opacity = "0";

                        setTimeout(() => {
                            alert.remove();
                        }, 500);
                    }
                }, 3000); // 🔥 3 saat sahaja
            </script>
        @endif


   {{-- FILTER & SORT --}}
<form method="GET" action="{{ route('bulletin.indexMUIPAdmin') }}" class="mb-4">
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


    {{-- BULLETIN LIST --}}
    <div class="row">
        @foreach ($bulletins as $bulletin)

        {{-- CARD --}}
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
                    <small class="text-muted d-block mb-2">
                        Created by:
                        <strong>{{ strtoupper(str_replace('_',' ', $bulletin->created_by)) }}</strong>
                    </small>

                    <h5>{{ $bulletin->bulletin_title }}</h5>

                    <p class="bulletin-desc">
                        {{ Str::limit($bulletin->bulletin_desc, 120) }}
                    </p>

                    <small class="text-muted">
                        {{ $bulletin->created_at->format('d M Y') }}
                    </small>

                </div>
            </div>
        </div>

        {{-- MODAL --}}
        <div class="modal fade" id="bulletinModal{{ $bulletin->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    {{-- MODAL HEADER (TITLE CENTER) --}}
                    <div class="modal-header justify-content-center position-relative">
                        <h5 class="modal-title text-center w-100">
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

                        {{-- IMAGE CENTER --}}
                        <img src="{{ asset('images/' . $bulletin->bulletin_image) }}"
                             class="img-fluid rounded mb-3 mx-auto d-block">

                        {{-- STATUS --}}
                        @if($bulletin->status === 'pending')
                            <span class="badge badge-warning mb-2">PENDING APPROVAL</span>
                        @elseif($bulletin->status === 'approved')
                            <span class="badge badge-success mb-2">APPROVED</span>
                        @elseif($bulletin->status === 'rejected')
                            <span class="badge badge-danger mb-2">REJECTED</span>
                        @endif

                        {{-- CREATED BY --}}
                        <p class="text-muted mb-2">
                            Created by:
                            <strong>{{ strtoupper(str_replace('_',' ', $bulletin->created_by)) }}</strong>
                        </p>

                        {{-- DESCRIPTION --}}
                        <div style="max-height:300px; overflow-y:auto;">
                            <p class="bulletin-desc" style="white-space: pre-line;">
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

                       

                        <p>
                            <strong>Bulletin Created at:</strong>
                            {{ $bulletin->created_at->format('d M Y, h:i A') }}
                        </p>


                    </div>

                    {{-- MODAL FOOTER (ACTIONS) --}}
                    <div class="modal-footer">

                        {{-- APPROVE (MUIP → KAFA BULLETIN SAHAJA) --}}
                       @if($bulletin->status === 'pending' && $bulletin->created_by === 'kafa_admin')

                            {{-- APPROVE --}}
                            <form action="{{ url('bulletin/approve/'.$bulletin->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-success">
                                    Approve
                                </button>
                            </form>

                            {{-- REJECT --}}
                            <form action="{{ route('bulletin.reject', $bulletin->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to reject this bulletin?')">
                                    Reject
                                </button>
                            </form>

                        @endif

                                                {{-- EDIT / DELETE (MUIP BULLETIN SAHAJA) --}}
                        @if($bulletin->created_by !== 'kafa_admin')
               <a href="{{ route('bulletin.editMUIP', $bulletin->id) }}"
   class="btn btn-primary">
    Edit
</a>


                            <form action="{{ route('bulletin.destroy', $bulletin->id) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger"
                                        onclick="return confirm('Delete this bulletin?')">
                                    Delete
                                </button>
                            </form>
                        @endif

                        <button class="btn btn-secondary" data-dismiss="modal">
                            Close
                        </button>

                    </div>

                </div>
            </div>
        </div>

        @endforeach
    </div>
</div>
@endsection

{{-- STYLE --}}
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

.bulletin-desc {
    text-align: justify;
    text-justify: inter-word;
}
</style>
