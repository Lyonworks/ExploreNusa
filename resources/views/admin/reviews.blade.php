@extends('layouts.admin')
@section('title', 'Manage Reviews')

@section('content')
    <h2 class="fw-bold mb-4">Reviews</h2>

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
                        {{-- Delete --}}
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
