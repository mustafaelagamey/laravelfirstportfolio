<?php
/**
 * Created by PhpStorm.
 * User: Darsh
 * Date: 5/6/2017
 * Time: 5:28 PM
 */

namespace App;


use Illuminate\Support\Facades\Schema;

trait GeneralModel
{
    public static function searchRecordsFor(string $text,$withId=false)
    {


        $columns = static::getDataColumns();
        $query = null;
        $firstCondition = true;
        $dataColumns=static::getDataColumns();
        if ($withId)
            $dataColumns[] = 'id';
        $results = self::select($dataColumns);
        foreach ($columns as $key => $column) {
            if ($firstCondition) {
                $firstCondition = false;
                $query = $results->where($column, 'LIKE', "%$text%");
            } else {
                $query = $results->orWhere($column, 'LIKE', "%$text%");
            }
        }
        return $query;
    }

    public static function getDataColumns()
    {
        $columns = (new static())->getConnection()->getSchemaBuilder()->getColumnListing((new static())->getTable());
        $dataColumns = [];
        foreach ($columns as $key => $column) {
            if (!in_array($column, ['id', 'updated_at', 'deleted_at', 'created_at']) && substr($column, -3) !== '_id' && substr($column, -5) !== '_type')
                $dataColumns[] = $column;
        }
        return $dataColumns;
    }

    public static function getAllColumns()
    {
        $columns = (new static())->getConnection()->getSchemaBuilder()->getColumnListing((new static())->getTable());
        return $columns;
    }
}

