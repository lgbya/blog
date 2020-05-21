<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    public static function statusEnum($value=null)
    {
        $lEnum = [
            self::STATUS_ON => '开启',
            self::STATUS_OFF => '关闭',
        ];
        if($value === null){
            return $lEnum;
        }
        return $lEnum[$value] ?? '';
    }


}
