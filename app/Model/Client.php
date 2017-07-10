<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    static public function IsContinueNo($ic)
    {
        switch ($ic) {
            case '首次投资' :
                return 1;
            case '非首次' :
                return 2;
            case '续投' :
                return 3;
            case '无需填写' :
                return 4;
            default :
                return 1;
        }
    }

    static public function IsContinueCs($ic)
    {
        switch ($ic) {
            case 1 :
                return '首次投资';
            case 2 :
                return '非首次';
            case 3 :
                return '续投';
            case 4 :
                return '无需填写';
            default :
                return '首次投资';
        }
    }

    static public function IsContinue()
    {
        return [
            1 => '首次投资',
            2 => '非首次',
            3 => '续投',
            4 => '无需填写'
        ];
    }

    static public function GenderNo($g)
    {
        switch ($g) {
            case '男' :
                return 'M';
            case '女' :
                return 'F';
            default :
                return 'M';
        }
    }

    static public function Gender()
    {
        return [
            'M' => '男',
            'F' => '女'
        ];
    }

    static public function StatusNo($s)
    {
        switch ($s) {
            case '正常' :
                return 1;
            case '划扣失败' :
                return 2;
            case '即将到期' :
                return 3;
            case '取消划扣' :
                return 4;
            case '取消续投' :
                return 5;
            case '提前赎回' :
                return 6;
            case '信达客户，不返息' :
                return 7;
            case '已赎回' :
                return 8;
            case '已退款' :
                return 9;
            case '作废' :
                return 10;
            default :
                return 1;
        }
    }

    static public function Status()
    {
        return [
            1 => '正常',
            2 => '划扣失败',
            3 => '即将到期',
            4 => '取消划扣',
            5 => '取消续投',
            6 => '提前赎回',
            7 => '信达客户，不返息',
            8 => '已赎回',
            9 => '已退款',
            10 => '作废'
        ];
    }

    static public function PayType()
    {
        return [
            1 => '银盛POS机',
            2 => '富有金账户充值',
            3 => '委托划扣',
            4 => '无需划扣',
            5 => '无需填写'
        ];
    }

    static public function BondTypeNo($bt)
    {
        switch ($bt) {
            case '纸质' :
                return 1;
            case '电子邮件' :
                return 2;
            case '两者皆收' :
                return 3;
            case '无需填写' :
                return 4;
            default :
                return 1;
        }
    }

    static public function IsConfirmNo($ic)
    {
        switch ($ic) {
            case '是' :
                return 1;
            case '否' :
                return 2;
            default :
                return 1;
        }
    }

    public function generateTimestamp($excelTime)
    {
        return (intval($excelTime) - 70 * 365 - 19) * 86400 - 8 * 3600;
    }

    public function pay_type()
    {
        return $this->hasOne('App\Model\ClientInfo', 'client_id');
    }
}
