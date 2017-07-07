<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ClientInfo extends Model
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'client_infos';

    static public function PayTypeNo($pt)
    {
        switch ($pt) {
            case '银盛POS机' :
                return 1;
            case '富友金帐户充值' :
                return 2;
            case '委托划扣' :
                return 3;
            case '无需划扣' :
                return 4;
            case '无需填写' :
                return 5;
            default :
                return 1;
        }
    }
}
