<?php


namespace Ml\Fuzzy\Fuzzifier;


class Fuzzifier
{
    public static function min($data)
    {
        $min = collect();
        foreach ($data as $datum) {
            foreach ($datum as $key => $value) {
                $min->put($key, $data->min($key));
            }
        }
        return $min;
    }
    public static function max($data)
    {
        $max = collect();
        foreach ($data as $datum) {
            foreach ($datum as $key => $value) {
                $max->put($key, $data->max($key));
            }
        }
        return $max;
    }
    public static function minAndMax($data,&$min,&$max)
    {
        $min = collect();
        $max = collect();
        foreach ($data as $datum) {
            foreach ($datum as $key => $value) {
                $min->put($key, $data->min($key));
                $max->put($key, $data->max($key));
            }
        }
    }
    public static function normalize($data,&$min=null,&$max=null)
    {
        $data=collect($data);
        $result = collect();
        $min = $max = null;
        self::minAndMax($data,$min,$max);
        foreach ($data as $key=>$row)
        {
            $r = collect();
            foreach ($row as $dimension=>$value) {
                $res = ($value - $min[$dimension]) / ($max[$dimension] - $min[$dimension]);
                $r->add($res);
            }
            $result->add($r);
        }
        return $result;

    }

    public static function reedCsv($path,$header=null)
    {
        $file = fopen($path,"r");
        $data = collect();
        while(!feof($file)){
            $row = fgetcsv($file);
            $data->add($row);
        }
        fclose($file);
        return $data;
    }
}