<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Invoice as PDF</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,700;1,800&display=swap" rel="stylesheet">
    <style>
        @page { 
            margin: -2px 25px 5px 25px; /* Adjusted margin values */
            font-family: 'Open Sans', sans-serif;
        }
        
        .table {
            border-collapse: collapse; /* Ensure borders are collapsed properly */
            width: 100%; /* Ensure the table takes up the full width */
            margin-bottom: 1em; /* Add some margin between tables if needed */
        }

        .table, .table th{
            border-bottom: 1px solid #9a9999; /* Set border color */
        }

        .table, .table td {
            border-bottom: 1px solid #dcd9d9; /* Set border color */
        }

        .text-red {color: #e11010!important;}
        .text-success {color: green!important;}

        .badge{border-radius:30%!important;padding: 2px 8px;font-size:12px;text-transform: capitalize;}

        .bg-red {background: red;color:white;}
        .bg-success{background: green;color:white;}
    </style>
</head>
<body style="background-image: url({{ asset('public/invoice-bg.png') }}); background-repeat: no-repeat; background-size: contain; background-color: white !important; background-position: center center; height: 100vh; margin: 0!important;padding:0!important;">
    <table style="width:100% !important;">
        <tr>
            <td style="background: #309278; color: white !important; text-align:center;"><h1>RECHNUNG</h1></td>
        </tr>
        <tr>
            <td style="font-size: 11px"><b>{{$company ? $company->company : ''}} , {!! $company->company_address !!}</b></td>
        </tr>
    </table>

    <table style="width:100%; margin-top: 2rem" >
        <tr class="width: 100% !important;">
            <td style="width: 50%">
                <h6 style="margin:0;padding:0;"></h6> 
                <b>{{fullName($row->user_id)}}</b> <br>
                {{$row->billing_address}}
            </td>
            <td style="text-align:right; font-size: 13px">
                <b>Barlin, {{ parseDateOnly($row->created_at) }}</b> <br>
                Rechnungsnummer : <b>{{invoice_prefix($row->user_id).$row->invoice_number}}</b> <br>
                Leistungsdatum: <b>{{ parseDateOnly($row->start_date) . ' , ' .  parseDateOnly($row->end_date) }}</b> <br>
                </p>
            </td>
        </tr>
    </table>

    <div style="text-align: center;font-size: 13px; padding: 0px 0px; margin:50px 0px 0px 0px;">
        <span class="font-weight: 300">{{invoiceText(1)}}</span>
    </div>


    <table style="width: 100%; margin-top: 3rem;" class="table">
        <thead style="font-size: 12px; border-bottom: 1px solid #c9c6c6;">
            <tr>
                <th style="padding:0;margin:0;">Pos.</th>
                <th style="padding:0;margin:0;">Leistung</th>
                <th style="padding:0;margin:0;">Datum</th>
                <th style="padding:0;margin:0;">UM</th>
                <th style="padding:0;margin:0;">Menge</th>
                <th style="padding:0;margin:0;">Nett.</th>
                <th style="padding:0;margin:0;">Netto.</th>
                <th style="padding:0;margin:0;text-align:right">zzgl. % MwSt.</th>
            </tr>
        </thead>
        <tbody>
            @php $counter = 0;  @endphp
            @foreach($jobs as $job)
            <tr style="font-size: 12px; border-bottom: 1px solid #c9c6c6;">
                <td style="font-size: 12px;">{{ $counter+=1}}</td>
                <td style="text-align: center; font-size: 12px;">{{ serviceName($job->service_id) }}</td>
                <td style="text-align: center; font-size: 12px;">{{ parseDateOnly($job->job_date) }}</td>
                <td style="text-align: center; font-size: 12px;">hour</td>
                <td style="text-align: center; font-size: 12px;">{!! getTotalHourReadable($job->id) !!}</td>
                <td style="text-align: center; font-size: 12px;">{{ servicePrice($job->id).' '.$currency }}</td>
                <td style="text-align: center; font-size: 12px;">{{ calculateTotalBillAmount(getTotalHour($job->id), $job->hourly_rate, $job->id).' '.$currency }}</td>
                <td style="vertical-align: middle; font-size: 12px; text-align: right;">{{ calculateTaxUsingCustomerPrice($job->id) . ' ' . $currency . ' ('. globalTax().'%)' }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="border-top: 1px solid #000;">
                <th colspan="7" style="text-align: right; font-size: 13px; ">Netto</th>
                <th style="text-align: right; font-size: 13px; "> : {{ $row->total_customer_price . ' ' . $currency }}</th>
            </tr>
            <tr class="border-top: 1px solid #000">
                <th colspan="7" style="text-align: right; font-size: 13px; ">zzgl. (19%) MwSt.</th>
                <th style="text-align: right; font-size: 13px;"> : {{ $row->total_tax . ' ' . $currency }}</th>
            </tr>
            <tr class="border-top: 1px solid #000;" class="@if($row->status == 'paid') text-success @else text-red @endif">
                <th colspan="7" style="text-align: right; font-size: 15px;">Brutto</th>
                <th style="text-align: right; font-size: 15px;"> : {{ $row->total_price . ' ' . $currency }} </th>
            </tr>
        </tfoot>
    </table>


    <div style="text-align: center;font-size: 16px; padding: 0px 0px; margin:50px 0px 50px 0px;">
        <span class="font-weight: 300">Bitte überweisen die Endsumme von <b class="@if($row->status == 'paid') text-success @else text-red @endif" style="font-size:16px">{{ $row->total_price . ' ' . $currency }}</b> innerhalb von 3 Tagen mit dem Verwendungszweck.</span> <br>
        <span>Rechnungsnummer: <b>{{invoice_prefix($row->user_id).$row->invoice_number}}</b></span>
    </div>

   <div style="border-bottom: 1px solid #727272;"></div>

    <table style="width: 100%;font-size: 11px;line-height: 2.5;border-top: 1px solid #727272;padding: 10px;box-sizing: border-box;" class="footertable">
        <tr>
            <td>
                Fleckfrei.de <br>
                Postanschrift <br>
                LÃ¶wenbergerstr 2 <br>
                10315 Berlin Germany
            </td>
            <td>
                Mobil <br>
                <a href="tel:015757010977">015757010977</a> <br>
                E-Mail <br>
                <a href="mailto:{{$company->company_email}}">{{$company->company_email}}</a>
            </td>
            <td>
                Webseite <br>
                <a target="_blank" href="{{$company->website}}">{{str_replace(['https://', 'http://'],'',$company->website)}}</a> <br>
                Steuernummer <br>
                132/571/00584
            </td>
            <td>
                USt-IdNr <br>
                DE301503988 <br>
                Betriebsnummer <br>
                969504433
            </td>
            <td>
                Bankverbindung <br>
                N26 <br>
                NTSBDEB1XXX <br>
                DE04100110012626447499
            </td>
        </tr>
    </table>

</body>
</html>