<?php

namespace App\Http\Controllers;

use Algorithm\C45;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Classification;
use Illuminate\Support\Facades\DB;

class ClassificationController extends Controller
{
    private $datasets = [];

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->datasets = [
            [
                "nilai_mtk" => 70,
                "nilai_ipa" => 75,
                "nilai_bhs_inggris" => 85,
                "nilai_bhs_indo" => 97,
                "result" => "Lolos"
            ],
            [
                "nilai_mtk" => 50,
                "nilai_ipa" => 60,
                "nilai_bhs_inggris" => 78,
                "nilai_bhs_indo" => 80,
                "result" => "Tidak Lolos"
            ],
            [
                "nilai_mtk" => 50,
                "nilai_ipa" => 75,
                "nilai_bhs_inggris" => 85,
                "nilai_bhs_indo" => 97,
                "result" => "Lolos"
            ],
            [
                "nilai_mtk" => 50,
                "nilai_ipa" => 60,
                "nilai_bhs_inggris" => 85,
                "nilai_bhs_indo" => 97,
                "result" => "Lolos"
            ],
            [
                "nilai_mtk" => 50,
                "nilai_ipa" => 60,
                "nilai_bhs_inggris" => 78,
                "nilai_bhs_indo" => 97,
                "result" => "Tidak Lolos"
            ],
            [
                "nilai_mtk" => 70,
                "nilai_ipa" => 75,
                "nilai_bhs_inggris" => 85,
                "nilai_bhs_indo" => 80,
                "result" => "Lolos"
            ],
            [
                "nilai_mtk" => 70,
                "nilai_ipa" => 75,
                "nilai_bhs_inggris" => 78,
                "nilai_bhs_indo" => 80,
                "result" => "Lolos"
            ],
            [
                "nilai_mtk" => 70,
                "nilai_ipa" => 60,
                "nilai_bhs_inggris" => 78,
                "nilai_bhs_indo" => 80,
                "result" => "Tidak Lolos"
            ],
            [
                "nilai_mtk" => 50,
                "nilai_ipa" => 75,
                "nilai_bhs_inggris" => 78,
                "nilai_bhs_indo" => 97,
                "result" => "Lolos"
            ],
            [
                "nilai_mtk" => 70,
                "nilai_ipa" => 60,
                "nilai_bhs_inggris" => 85,
                "nilai_bhs_indo" => 80,
                "result" => "Lolos"
            ],
            [
                "nilai_mtk" => 70,
                "nilai_ipa" => 60,
                "nilai_bhs_inggris" => 78,
                "nilai_bhs_indo" => 97,
                "result" => "Lolos"
            ],
            [
                "nilai_mtk" => 50,
                "nilai_ipa" => 75,
                "nilai_bhs_inggris" => 85,
                "nilai_bhs_indo" => 80,
                "result" => "Lolos"
            ],
            [
                "nilai_mtk" => 70,
                "nilai_ipa" => 60,
                "nilai_bhs_inggris" => 85,
                "nilai_bhs_indo" => 97,
                "result" => "Lolos"
            ],
            [
                "nilai_mtk" => 50,
                "nilai_ipa" => 75,
                "nilai_bhs_inggris" => 78,
                "nilai_bhs_indo" => 80,
                "result" => "Tidak Lolos"
            ],
            [
                "nilai_mtk" => 50,
                "nilai_ipa" => 60,
                "nilai_bhs_inggris" => 85,
                "nilai_bhs_indo" => 80,
                "result" => "Tidak Lolos"
            ],
        ];
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $classifications = Classification::with('student')->get();
        $students = Student::select('id', 'nama_siswa', 'jenis_kelamin', 'minat_jurusan')->get();

        $c45 = new C45();
        $input = new C45\DataInput;

        $data = DB::table('students')
            ->join('classifications', 'students.id', '=', 'classifications.student_id')
            ->select(
                'students.nilai_mtk',
                'students.nilai_ipa',
                'students.nilai_bhs_inggris',
                'students.nilai_bhs_indo',
                'classifications.result'
            )
            ->get()
            ->map(function ($item) {
                return [
                    "nilai_mtk" => $item->nilai_mtk,
                    "nilai_ipa" => $item->nilai_ipa,
                    "nilai_bhs_inggris" => $item->nilai_bhs_inggris,
                    "nilai_bhs_indo" => $item->nilai_bhs_indo,
                    "result" => $item->result ?? 'Tidak Diketahui'
                ];
            })
            ->toArray();

