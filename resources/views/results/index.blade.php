@php
    $layout = match (auth()->user()->type) {
        'admin' => 'layouts.mainAdmin-layout',
        'parent' => 'layouts.mainParent-layout',
        'student' => 'layouts.main-layout',
    };
@endphp

@extends($layout)

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Manage Student Results</h2>
            </div>
            <div class="pull-right">
                @if(Auth::check() && Auth::user()->type === 'admin')
                    <a class="btn btn-success" href="{{ route('results.create') }}">Create New Result</a>
                @endif
            </div>
        </div>
    </div>

    <!-- Search Form -->
    <form action="{{ route('results.index') }}" method="GET" class="my-4">
        <div class="input-group">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by name, class, or subject">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Class</th>
            <th>Subject</th>
            <th>Type of Assessment</th>
            <th>Score</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($results as $result)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $result->student_name }}</td>
                <td>{{ $result->student_class }}</td>
                <td>{{ $result->assessment_subject }}</td>
                <td>{{ $result->assessment_type }}</td>
                <td>{{ $result->marks }}</td>
                <td>
                    <form action="{{ route('results.destroy', $result->id) }}" method="POST">
                        <a class="btn btn-info" href="{{ route('results.show', $result->id) }}">Show</a>

                        @if(Auth::check() && Auth::user()->type === 'admin')
                            <a class="btn btn-primary" href="{{ route('results.edit', $result->id) }}">Edit</a>

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">Delete</button>
                        @endif
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    <!-- Updated Pagination -->
    {!! $results->links('pagination::bootstrap-4') !!}
@endsection
