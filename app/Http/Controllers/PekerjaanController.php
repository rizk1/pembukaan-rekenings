<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Pekerjaan;

class PekerjaanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {
            if(request()->ajax()) {
                $data = Datatables::of(Pekerjaan::orderBy('id', 'desc'))
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $editButton = '<button class="btn btn-primary btn-sm edit-pekerjaan" data-id="'.$row->id.'"><i class="fas fa-pencil-alt"></i></button>';
                        if (!$row->pembukaanRekenings()->exists()) {
                            $deleteButton = '&nbsp;<button class="btn btn-danger btn-sm delete-pekerjaan" data-id="'.$row->id.'"><i class="fas fa-trash"></i></button>';
                        } else {
                            $deleteButton = '';
                        }
                        
                        return $editButton . $deleteButton;
                    })
                    ->orderColumn('DT_RowIndex', function ($query, $order) {
                        $query->orderBy('id', $order);
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                return $data;
            }
            return view('pekerjaan.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_pekerjaan' => 'required|string|unique:pekerjaans,nama_pekerjaan',
            ]);

            Pekerjaan::create($request->all());
            return response()->json(['success' => 'Pekerjaan created successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $pekerjaan = Pekerjaan::find($id);
        return response()->json($pekerjaan);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama_pekerjaan' => 'required|string|unique:pekerjaans,nama_pekerjaan,'.$id,
            ]);
            Pekerjaan::find($id)->update($request->all());
            return response()->json(['success' => 'Pekerjaan updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            Pekerjaan::find($id)->delete();
            return response()->json(['success' => 'Pekerjaan deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
