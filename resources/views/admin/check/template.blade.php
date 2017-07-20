<!DOCTYPE html>
<html>
<head>
    <title>{{ $client->contractno }}_{{ $client->client }}_{{$month}}月账单</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: 'msyh';
            font-size:12px;
            color:#000000;
            font-weight:normal;
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        @font-face {
            font-family: 'msyh';
            font-style: normal;
            font-weight: normal;
            src: url('{{ load_asset('fonts/msyh.ttf') }}') format('truetype');
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .page {
            width: 210mm;
            padding: 20mm;
            margin: 10mm auto;
            border-radius: 5px;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        @page {
            size: A4 portrait;
            margin: 0;
        }

        @media print {
            html, body {
                width: 210mm;
                height: 297mm;
            }

            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
        }
    </style>
</head>
<body>

<div class="page" id="pageContent">
    <table cellspacing=0 border=1 id="table1" style="border: hidden;border-color: #000;">
        <tbody>
        <tr style="height:28px;">
            <td style="text-align:left;border:hidden;min-width:50px"
                colspan=5>
                <nobr id="postcode">邮编：{{ $client->postcode }}</nobr>
            </td>
        </tr>
        <tr style="height:28px;">
            <td style="text-align:left;border:hidden;min-width:50px"
                colspan=5>
                <nobr id="address">地址：{{ $client->address }}</nobr>
            </td>
        </tr>
        <tr style="height:28px;">
            <td style="text-align:left;border:hidden;min-width:50px"
                colspan=5>
                <nobr id="recipient">收件人：{{ $client->client }}</nobr>
            </td>
        </tr>
        <tr style="height:28px;">
            <td style="text-align:center;font-weight:bold;border:hidden;min-width:50px"
                colspan=5>
                <nobr>资金出借情况报告</nobr>
            </td>
        </tr>
        <tr style="height:28px;">
            <td style="text-align:center;font-weight:bold;border:hidden;min-width:50px"
                colspan=5>
                <nobr>&nbsp;&nbsp;</nobr>
            </td>
        </tr>
        <tr style="height:28px;">
            <td style="text-align:center;font-weight:bold;border:hidden;min-width:50px"
                colspan=5>
                <nobr>&nbsp;&nbsp;</nobr>
            </td>
        </tr>
        <tr style="height:28px;">
            <td style="text-align:left;border:hidden;min-width:50px"
                colspan=5>
                <nobr>尊敬的{{ $client->client }}女士/先生，您好！</nobr>
            </td>
        </tr>
        <tr style="height:28px;">
            <td style="text-align:left;border:hidden;min-width:50px"
                colspan=5>
                <nobr>感谢您选择国商信联财富投资管理（北京）有限公司的咨询服务，参考国商惠众投资管理（北京）有限公司（以下</nobr>
            </td>
        </tr>
        <tr style="height:28px;">
            <td style="text-align:left;border:hidden;min-width:50px"
                colspan=5>
                <nobr>称国商惠众公司）的推荐进行资金的出借增值，您目前出借的款项所产生的收益情况如下：</nobr>
            </td>
        </tr>
        <tr style="height:28px;">
            <td style="text-align:right;border:hidden;min-width:50px"
                colspan=5>
                <nobr>货币单位：人民币（元）</nobr>
            </td>
        </tr>
        <tr style="height:28px;">
            <td style="text-align:center;min-width:50px"
                >
                <nobr>报告周期</nobr>
            </td>
            <td style="text-align:center;border-left:hidden;min-width:50px"
                colspan=4>
                <nobr>{{ date('Y/m/d', strtotime($client->loan_date)) }} --- {{ date('Y/m/d', strtotime($client->due_date)) }}</nobr>
            </td>
        </tr>
        <tr style="height:28px;">
            <td style="text-align:center;border-top:hidden;min-width:50px">
                <nobr>合同编号</nobr>
            </td>
            <td style="text-align:center;border-left:hidden;border-top:hidden;min-width:50px">
                <nobr>{{ $client->contractno }}</nobr>
            </td>
            <td style="text-align:center;border-left:hidden;border-top:hidden;min-width:50px">
                <nobr>资金出借及回收方式</nobr>
            </td>
            <td style="text-align:center;border-left:hidden;border-top:hidden;min-width:50px">
                <nobr>{{ $client->product_name }}</nobr>
            </td>
            <td style="text-align:center;border-left:hidden;border-top:hidden;min-width:50px">
                <nobr>期数：{{ $client->nper }}</nobr>
            </td>
        </tr>
        <tr style="height:28px;">
            <td style="text-align:center;border-top:hidden;min-width:50px">
                <nobr>初始出借金额</nobr>
            </td>
            <td style="text-align:center;border-left:hidden;border-top:hidden;min-width:50px">
                <nobr>{{ $client->loan_amount }}</nobr>
            </td>
            <td style="text-align:center;border-left:hidden;border-top:hidden;min-width:50px">
                <nobr>出借预期年化收益</nobr>
            </td>
            <td style="text-align:center;border-left:hidden;border-top:hidden;min-width:50px"
                colspan=2>
                <nobr>{{ $client->annualized_return * 100 }}%</nobr>
            </td>
        </tr>
        <tr style="height:28px;">
            <td style="text-align:center;border-top:hidden;min-width:50px">
                <nobr>账户级别</nobr>
            </td>
            <td style="text-align:center;border-left:hidden;border-top:hidden;min-width:50px">
                <nobr>尊普通账户</nobr>
            </td>
            <td style="text-align:center;border-left:hidden;border-top:hidden;min-width:50px">
                <nobr>报告日实际收益总额</nobr>
            </td>
            <td style="text-align:center;border-left:hidden;border-top:hidden;min-width:50px"
                colspan=2>
                <nobr>{{ $client->gross_interest }}</nobr>
            </td>
        </tr>
        <tr style="height:28px;">
            <td style="text-align:left;border:hidden;min-width:50px"
                colspan=4>
                <nobr> 您目前的每笔出借款项实际回收情况及出借收益如下：</nobr>
            </td>
            <td style="text-align:right;border:hidden;border-top:hidden;min-width:50px">
                <nobr>货币单位：人民币（元）</nobr>
            </td>
        </tr>
        <tr style="height:35px;">
            <td style="text-align:center;min-width:50px">
                <nobr>报告日</nobr>
            </td>
            <td style="text-align:center;border-left:hidden;min-width:50px">
                <nobr>预期报告日收益</nobr>
            </td>
            <td style="text-align:center;border-left:hidden;min-width:50px">
                <nobr>账户管理费</nobr>
            </td>
            <td style="text-align:center;border-left:hidden;min-width:50px">
                <nobr>预期报告日净收益</nobr>
            </td>
            <td style="text-align:center;border-left:hidden;min-width:50px">
                <nobr>预期报告日资产总额</nobr>
            </td>
        </tr>

        @foreach ($accounts as $account)
        <tr style="height:28px;">
            <td style="text-align:center;border-top:hidden;min-width:50px">
                <nobr>{{$account['date']}}</nobr>
            </td>
            <td style="text-align:center;border-left:hidden;border-top:hidden;min-width:50px">
                <nobr>{{$account['interest_monthly']}}</nobr>
            </td>
            <td style="text-align:center;border-left:hidden;border-top:hidden;min-width:50px">
                <nobr>0.00</nobr>
            </td>
            <td style="text-align:center;border-left:hidden;border-top:hidden;min-width:50px">
                <nobr>{{$account['interest_monthly']}}</nobr>
            </td>
            <td style="text-align:center;border-left:hidden;border-top:hidden;min-width:50px">
                <nobr>{{$account['total_assets']}}</nobr>
            </td>
        </tr>
        @endforeach

        <tr style="height:28px;">
            <td style="text-align:left;border:hidden;min-width:50px"
                colspan=5>
                <nobr>国商惠众公司竭诚为您提供最优质、高效的服务，如有任何问题请联系我司为您指定的客户服务人员。</nobr>
            </td>
        </tr>
        <tr style="height:28px;">
            <td style="text-align:left;border:hidden;min-width:50px"
                colspan=5>
                <nobr>服务专线：400-691-7788</nobr>
            </td>
        </tr>
        <tr style="height:28px;">
            <td style="text-align:left;border:hidden;min-width:50px"
                colspan=5>
                <nobr>&nbsp;</nobr>
            </td>
        </tr>
        <tr style="height:28px;">
            <td style="text-align:center;border:hidden;min-width:50px"
                colspan=3>
                <nobr></nobr>
            </td>
            <td style="text-align:left;border:hidden;min-width:50px"
                colspan=2>
                <nobr>见证人：国商惠众投资管理（北京）有限公司</nobr>
            </td>
        </tr>
        <tr style="height:28px;">
            <td style="text-align:right;border:hidden;min-width:50px"
                colspan=3>
                <nobr></nobr>
            </td>
            <td style="text-align:left;border:hidden;min-width:50px"
                colspan=2>
                <nobr>盖章：</nobr>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
