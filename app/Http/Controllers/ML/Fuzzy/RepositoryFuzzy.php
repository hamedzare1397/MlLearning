<?php


namespace App\Http\Controllers\ML\Fuzzy;


use Illuminate\Support\Facades\Cache;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Extractors\ColumnPicker;
use Rubix\ML\Extractors\CSV;

class RepositoryFuzzy
{
    protected $ttl = 3600;
    public function get($key,$path)
    {
        if (Cache::has($key)) {
            return Cache::get($key);
        }
        $data=$this->readFromPath($path);
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

}