        $dataArray = array(
            array(
                "nilai_mtk" => 70,
                "nilai_ipa" => 75,
                "nilai_bhs_inggris" => 85,
                "nilai_bhs_indo" => 97,
                "result" => "Lolos"
            ),
            array(
                "nilai_mtk" => 50,
                "nilai_ipa" => 60,
                "nilai_bhs_inggris" => 78,
                "nilai_bhs_indo" => 80,
                "result" => "Tidak Lolos"
            ),
            array(
                "nilai_mtk" => 50,
                "nilai_ipa" => 75,
                "nilai_bhs_inggris" => 85,
                "nilai_bhs_indo" => 97,
                "result" => "Lolos"
            ),
            array(
                "nilai_mtk" => 50,
                "nilai_ipa" => 60,
                "nilai_bhs_inggris" => 85,
                "nilai_bhs_indo" => 97,
                "result" => "Lolos"
            ),
            array(
                "nilai_mtk" => 50,
                "nilai_ipa" => 60,
                "nilai_bhs_inggris" => 78,
                "nilai_bhs_indo" => 97,
                "result" => "Tidak Lolos"
            ),
            array(
                "nilai_mtk" => 70,
                "nilai_ipa" => 75,
                "nilai_bhs_inggris" => 85,
                "nilai_bhs_indo" => 80,
                "result" => "Lolos"
            ),
            array(
                "nilai_mtk" => 70,
                "nilai_ipa" => 75,
                "nilai_bhs_inggris" => 78,
                "nilai_bhs_indo" => 80,
                "result" => "Lolos"
            ),
            array(
                "nilai_mtk" => 70,
                "nilai_ipa" => 60,
                "nilai_bhs_inggris" => 78,
                "nilai_bhs_indo" => 80,
                "result" => "Tidak Lolos"
            ),
            array(
                "nilai_mtk" => 50,
                "nilai_ipa" => 75,
                "nilai_bhs_inggris" => 78,
                "nilai_bhs_indo" => 97,
                "result" => "Lolos"
            ),
            array(
                "nilai_mtk" => 70,
                "nilai_ipa" => 60,
                "nilai_bhs_inggris" => 85,
                "nilai_bhs_indo" => 80,
                "result" => "Lolos"
            ),
            array(
                "nilai_mtk" => 70,
                "nilai_ipa" => 60,
                "nilai_bhs_inggris" => 78,
                "nilai_bhs_indo" => 97,
                "result" => "Lolos"
            ),
            array(
                "nilai_mtk" => 50,
                "nilai_ipa" => 75,
                "nilai_bhs_inggris" => 85,
                "nilai_bhs_indo" => 80,
                "result" => "Lolos"
            ),
            array(
                "nilai_mtk" => 70,
                "nilai_ipa" => 60,
                "nilai_bhs_inggris" => 85,
                "nilai_bhs_indo" => 97,
                "result" => "Lolos"
            ),
            array(
                "nilai_mtk" => 50,
                "nilai_ipa" => 75,
                "nilai_bhs_inggris" => 78,
                "nilai_bhs_indo" => 80,
                "result" => "Tidak Lolos"
            ),
            array(
                "nilai_mtk" => 50,
                "nilai_ipa" => 60,
                "nilai_bhs_inggris" => 85,
                "nilai_bhs_indo" => 80,
                "result" => "Tidak Lolos"
            ),
        );

        // Initialize Data
        $input->setData($dataArray);
        $input->setAttributes(['nilai_mtk', 'nilai_ipa', 'nilai_bhs_inggris', 'nilai_bhs_indo', 'result']);

        // Initialize C4.5
        $c45->c45 = $input;
        $c45->setTargetAttribute('result');
        $initialize = $c45->initialize();

        // Build Output
        $buildTree = $initialize->buildTree();
        $arrayTree = $buildTree->toArray();
        $stringTree = $buildTree->toString();

        $classifications = Classification::with('student')->get();

        return view('classification', [
            'classifications' => $classifications,
            'arrayTree' => $arrayTree,
            'stringTree' => $stringTree,
            'students' => $students,
        ]);
    }

    public function getClassification(Student $request, bool $useDatasets = false)
    {
        $c45 = new C45();
        $input = new C45\DataInput;

        $data = DB::table('students')
            ->join('classifications', 'students.id', '=', 'classifications.student_id')
            ->select('students.nilai_mtk', 'students.nilai_ipa', 'students.nilai_bhs_inggris', 'students.nilai_bhs_indo', 'classifications.result')
            ->get()
            ->toArray();

        $newData = $useDatasets ? array_merge($data, $this->datasets) : $data;

        $input->setData($newData);
        $input->setAttributes(['nilai_mtk', 'nilai_ipa', 'nilai_bhs_inggris', 'nilai_bhs_indo', 'result']);

        $c45->c45 = $input;
        $c45->setTargetAttribute('result');
        $initialize = $c45->initialize();

        $buildTree = $initialize->buildTree();

        $payload = [
            'nilai_mtk' => $request->nilai_mtk,
            'nilai_ipa' => $request->nilai_ipa,
            'nilai_bhs_inggris' => $request->nilai_bhs_inggris,
            'nilai_bhs_indo' => $request->nilai_bhs_indo,
        ];

        $classification = $buildTree->classify($payload);

        return $classification;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_siswa' => 'required|exists:students,id',
            'test_minat_bakat' => 'required|string',
            'test_psikotes' => 'required|string',
            'test_numerik' => 'required|string',
        ]);

        $student = Student::findOrFail($validatedData['nama_siswa']);

        $classification = Classification::create([
            'student_id' => $student->id,
            'test_minat_bakat' => $validatedData['test_minat_bakat'],
            'test_psikotes' => $validatedData['test_psikotes'],
            'test_numerik' => $validatedData['test_numerik'],
            'result' => 'Belum Diproses', // Default hasil klasifikasi
        ]);

        return redirect()->route('classifications.index')->with('success', 'Data klasifikasi berhasil disimpan.');
    }
}
