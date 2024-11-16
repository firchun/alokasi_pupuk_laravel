<?php

namespace App\Http\Controllers;

use App\Models\JenisPupuk;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JenisPupukController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Jenis Pupuk',
        ];
        return view('admin.jenis_pupuk.index', $data);
    }
    public function getJenisPupukDataTable()
    {
        $customers = JenisPupuk::orderByDesc('id');

        return DataTables::of($customers)
            ->addColumn('action', function ($customer) {
                return view('admin.jenis_pupuk.components.actions', compact('customer'));
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
            $customer = JenisPupuk::find($request->input('id'));
            if (!$customer) {
                return response()->json(['message' => 'jenis not found'], 404);
            }

            $customer->update($customerData);
            $message = 'jenis updated successfully';
        } else {
            JenisPupuk::create($customerData);
            $message = 'jenis created successfully';
        }

        return response()->json(['message' => $message]);
    }
    public function destroy($id)
    {
        $customers = JenisPupuk::find($id);

        if (!$customers) {
            return response()->json(['message' => 'jenis not found'], 404);
        }

        $customers->delete();

        return response()->json(['message' => 'jenis deleted successfully']);
    }
    public function edit($id)
    {
        $customer = JenisPupuk::find($id);

        if (!$customer) {
            return response()->json(['message' => 'jenis not found'], 404);
        }

        return response()->json($customer);
    }
}
