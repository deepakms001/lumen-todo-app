<?php

namespace App\Operations\Auth;

use Exception;

class DataDuplicationCheck
{
    public function run($className, $data, $id = null, $idFieldName = 'id')
    {
        $obj = new $className();
        foreach ($data as $key => $value) {
            $obj = $obj->where($key, $value);
        }
        if ($id) {
            $obj = $obj->where( $idFieldName,'!=', $id);
        }
        if ($obj->count() > 0) {
            throw new Exception('Data already exists.');
        }
        return true;
    }
}
