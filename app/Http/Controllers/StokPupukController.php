<?php

namespace App\Http\Controllers;

use App\Models\StokPupuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class StokPupukController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Pengajuan Stok',
        ];
        return view('admin.stok.index', $data);
    }

    public function getStokDataTable()
    {
        $customers = StokPupuk::with(['jenis_pupuk', 'distributor'])->orderByDesc('id');
        if (Auth::user()->role == 'Distributor') {
            $customers->where('id_distributor', Auth::id());
        }
        return DataTables::of($customers)
            ->addColumn('action', function ($customer) {
                return view('admin.stok.components.actions', compact('customer'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function store(Request $request)
    {
        $request->validate([
            'id_distributor' => 'required|string|max:255',
            'id_jenis_pupuk' => 'required|string|max:255',
            'jumlah_pengajuan' => 'required|string|max:255',
        ]);

        $customerData = [
            'id_distributor' => $request->input('id_distributor'),
            'id_jenis_pupuk' => $request->input('id_jenis_pupuk'),
            'jumlah_pengajuan' => $request->input('jumlah_pengajuan'),
        ];

        if ($request->filled('id')) {
            $customer = StokPupuk::find($request->input('id'));
            if (!$customer) {
                return response()->json(['message' => 'jenis not found'], 404);
            }

            $customer->update($customerData);
            $message = 'pengajuan updated successfully';
        } else {
            StokPupuk::create($customerData);
            $message = 'pengajuan created successfully';
        }

        return response()->json(['message' => $message]);
    }
    public function destroy($id)
    {
        $customers = StokPupuk::find($id);

        if (!$customers) {
            return response()->json(['message' => 'jenis not found'], 404);
        }

        $customers->delete();

        return response()->json(['message' => 'jenis deleted successfully']);
    }
    public function edit($id)
    {
        $customer = StokPupuk::find($id);

        if (!$customer) {
            return response()->json(['message' => 'jenis not found'], 404);
        }

        return response()->json($customer);
    }
    public function terima(Request $request)
    {
        $data = StokPupuk::find($request->input('id'));
        $data->diterima = 1;
        $data->jumlah_diterima = $request->input('jumlah_diterima');
        $data->save();

        return response()->json(['message' => 'Berhasil menerima stok'], 200);
    }
    public function tolak(Request $request, $id)
    {
        $data = StokPupuk::find($id);
        $data->diterima = 2;
        $data->save();
        return response()->json(['message' => 'Berhasil menolak stok']);
    }
}