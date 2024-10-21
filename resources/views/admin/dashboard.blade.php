@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <style>
        .card-link {
            text-decoration: none;
            color: inherit;
        }
    </style>

    <h1>Admin Dashboard</h1>
    <div class="row">
        <div class="col-md-4">
            <a href="{{ route('admin.complaints.index') }}" class="card-link">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Cases</h5>
                        <p class="card-text">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.complaints.index', ['status' => 'detective_assigned']) }}" class="card-link">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Detective Assigned Cases</h5>
                        <p class="card-text">{{ $stats['detective_assigned'] }}</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.complaints.index', ['status' => 'under_investigation']) }}" class="card-link">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Under Investigation Cases</h5>
                        <p class="card-text">{{ $stats['under_investigation'] }}</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-4">
            <a href="{{ route('admin.complaints.index', ['status' => 'warrant_issued']) }}" class="card-link">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Warrant Issued Cases</h5>
                        <p class="card-text">{{ $stats['warrant_issued'] }}</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.complaints.index', ['status' => 'arrest_made']) }}" class="card-link">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Arrest Made Cases</h5>
                        <p class="card-text">{{ $stats['arrest_made'] }}</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.complaints.index', ['status' => 'transferred_to_district_attorney']) }}" class="card-link">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Transferred to D.A. Cases</h5>
                        <p class="card-text">{{ $stats['transferred_to_district_attorney'] }}</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-4">
            <a href="{{ route('admin.complaints.index', ['status' => 'closed']) }}" class="card-link">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Closed Cases</h5>
                        <p class="card-text">{{ $stats['closed'] }}</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="mt-4">
        <a href="{{ route('admin.complaints.index') }}" class="btn btn-primary">View All Cases</a>
    </div>

    <div class="mt-4">
        <h2>Latest Messages</h2>
        @foreach($latestMessages as $message)
            <a href="{{ route('admin.complaints.show', $message->complaint_id) }}" class="card-link">
                <div class="card mb-2">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">{{ $message->sender->name }} - {{ $message->created_at->format('M d, Y H:i') }}</h6>
                        <p class="card-text">{{ $message->content }}</p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    <div class="mt-4">
        <h2>Latest Notes</h2>
        @foreach($latestNotes as $note)
            <a href="{{ route('admin.complaints.show', $note->complaint_id) }}" class="card-link">
                <div class="card mb-2">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">{{ $note->user->name }} - {{ $note->created_at->format('M d, Y H:i') }}</h6>
                        <p class="card-text">{{ $note->content }}</p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@endsection
