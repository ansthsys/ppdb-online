<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $students = Student::all(); // Mengambil semua data dari tabel students
        return view('student', compact('students'));
    }

    public function edit($id)
    {
        $student = Student::find($id);
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            // Identitas Calon Siswa
            'nik' => 'required|integer',
            'nisn' => 'required|integer',
            'nama_siswa' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string',
            'alamat_siswa' => 'required|string',
            'email' => 'required|string',
            'telepon' => 'required|numeric',

            // Sekolah Asal
            'nama_asal_sekolah' => 'required|string',
            'jenjang_sekolah' => 'required|string',
            'tahun_lulus' => 'required|integer',
            'alamat_sekolah' => 'required|string',

            // Identitas Orang Tua
            'nama_ayah' => 'required|string',
            'pekerjaan_ayah' => 'required|string',
            'alamat_ayah' => 'required|string',

            // Data Pendukung
            'nilai_mtk' => 'required|numeric',
            'nilai_ipa' => 'required|numeric',
            'nilai_bhs_inggris' => 'required|numeric',
            'nilai_bhs_indo' => 'required|numeric',
            'minat_jurusan' => 'required|string',

            // Dokumen Pendukung
            'scan_kk' => 'nullable|string',
            'scan_akta' => 'nullable|string',
            'scan_ktp_wali' => 'nullable|string',
            'foto_siswa' => 'nullable|string',
            'scan_surat_lulus' => 'nullable|string',
        ]);

        // Identitas Calon Siswa
        $student = Student::find($id);
        $student->nik = $request->nik;
        $student->nisn = $request->nisn;
        $student->nama_siswa = $request->nama_siswa;
        $student->jenis_kelamin = $request->jenis_kelamin;
        $student->tempat_lahir = $request->tempat_lahir;
        $student->tanggal_lahir = $request->tanggal_lahir;
        $student->agama = $request->agama;
        $student->alamat_siswa = $request->alamat_siswa;
        $student->email = $request->email;
        $student->telepon = $request->telepon;

        // Sekolah Asal
        $student->nama_asal_sekolah = $request->nama_asal_sekolah;
        $student->jenjang_sekolah = $request->jenjang_sekolah;
        $student->tahun_lulus = $request->tahun_lulus;
        $student->alamat_sekolah = $request->alamat_sekolah;

        // Identitas Orang Tua
        $student->nama_ayah = $request->nama_ayah;
        $student->pekerjaan_ayah = $request->pekerjaan_ayah;
        $student->alamat_ayah = $request->alamat_ayah;
        $student->nama_ibu = $request->nama_ibu;
        $student->pekerjaan_ibu = $request->pekerjaan_ibu;
        $student->alamat_ibu = $request->alamat_ibu;

        // Data Pendukung
        $student->nilai_mtk = $request->nilai_mtk;
        $student->nilai_ipa = $request->nilai_ipa;
        $student->nilai_bhs_inggris = $request->nilai_bhs_inggris;
        $student->nilai_bhs_indo = $request->nilai_bhs_indo;
        $student->minat_jurusan = $request->minat_jurusan;

        // Dokumen Pendukung
        $student->scan_kk = $request->scan_kk;
        $student->scan_akta = $request->scan_akta;
        $student->scan_ktp_wali = $request->scan_ktp_wali;
        $student->foto_siswa = $request->foto_siswa;
        $student->scan_surat_lulus = $request->scan_surat_lulus;
        $student->save();

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil diperbarui');
    }

    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            // Identitas Calon Siswa
            'nik' => 'required|numeric',
            'nisn' => 'required|numeric',
            'nama_siswa' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string',
            'alamat_siswa' => 'required|string',
            'email' => 'required|email',
            'telepon' => 'required|string',

            // Sekolah Asal
            'nama_asal_sekolah' => 'required|string|max:255',
            'jenjang_sekolah' => 'required|string|max:255',
            'tahun_lulus' => 'required|numeric',
            'alamat_sekolah' => 'required|string',

            // Identitas Orang Tua
            'nama_ayah' => 'required|string|max:255',
            'pekerjaan_ayah' => 'required|string|max:255',
            'alamat_ayah' => 'required|string',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_ibu' => 'required|string|max:255',
            'alamat_ibu' => 'required|string',

            // Data Pendukung
            'nilai_mtk' => 'required|numeric',
            'nilai_ipa' => 'required|numeric',
            'nilai_bhs_inggris' => 'required|numeric',
            'nilai_bhs_indo' => 'required|numeric',
            'minat_jurusan' => 'required|string',

            // Dokumen Pendukung
            'scan_kk' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'scan_akta' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'scan_ktp_wali' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'foto_siswa' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'scan_surat_lulus' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $validated['scan_kk'] = $request->file('scan_kk')->store('uploads', 'public');
        $validated['scan_akta'] = $request->file('scan_akta')->store('uploads', 'public');
        $validated['scan_ktp_wali'] = $request->file('scan_ktp_wali')->store('uploads', 'public');
        $validated['foto_siswa'] = $request->file('foto_siswa')->store('uploads', 'public');
        $validated['scan_surat_lulus'] = $request->file('scan_surat_lulus')->store('uploads', 'public');

        // Simpan data ke database
        Student::create($validated);

        return redirect()->back()->with('success', 'Data berhasil dikirim!');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
