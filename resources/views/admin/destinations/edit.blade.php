@extends('layouts.admin')
@section('title','Edit Destination')

@section('content')
<div class="container">
  <h2 class="fw-bold mb-4">Edit Destination</h2>

  <form action="{{ route('destinations.update', $destination->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label class="form-label fw-semibold">Name</label>
      <input type="text" name="name" class="form-control" value="{{ old('name', $destination->name) }}" required>
    </div>

    <div class="mb-3">
      <label class="form-label fw-semibold">Location</label>
      <input type="text" name="location" class="form-control" value="{{ old('location', $destination->location) }}" required>
    </div>

    <div class="mb-3">
      <label class="form-label fw-semibold">Description</label>
      <textarea name="description" class="form-control" rows="4" required>{{ old('description', $destination->description) }}</textarea>
    </div>

    <div class="mb-3">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <label class="form-label fw-semibold mb-0">Facilities</label>
        <button type="button" class="btn btn-sm btn-theme" id="add-facility-btn">+ Add Facility</button>
      </div>
      
      <div id="facility-container">
        @if(!empty($destination->facilities) && count($destination->facilities) > 0)
          @foreach($destination->facilities as $fac)
            <div class="input-group mb-2 facility-row">
              <input type="text" name="facilities[]" class="form-control" value="{{ $fac }}" placeholder="e.g. Free Wi-Fi, Parking">
              <button type="button" class="btn btn-danger remove-facility-btn">Remove</button>
            </div>
          @endforeach
        @else
          <div class="input-group mb-2 facility-row">
            <input type="text" name="facilities[]" class="form-control" placeholder="e.g. Free Wi-Fi, Parking">
            <button type="button" class="btn btn-danger remove-facility-btn">Remove</button>
          </div>
        @endif
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label fw-semibold">Current Image</label><br>
      @if($destination->image)
        <img src="{{ asset('storage/'.$destination->image) }}" alt="Destination Image" class="img-thumbnail mb-2" width="200">
      @else
        <p class="text-muted">No image uploaded.</p>
      @endif
    </div>

    <div class="mb-3">
      <label class="form-label fw-semibold">Change Image</label>
      <input type="file" name="image" class="form-control" accept="image/*">
    </div>

    <div class="mt-4">
      <button type="submit" class="btn btn-success">Update Destination</button>
      <a href="{{ route('admin.destinations') }}" class="btn btn-secondary">Cancel</a>
    </div>
  </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('facility-container');
    const addBtn = document.getElementById('add-facility-btn');

    addBtn.addEventListener('click', function () {
        const div = document.createElement('div');
        div.className = 'input-group mb-2 facility-row';
        div.innerHTML = `
            <input type="text" name="facilities[]" class="form-control" placeholder="e.g. Free Wi-Fi, Parking">
            <button type="button" class="btn btn-danger remove-facility-btn">Remove</button>
        `;
        container.appendChild(div);
    });

    container.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-facility-btn')) {
            const rows = container.querySelectorAll('.facility-row');
            if (rows.length > 1) {
                e.target.closest('.facility-row').remove();
            } else {
                e.target.closest('.facility-row').querySelector('input').value = '';
            }
        }
    });
});
</script>
@endsection