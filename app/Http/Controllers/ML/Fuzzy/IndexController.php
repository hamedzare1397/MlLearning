<?php

namespace App\Http\Controllers\ML\Fuzzy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Ml\Fuzzy\Fuzzifier\FuzzyTransformer;
use Ml\Fuzzy\Models\MamdaniModel;
use Rubix\ML\Clusterers\FuzzyCMeans;
use Rubix\ML\Clusterers\Seeders\Preset;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Extractors\ColumnPicker;
use Rubix\ML\Extractors\CSV;
use Rubix\ML\Kernels\Distance\Euclidean;

class IndexController extends Controller
{
    protected $repository;
    public function __construct()
    {
        $this->repository=new RepositoryFuzzy();
    }

    public function index(Request $request)
    {
        return view('fuzzy.index');
    }

    public function predict(Request $request)
    {
        $path = Storage::path('data\index.csv');
        $extractor=new ColumnPicker(
            new CSV($path,true),
            ['x1', 'x2', 'x3', 'x4', 'x5', 'x6', 'x7', 'x8', 'x9', 'x10', 'x11', 'x12', 'x13','type']
        );
        $data = Labeled::fromIterator($extractor)->randomize();
        $samples = $data->fold(5)[random_int(0,4)];

        $udata = new Unlabeled($samples->samples());
        $estimatorFuzzy = Storage::get('fuzzy\models\cmeans.serialize');
        /** @var FuzzyCMeans $estimator */
        $estimator = unserialize($estimatorFuzzy);
//        dd($estimator->centroids());
        $predict=$estimator->predict($udata);
        $viewData=[
            'predict'=>$predict,
            'data' => $samples->labels(),
        ];
        return view('fuzzy.predict', $viewData);
    }

    public function learn(Request $request)
    {
        $path = Storage::path('data\index.csv');
        $extractor=new ColumnPicker(
            new CSV($path,true),
            ['x1', 'x2', 'x3', 'x4', 'x5', 'x6', 'x7', 'x8', 'x9', 'x10', 'x11', 'x12', 'x13','type']
        );
        $data = Labeled::fromIterator($extractor);
        $data->apply(new FuzzyTransformer());

        $seeder = new Preset([
            [ 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5],
            [ 0.25, 0.25, 0.25, 0.25, 0.25, 0.25, 0.25, 0.25, 0.25, 0.25, 0.25, 0.25, 0.25],
            [ 0.75, 0.75, 0.75, 0.75, 0.75, 0.75, 0.75, 0.75, 0.75, 0.75, 0.75, 0.75, 0.75],
        ]);
//dd($seeder);
        $estimator =new FuzzyCMeans(3,kernel: new Euclidean(),seeder:$seeder );

        $logger = new \Ml\Fuzzy\Logger();
        $estimator->setLogger($logger);
        dd($data->describeByLabel());


        $data = $data->randomize();
        $eduData = collect();
        foreach ($data->fold(5) as $key=>$value){
            if ($key>=4) break;
            $eduData->push($key, $value->describeByLabel());
            $estimator->train($value);
        }
        if (Storage::exists('fuzzy\models\cmeans.serialize')) {
            Storage::delete('fuzzy\models\cmeans.serialize');
        }
        Storage::put('fuzzy\models\cmeans.serialize', serialize($estimator));
        $viewData = [
            'data' => $eduData->toArray()
        ];
        dd($viewData);
        return view('fuzzy.learning',$viewData);

    }


    public function mamdani(Request $request)
    {
        $data = $this->repository->get('fuzzyData', storage_path('app\data\index.csv'));
        $mamdani = new MamdaniModel();
        $mamdani->learn($data);
        $sample = $data->randomize()[0];
        $mamdani->evaluation($sample);



        $mamdani->fuzzification($data);
        dd($mamdani);
    }
}
