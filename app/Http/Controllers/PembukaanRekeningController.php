<?php

namespace App\Http\Controllers;

use App\Models\PembukaanRekening;
use App\Models\Pekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Mail\ApprovalNotification;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class PembukaanRekeningController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = PembukaanRekening::with('pekerjaan');

                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $actionBtn = '';
                        if (Auth::user()->role == 'Supervisi' && $row->status == 'Menunggu Approval') {
                            $actionBtn = '<button class="btn btn-success btn-sm approve-rekening" data-id="'.$row->id.'">Approve</button>&nbsp;';
                            $actionBtn .= '<button class="btn btn-danger btn-sm delete-rekening" data-id="'.$row->id.'"><i class="fas fa-trash"></i></button>';
                        }
                        if (Auth::user()->role == 'CS' && $row->status != 'Disetujui') {
                            $actionBtn .= '<button class="btn btn-primary btn-sm edit-rekening" data-id="'.$row->id.'"><i class="fas fa-pencil-alt"></i></button>';
                        }
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->orderColumn('DT_RowIndex', function ($query, $order) {
                        $query->orderBy('id', $order);
                    })
                    ->make(true);
            }

            $pekerjaans = Pekerjaan::all();
            return view('pembukaan-rekening.index', compact('pekerjaans'));
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => [
                'required',
                'string',
                'unique:pembukaan_rekenings,nama',
                'regex:/^[a-zA-Z\s]+$/',
                'not_regex:/(Profesor|Haji|Hajah)/i',
            ],
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'pekerjaan_id' => 'required|exists:pekerjaans,id',
            'provinsi' => 'required|string|max:255',
            'kabupaten_kota' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kelurahan' => 'required|string|max:255',
            'nama_jalan' => 'required|string|max:255',
            'rt' => 'required|string|max:10',
            'rw' => 'required|string|max:10',
            'nominal_setor' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $request->merge(['created_by' => Auth::id()]);

        $pembukaanRekening = PembukaanRekening::create($request->all());

        return response()->json(['message' => 'Data pembukaan rekening berhasil disimpan', 'data' => $pembukaanRekening], 200);
    }

    public function edit($id)
    {
        try {
            $pembukaanRekening = PembukaanRekening::findOrFail($id);
            return response()->json($pembukaanRekening);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $pembukaanRekening = PembukaanRekening::findOrFail($id);

        if ($pembukaanRekening->status === 'Disetujui') {
            return response()->json(['error' => 'Data pembukaan rekening yang sudah disetujui tidak dapat diedit.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'nama' => [
                'required',
                'string',
                'unique:pembukaan_rekenings,nama,'.$id,
                'regex:/^[a-zA-Z\s]+$/',
                'not_regex:/(Profesor|Haji)/i',
            ],
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'pekerjaan_id' => 'required|exists:pekerjaans,id',
            'provinsi' => 'required|string|max:255',
            'kabupaten_kota' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kelurahan' => 'required|string|max:255',
            'nama_jalan' => 'required|string|max:255',
            'rt' => 'required|string|max:10',
            'rw' => 'required|string|max:10',
            'nominal_setor' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $pembukaanRekening->update($request->all());

        return response()->json(['message' => 'Data pembukaan rekening berhasil diperbarui', 'data' => $pembukaanRekening], 200);
    }

    public function approve($id)
    {
        DB::beginTransaction();
        try {
            $pembukaanRekening = PembukaanRekening::findOrFail($id);

            if (Auth::user()->role != 'Supervisi') {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
    
            $pembukaanRekening->status = 'Disetujui';
            $pembukaanRekening->approved_by = Auth::id();
            $pembukaanRekening->save();
    
            $csUser = User::where('id', $pembukaanRekening->created_by)->first();
            Mail::to($csUser->email)->send(new ApprovalNotification($pembukaanRekening));
            DB::commit();
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            PembukaanRekening::findOrFail($id)->delete();
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }   
}
