<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Response;
use App\Models\Invoice;
use App\Models\Setting;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function upload_img_for_email(Request $request)
    {
        if ($request->hasFile('file')) {
            $fileExtension = $request->file->getClientOriginalExtension();
            $filename = uniqid('img_') . '.' . $fileExtension;
            $path = Storage::disk('payment_attachment')->put('', $request->file);
            
            return response()->json(['location' => asset('/public/storage/payment_attachment').'/'.$path]);
        }
        return response()->json(['error' => 'File not provided'], 400);
    }


    public function downloadPDF(Request $request)
    {
        if ($request->id) {
            $row = Invoice::find($request->id);
            $com = Setting::where('user_id', 1)->first();
            $data['row'] = $row;
            $data['currency'] = $data['row'] ? $data['row']->currency : currencySign();
            $data['company'] = $com;
            $data['jobs'] = $data['row'] ? $data['row']->jobs : [];
            // Use Dompdf options to set configuration
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', true);
            $options->set('isRemoteEnabled', true);
            $options->set('enable_javascript', true);
            $dompdf = new Dompdf($options);
            $html = view('pdf.customer-invoice', $data)->render();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('letter', 'portrait');
            $dompdf->render();
            // Save the PDF file locally
            $pdfOutput = $dompdf->output();
            $filename = $com->invoice_prefix.'_'.$com->invoice_number.'_'.Str::replace(' ','_', fullName($row->user_id)).'_' .$row->invoice_number.'.pdf';
            $path = storage_path("app/public/pdfs/{$filename}");
            $row->update(['generated_invoice' => $filename]);
            file_put_contents($path, $pdfOutput);
            return response()->download($path, $filename);
        } else {
            return redirect()->back();
        }
    }
}