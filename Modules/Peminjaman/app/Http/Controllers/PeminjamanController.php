<?php

namespace Modules\Peminjaman\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Modules\Peminjaman\Models\Peminjaman;
use Modules\Peminjaman\Http\Requests\PeminjamanRequest;

class PeminjamanController extends Controller
{
    public function index(): View
    {
        return view('peminjaman::index');
    }

    public function getData(): JsonResponse
    {
        $data = Peminjaman::latest()->get()->map(function ($item) {
            $item->berkas_url = $item->berkas_path
                ? Storage::disk('public')->url($item->berkas_path)
                : null;

            return $item;
        });

        return response()->json($data);
    }

    public function edit(Peminjaman $peminjaman): JsonResponse
    {
        $peminjaman->berkas_url = $peminjaman->berkas_path
            ? Storage::disk('public')->url($peminjaman->berkas_path)
            : null;

        return response()->json($peminjaman);
    }

    public function store(PeminjamanRequest $request): JsonResponse
    {
        $data = $request->safe()->except('berkas');

        if ($request->hasFile('berkas')) {
            $data['berkas_path'] = $request->file('berkas')
                ->store('bukti-peminjaman', 'public');
        }

        Peminjaman::create($data);

        return response()->json([
            'success' => 'Data peminjaman berhasil ditambahkan.'
        ]);
    }

    public function update(
        PeminjamanRequest $request,
        Peminjaman $peminjaman
    ): JsonResponse {
        $data = $request->safe()->except('berkas');

        if ($request->hasFile('berkas')) {
            if ($peminjaman->berkas_path) {
                Storage::disk('public')->delete($peminjaman->berkas_path);
            }

            $data['berkas_path'] = $request->file('berkas')
                ->store('bukti-peminjaman', 'public');
        }

        $peminjaman->update($data);

        return response()->json([
            'success' => 'Data peminjaman berhasil diperbarui.'
        ]);
    }

    public function destroy(Peminjaman $peminjaman): JsonResponse
    {
        if ($peminjaman->berkas_path) {
            Storage::disk('public')->delete($peminjaman->berkas_path);
        }

        $peminjaman->delete();

        return response()->json([
            'success' => 'Data peminjaman berhasil dihapus.'
        ]);
    }
}
