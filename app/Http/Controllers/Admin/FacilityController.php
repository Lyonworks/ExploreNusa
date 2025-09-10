<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    // GET /api/admin/facilities
    public function index()
    {
        return response()->json(
            Facility::with('destination:id,facility')
                ->latest()->paginate(50)
        );
    }

    // POST /api/admin/facilities
    public function store(Request $request)
    {
        $data = $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'facility' => 'required|string|max:100',
        ]);
        $facility = Facility::create($data);
        return response()->json(['message' => 'Fasilitas dibuat','data' => $facility], 201);
    }

    // POST /api/admin/facilities/{id}
    public function update(Request $request, $id)
    {
        $facility = Facility::findOrFail($id);
        $data = $request->validate([
            'destination_id' => 'sometimes|exists:destinations,id',
            'facility' => 'sometimes|string|max:100',
        ]);
        $facility->update($data);
        return response()->json(['message' => 'Fasilitas diupdate','data' => $facility]);
    }

    // GET /api/admin/facilities/delete/{id}  (as requested)
    // Also support DELETE /api/admin/facilities/{id}
    public function destroy($id)
    {
        $facility = Facility::findOrFail($id);
        $facility->delete();
        return response()->json(['message' => 'Fasilitas dihapus']);
    }
}
