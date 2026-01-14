
@extends('layouts.app')
@section('content')
<h2>Dashboard Ibu Bapa</h2>
@foreach($profiles as $p)
  <div class="card mb-3">
    <div class="card-body">
      <h5>{{ $p->student_name }} — Tahap {{ $p->tahap }} (Std {{ $p->standard }})</h5>
      <p>Kelas: {{ optional($p->class)->name }} — Guru: {{ optional($p->class?->teacher)->name }}</p>
      <span class="badge bg-secondary">{{ $p->profile_status ?? '—' }}</span>
      <a class="btn btn-sm btn-primary mt-2" href="{{ route('profile.view', $p->id) }}">Lihat Profil</a>
    </div>
  </div>
@endforeach
@endsection
