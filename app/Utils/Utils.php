<?php

namespace App\Utils;

use App\Services\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class  Utils
{

    /**
     * @param int $length
     * @return string
     */
    public static function generateUniqueConversationKey(int $length = 16): string
    {
        $key   = '';
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $limit      = strlen($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $key .= $characters[rand(0, $limit)];
        }

        return $key;
    }

    /**
     * This saves a model records
     *
     * @param Model $model
     * @param array $records
     * @param bool $returnModel
     * @return Model|void
     */
    public static function saveModelRecord(Model $model, array $records = [], bool $returnModel = true)
    {
        if (count($records)) {
            foreach ($records as $k => $v)
                $model->$k = $v;

            $model->save();
        }

        if($returnModel) return $model;
    }

    /**
     * @param Model $model
     * @param Model $polymorphicModel
     * @param string $polymorphicMethod
     * @param array $records
     * @return Model
     */
    public static function savePolymorphicRecord(Model $model, Model $polymorphicModel, string $polymorphicMethod, array $records): Model
    {
        if(count($records)) {
            foreach ($records as $k => $v)
                $model->$k = $v;

            $polymorphicModel->$polymorphicMethod()->save($model);
        }

        return $model;
    }
}

