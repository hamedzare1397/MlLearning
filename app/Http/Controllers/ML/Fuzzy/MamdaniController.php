<?php

namespace App\Http\Controllers\ML\Fuzzy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Ml\Fuzzy\Fuzzifier\FuzzyTransformer;
use Ml\Fuzzy\Models\Mamdani;
use Ml\Fuzzy\Models\MamdaniModel;
use Ml\Fuzzy\Rule\Rule;
use Rubix\ML\Clusterers\FuzzyCMeans;
use Rubix\ML\Clusterers\Seeders\Preset;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Extractors\ColumnPicker;
use Rubix\ML\Extractors\CSV;
use Rubix\ML\Kernels\Distance\Euclidean;

class MamdaniController extends Controller
{
    protected $repository;
    public function __construct()
    {
        $this->repository=new RepositoryFuzzy(storage_path('app\data\index.csv'));
    }

    public function train()
    {
        $dataset=$this->repository->getTrainData('wineDataSet',.3);
        $mamdani=new Mamdani();
        $mamdani->train($dataset);


    }
}
