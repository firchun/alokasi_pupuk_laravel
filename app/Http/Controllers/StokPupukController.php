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
            'jenis_pupuk' => 'required|string|max:255',
        ]);

        $customerData = [
            'jenis_pupuk' => $request->input('jenis_pupuk'),
        ];

        if ($request->filled('id')) {
            $customer = StokPupuk::find($request->input('id'));
            if (!$customer) {
                return response()->json(['message' => 'jenis not found'], 404);
            }

            $customer->update($customerData);
            $message = 'jenis updated successfully';
        } else {
            StokPupuk::create($customerData);
            $message = 'jenis created successfully';
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
}
