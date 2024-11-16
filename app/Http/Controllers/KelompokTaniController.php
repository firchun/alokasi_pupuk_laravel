<?php

namespace App\Http\Controllers;

use App\Models\KelompokTani;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KelompokTaniController extends Controller
{
    public function index($id_poktan)
    {
        $user = User::find($id_poktan);
        $data = [
            'title' => 'Anggota Kelompok Tani : ' . $user->name,
            'id_poktan' => $id_poktan
        ];
        return view('admin.kelompok_tani.index', $data);
    }
    public function getKelompokTaniDataTable($id_poktan)
    {
        $customers = KelompokTani::where('id_poktan', $id_poktan)->orderByDesc('id');

        return DataTables::of($customers)
            ->addColumn('action', function ($customer) {
                return view('admin.kelompok_tani.components.actions', compact('customer'));
            })
            ->addColumn('phone', function ($customer) {
                return '<a href="https://wa.me/' . $customer->no_hp . '" target="__blank">' . $customer->no_hp . '</a>';
            })
            ->rawColumns(['action', 'phone'])
            ->make(true);
    }
    public function store(Request $request)
    {
        $request->validate([
            'id_poktan' => 'required',
            'no_hp' => 'required|string|max:20',
            'nama' => 'required|string',
            'alamat' => 'required|string',
        ]);

        $customerData = [
            'id_poktan' => $request->input('id_poktan'),
            'nama' => $request->input('nama'),
            'no_hp' => $request->input('no_hp'),
            'alamat' => $request->input('alamat'),
        ];

        if ($request->filled('id')) {
            $customer = KelompokTani::find($request->input('id'));
            if (!$customer) {
                return response()->json(['message' => 'anggota not found'], 404);
            }

            $customer->update($customerData);
            $message = 'anggota updated successfully';
        } else {
            KelompokTani::create($customerData);
            $message = 'anggota created successfully';
        }

        return response()->json(['message' => $message]);
    }
    public function destroy($id)
    {
        $customers = KelompokTani::find($id);

        if (!$customers) {
            return response()->json(['message' => 'Anggota not found'], 404);
        }

        $customers->delete();

        return response()->json(['message' => 'Anggota deleted successfully']);
    }
    public function edit($id)
    {
        $customer = KelompokTani::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Anggota not found'], 404);
        }

        return response()->json($customer);
    }
    public function getKelompok($id_poktan)
    {
        $customer = KelompokTani::where('id_poktan', $id_poktan)->get();

        if (!$customer) {
            return response()->json(['message' => 'Anggota not found'], 404);
        }
        return response()->json($customer);
    }
}
