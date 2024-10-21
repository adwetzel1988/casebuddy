@extends('layouts.app')

@section('title', 'My Reports')

@section('content')
    <h1>My Cases</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Case Number</th>
                <th>Status</th>
                <th>filing Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($complaints as $complaint)
                <tr>
                    <td>{{ $complaint->complaint_number }}</td>
                    <td>{{ ucfirst($complaint->status) }}</td>
                    <td>{{ $complaint->incident_date }}</td>
                    <td>
                        <a href="{{ route('complaints.show', $complaint) }}" class="btn btn-sm btn-primary">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection