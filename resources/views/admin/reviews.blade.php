@extends('layouts.admin')
@section('title', 'Manage Reviews')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Manage Reviews</h3>

        <form action="{{ route('reviews.index') }}" method="GET" class="d-flex gap-2">
            <select name="destination_id" class="form-select form-select-sm">
                <option value="">All Destinations</option>
                @foreach($destinations as $destination)
                    <option value="{{ $destination->id }}"
                        {{ request('destination_id') == $destination->id ? 'selected' : '' }}>
                        {{ $destination->name }}
                    </option>
                @endforeach
            </select>

            <select name="rating" class="form-select form-select-sm">
                <option value="">All Ratings</option>
                @for($i=5; $i>=1; $i--)
                    <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                        {{ $i }} Stars
                    </option>
                @endfor
            </select>

            <button type="submit" class="btn btn-theme btn-sm">Filter</button>
            <a href="{{ route('reviews.index') }}" class="btn btn-theme btn-sm">Reset</a>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead>
                <tr class="text-center">
                    <th>User</th>
                    <th>Destination</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reviews as $review)
                <tr class="text-center">
                    <td>
                        @if($review->user)
                            {{ $review->user->name }}
                        @else
                            {{ $review->guest_name ?? 'Guest' }}
                        @endif
                    </td>
                    <td>{{ $review->destination->name }}</td>
                    <td>{{ $review->rating }}</td>
                    <td>{{ $review->review }}</td>
                    <td>
                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
