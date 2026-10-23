<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Placement;

class PlacementController extends Controller
{
    public function approvePlacement($id)
    {
        $placement = Placement::findOrFail($id);
        $placement->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Penempatan PKL berhasil divalidasi!');
    }
}