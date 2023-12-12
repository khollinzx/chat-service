<?php


namespace App\Services;

use App\Abstractions\AbstractClasses\BaseRepositoryAbstract;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

/**
 * Class Helper
 * @package App\Services
 */
class Helper
{

    /**
     * This encrypts data
     * @param string $data
     * @return string
     */
    public static function encryptData(string $data): string
    {
        return Crypt::encryptString($data);
    }

    /**
     * This decrypts data
     * @param string $encryptedData
     * @return string|null
     */
    public static function decryptData(string $encryptedData): ?string
    {
        try {

            return Crypt::decryptString($encryptedData);
        } catch (DecryptException $exception) {

            return null;
        }
    }

    /**
     * @param BaseRepositoryAbstract $model
     * @param string $column
     * @param string $value
     * @return mixed
     */
    public static function getUserByColumnAndValue(
        BaseRepositoryAbstract $model,
        string $column,
        string $value
    ) {
        return $model->getUserByColumnAndValue($column, $value);
    }

    /**
     * This saves a model records
     * @param Model $model
     * @param array $records
     * @return Model
     */
    public static function saveModelRecord(Model $model, array $records = []): Model
    {
        if (count($records)) {
            foreach ($records as $k => $v)
                $model->$k = $v;

            $model->save();
        }

        return $model;
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
        if (count($records)) {
            foreach ($records as $k => $v)
                $model->$k = $v;

            $polymorphicModel->$polymorphicMethod()->save($model);
        }

        return $model;
    }

    /**
     * This overrides the default Laravel error messages
     * @return string[]
     */
    public static function customErrorMessages(): array
    {
        return [
            'userId.required'                  => "Supply the Agent identification.",
            'userId.exists'                  => "The selected Offnet User does not exist.",
        ];
    }
}
