<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lecturer.index', [
            'title' => 'Lecturer',
            'lecturers' => Lecturer::latest()->get(),
            
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('lecturer.create', [
            'title' => 'Create Lecturer',
            'departments' => Department::latest()->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $validated = $request->validate([
            'name' => 'required',
            'department_id' => 'required',
            'avatar' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:1024',
        ], 
        [
            'name.required' => 'Nama Mahasiswa Wajib Di Isi',
            'department_id.required' => 'Program Studi Wajib Dipilih',
            'avatar.image' => 'Avatar harus berupa gambar',
            'avatar.mimes' => 'Format avatar berupa png, jpg, jpeg, webp',
            'avatar.max' => 'Ukuran max file avatar 1Mb',
        ]
        );

        if($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('lecturers', 'public');
        }
        
        Lecturer::create($validated);
        return to_route('lecturer.index')->withSuccess('Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lecturer $lecturer)
    {
        return view('lecturer.show', [
            'title' => 'Detail Lecturer',
            'lecturer' => $lecturer,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lecturer $lecturer)
    {
           return view('lecturer.edit', [
            'title' => 'Edit Lecturer',
            'departments' => Department::latest()->get(),
            'lecturer' => $lecturer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lecturer $lecturer)
    {
            $validated = $request->validate([
            'name' => 'required',
            'department_id' => 'required',
            'avatar' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:1024',
        ], 
        [
            'name.required' => 'Nama Mahasiswa Wajib Di Isi',
            'department_id.required' => 'Program Studi Wajib Dipilih',
            'avatar.image' => 'Avatar harus berupa gambar',
            'avatar.mimes' => 'Format avatar berupa png, jpg, jpeg, webp',
            'avatar.max' => 'Ukuran max file avatar 1Mb',
        ]
        );

        if($request->hasFile('avatar')) {

            //jika user ubah foto hapus foto sebelumnya
            if($lecturer->avatar) {
                Storage::disk('public')->delete($lecturer->avatar);
            }
            
            $validated['avatar'] = $request->file('avatar')->store('lecturers', 'public');
        }
        
        $lecturer->update($validated);
        return to_route('lecturer.index')->withSuccess('Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lecturer $lecturer)
    {
        $lecturer->delete();
        return to_route('lecturer.index')->withSuccess('Data Berhasil dihapus'); 
    }

    //==== soft deleteing ==== 
    public function trash()
    {
        return view('lecturer.trash', [
            'title' => 'Lecturer Trash',
            'lecturers' => Lecturer::onlyTrashed()->latest()->get(),
            
        ]);
    }


    public function restore(Lecturer $lecturer)
    {
        $lecturer->restore();
        return to_route('lecturer.trash')->withSuccess('Data Berhasil dikembalikan'); 
    }


    public function forceDelete(Lecturer $lecturer)
    {
        $lecturer->forceDelete();
        if($lecturer->avatar) {
                Storage::disk('public')->delete($lecturer->avatar);
        }
        return to_route('lecturer.trash')->withSuccess('Data Berhasil dihapus permanen'); 
    }

}