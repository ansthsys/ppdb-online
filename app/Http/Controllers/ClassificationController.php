<?php

namespace App\Http\Controllers;

use Algorithm\C45;
use App\Models\Classification;
use App\Models\Student;
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
        $this->datasets = array_merge(
            $this->datasets,
            $this->getDummyDatasets(10, 0, 33),
            $this->getDummyDatasets(10, 34, 66),
            $this->getDummyDatasets(10, 67, 100),
            $this->getDummyDatasets(10, 0, 100)
        );
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $c45 = new C45();
        $input = new C45\DataInput;

        $data = DB::table('students')
            ->join('classifications', 'students.id', '=', 'classifications.student_id')
            ->select('students.nilai_mtk', 'students.nilai_ipa', 'students.nilai_bhs_inggris', 'students.nilai_bhs_indo', 'classifications.result')
            ->get()
            ->toArray();

        // Initialize Data
        $input->setData($data); // Set data from array
        $input->setAttributes(['nilai_mtk', 'nilai_ipa', 'nilai_bhs_inggris', 'nilai_bhs_indo', 'result']); // Set attributes of data

        // Initialize C4.5
        $c45->c45 = $input; // Set input data
        $c45->setTargetAttribute('result'); // Set target attribute
        $initialize = $c45->initialize(); // initialize

        // Build Output
        $buildTree = $initialize->buildTree(); // Build tree
        $arrayTree = $buildTree->toArray(); // Set to array
        $stringTree = $buildTree->toString(); // Set to string

        $classifications = Classification::with('student')->get();

        return view('classification', [
            'classifications' => $classifications,
            'arrayTree' => $arrayTree,
            'stringTree' => $stringTree,
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

        $classification = $c45->initialize()->buildTree()->classify($payload);

        return $classification;
    }

    private function getDummyDatasets(int $length, int $min = 0, int $max = 100)
    {
        $datasets = [];

        for ($i = 0; $i < $length; $i++) {
            $nilai_mtk = rand($min, $max);
            $nilai_ipa = rand($min, $max);
            $nilai_bhs_inggris = rand($min, $max);
            $nilai_bhs_indo = rand($min, $max);

            $average = ($nilai_mtk + $nilai_ipa + $nilai_bhs_inggris + $nilai_bhs_indo) / 4;
            $result = round($average) >= 60 ? "Lolos" : "Tidak Lolos";

            $datasets[] = [
                "nilai_mtk" => $nilai_mtk,
                "nilai_ipa" => $nilai_ipa,
                "nilai_bhs_inggris" => $nilai_bhs_inggris,
                "nilai_bhs_indo" => $nilai_bhs_indo,
                "result" => $result
            ];
        }

        return $datasets;
    }
}