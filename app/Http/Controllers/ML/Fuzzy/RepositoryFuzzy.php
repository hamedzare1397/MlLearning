<?php


namespace App\Http\Controllers\ML\Fuzzy;


use Illuminate\Support\Facades\Cache;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Extractors\ColumnPicker;
use Rubix\ML\Extractors\CSV;

class RepositoryFuzzy
{
    protected $ttl;
    protected $path;

    public function __construct($path,$ttl=3600)
    {
        $this->path = $path;
        $this->ttl = $ttl;
    }
    public function get($key,$path=null)
    {
        if (! is_null($path)) {
            $this->path = $path;
        }
        if (Cache::has($key)) {
            return Cache::get($key);
        }
        $data=$this->readFromPath($this->path);
        Cache::add($key, $data, $this->ttl);
        return $data;
    }

    protected function readFromPath($path)
    {
        if (is_null($path))
            throw new \Exception('path is null');
        $extractor=new ColumnPicker(
            new CSV($path,true),
            ['x1', 'x2', 'x3', 'x4', 'x5', 'x6', 'x7', 'x8', 'x9', 'x10', 'x11', 'x12', 'x13','type']
        );
        $data = Labeled::fromIterator($extractor);
        return $data;
    }

    public function getTrainData($key,$ration=.5,$flash=false)
    {
        if ($flash) {
            Cache::forget("$key.train");
            Cache::forget("$key.test");
        }
        if (Cache::has($key . '.train')) {
            return Cache::get($key . '.train');
        }
        else{
            [$test,$train] = $this->get($key)->randomize()->split($ration);
            Cache::put("$key.train", $train,$this->ttl);
            Cache::put("$key.test", $test,$this->ttl);
            return $train;
        }
    }
    public function getTestData($key)
    {
        if (Cache::has($key . '.test')) {
            return Cache::get($key . '.test');
        }
        throw new \Exception('No Test Data! please first get Train Data then try to get TestData');
    }

}
