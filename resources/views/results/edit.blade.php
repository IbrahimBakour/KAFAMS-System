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
                <h2>Edit Result</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('results.index') }}"> Back</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('results.update',$result->id) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="student_name" value="{{ $result->student_name }}" class="form-control" placeholder="student_name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Class:</strong>
                    <textarea class="form-control" style="height:150px" name="student_class" placeholder="student_class">{{ $result->student_class }}</textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Subject:</strong>
                    <textarea class="form-control" style="height:150px" name="assessment_subject" placeholder="assessment_subject">{{ $result->assessment_subject }}</textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Type of assessment:</strong>
                    <textarea class="form-control" style="height:150px" name="assessment_type" placeholder="assessment_type">{{ $result->assessment_type }}</textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Score:</strong>
                    <textarea class="form-control" style="height:150px" name="marks" placeholder="marks">{{ $result->marks }}</textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>

    </form>
@endsection
