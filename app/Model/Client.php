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
}
