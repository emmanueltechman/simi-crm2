<?php
/*
 * Rose Business Suite - Accounting, CRM and POS Software
 * Copyright (c) UltimateKode.com. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@ultimatekode.com
 *  Website: https://www.ultimatekode.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://codecanyon.net/licenses/standard/
 * ***********************************************************************
 */
namespace App\Http\Controllers\Focus\printer;

use App\Models\Company\Company;
use App\Models\Company\ConfigMeta;
use App\Models\invoice\Invoice;
use App\Http\Controllers\Controller;
use App\Http\Requests\Focus\invoice\ManageInvoiceRequest;
use Endroid\QrCode\QrCode;
use Illuminate\Support\Facades\Storage;
use Mike42\Escpos\PrintConnectors\DummyPrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Imagick;


/**
 * InvoicesController
 */
class PrinterController extends Controller
{

    public function __construct()
    {

        $this->printer_connection = 'network';

    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Focus\invoice\ManageInvoiceRequest $request
     * @return \App\Http\Responses\ViewResponse
     */

    public function thermal_print($invoice)
    {
        $defaults = feature(19);
        $conf = json_decode($defaults->value1, true);
        if ($conf['mode'] == 1) return $this->network_print_graphics($invoice);
        return $this->network_print($invoice);
    }

    public function browser_print(ManageInvoiceRequest $request)
    {
        $invoice = Invoice::where('id', '=', $request->id)->first();
        $invoice['type'] = 1;
        $prefix = 1;
        $title = trans('invoices.invoice_title');
        $invoice['custom'] = 2;
        $invoice['person'] = 1;
        $invoice['person_id'] = $invoice['customer_id'];
        $invoice['url'] = route('biller.invoices.show', $invoice->id);
        $invoice['title'] = 'invoice';
        if ($invoice['i_class'] > 1) {
            $prefix = 6;
            $title = trans('invoices.subscription');
        }
        $general = array('bill_type' => $title,
            'lang_bill_number' => trans('invoices.tid'),
            'lang_bill_date' => trans('invoices.invoice_date'),
            'lang_bill_due_date' => trans('invoices.invoice_due_date'
            ), 'direction' => 'ltr',
            'person' => trans('customers.customer'),
            'prefix' => $prefix, 'status_block' => true,);
        $valid_token = token_validator('', 'i' . $invoice['id'] . $invoice['tid'], true);

        $company = Company::where('id', '=', $invoice['ins'])->first();


        config([
            'currency' => ConfigMeta::where('feature_id', '=', 2)->where('ins', '=', $company['id'])->first()->currency
        ]);

        $general['tax_string_total'] = trans('general.total_tax');
        $general['tax_id'] = trans('general.tax_id');
        if ($invoice['tax_format'] == 'igst' or $invoice['tax_format'] == 'cgst') $general['tax_string_total'] = trans('general.total_gst');
        $general['tax_id'] = trans('general.gstin');


        $link['preview'] = route('biller.view_bill', [$invoice['id'], $invoice['type'], $valid_token, 0]);


        $data = array('general' => $general, 'invoice' => $invoice, 'company' => $company, 'link' => $link);

        $this->pheight = 0;
        session(['height' => 0]);
        if ($data['invoice']['status'] != 'paid') {
            $data['qrc'] = 'pos_' . date('Y_m_d_H_i_s') . '_';
            $qrCode = new QrCode($data['link']['preview']);
            $qrCode->writeFile(Storage::disk('public')->path('qr' . DIRECTORY_SEPARATOR . $data['qrc'] . '.png'));
            $data['image'] = Storage::disk('public')->url('app/public/qr/' . $data['qrc'] . '.png');
        }

        return view('focus.bill.print_compact_v1', $data);

    }


    public function network_print($invoice)
    {

        $output['currency'] = '$';
        $items = array();
        $sub_t = 0;
        foreach ($invoice->products as $row) {
            $items[] = $this->toString(@$row['product_name'], @$row['product_subtotal']);
            $sub_t += $row['product_price'] * $row['product_qty'];
        }

        $subtotal = $this->toString(trans('general.subtotal'), $sub_t);
        $tax = $this->toString(trans('general.tax'), $invoice['tax']);
        $total = $this->toString(trans('general.total'), $invoice['total'], true, $output['currency']);

        $date = dateFormat($invoice->invoicedate);
        try {
            switch ($this->printer_connection) {
                case 'network' :
                    $connector = new NetworkPrintConnector(feature(19)->value1, feature(19)->value2, 1);
                    break;
                case 'test' :
                    $connector = new DummyPrintConnector();
                    break;
            }


            $printer = new Printer($connector);
            // Print top logo
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->text(config('core.cname') . "\n");
            $printer->selectPrintMode();
            $printer->text(config('core.address') . ' ' . config('core.city') . "\n");
            $printer->feed();
            //Title of receipt
            $printer->setEmphasis(true);
            $printer->text(trans('invoices.invoice') . $invoice->tid . "\n");
            $printer->setEmphasis(false);
            //Items
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->setEmphasis(true);
            $printer->text($this->toString('', ''));
            $printer->setEmphasis(false);
            foreach ($items as $item) {
                $printer->text($item);
            }
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->setEmphasis(true);
            $printer->text($subtotal);
            $printer->setEmphasis(false);
            $printer->feed();
            // Tax and total
            $printer->text($tax);
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->text($total);
            $printer->selectPrintMode();
            // Footer
            $printer->feed(2);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text(trans('invoices.short_thank_you_note'));
            $printer->text("\n");
            $printer->feed(2);
            $printer->text($date . "\n");
            // Cut the receipt and open the cash drawer
            $printer->cut();
            if ($this->printer_connection == 'test') {
                $data = $connector->getData();
                header('Content-type: application/octet-stream');
                header('Content-Length: ' . strlen($data));
                $file = "pos_test_receipt_" . date('Y-m-d_H_i_s') . ".bin";
                file_put_contents($file, $data);
            }
            $printer->close();
            return trans('pos.print_command_sent');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function network_print_graphics($invoice)
    {

        $file_name = 'Invoice_' . '_' . $invoice->id;


        try {
            switch ($this->printer_connection) {
                case 'network' :
                    $address = "10.x.x.x";
                    $port = 9100;
                    $connector = new NetworkPrintConnector($address, $port);
                    break;
                case 'test' :
                    $connector = new DummyPrintConnector();
                    break;
            }
            $this->compact_pdf($invoice->id);
            $printer = new Printer($connector);
            $im = new Imagick();
            $im->setResolution(300, 300);
            $im->readimage(Storage::disk('public')->path('temp/' . $file_name . '.pdf'));
            $im->setImageType(imagick::IMGTYPE_TRUECOLOR);
            $im->setImageFormat('png');
            $im->writeImage(Storage::disk('public')->path('temp/' . $file_name . '.png'));
            $im->clear();
            $im->destroy();
            $printer->graphics(EscposImage::load(Storage::disk('public')->path('temp/' . $file_name . '.png')));
            $printer->cut();

            if ($this->printer_connection == 'test') {
                $data = $connector->getData();
                header('Content-type: application/octet-stream');
                header('Content-Length: ' . strlen($data));
                $file = "pos_test_receipt_" . date('Y-m-d_H_i_s') . ".bin";
                file_put_contents($file, $data);
            }

            unlink(Storage::disk('public')->path('temp/' . $file_name . '.png'));
            unlink(Storage::disk('public')->path('temp/' . $file_name . '.pdf'));
            $printer->close();
            return trans('pos.print_command_sent');
        } catch (\Throwable $e) {
            return trans('pos.print_command_error_imagick');
        }

    }

    function toString($name = '', $price = '', $dollarSign = false, $sign = '')
    {
        $rightCols = 10;
        $leftCols = 38;
        if ($dollarSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        $left = str_pad($name, $leftCols);


        $right = str_pad($sign . $price, $rightCols, ' ', STR_PAD_LEFT);
        return "$left$right\n";

    }

    public function compact_pdf($id)
    {
        $invoice = Invoice::where('id', '=', $id)->first();
        $invoice['type'] = 1;
        $prefix = 1;
        $title = trans('invoices.invoice_title');
        $invoice['custom'] = 2;
        $invoice['person'] = 1;
        $invoice['person_id'] = $invoice['customer_id'];
        $invoice['url'] = route('biller.invoices.show', $invoice->id);
        $invoice['title'] = 'invoice';
        if ($invoice['i_class'] > 1) {
            $prefix = 6;
            $title = trans('invoices.subscription');
        }
        $general = array('bill_type' => $title,
            'lang_bill_number' => trans('invoices.tid'),
            'lang_bill_date' => trans('invoices.invoice_date'),
            'lang_bill_due_date' => trans('invoices.invoice_due_date'
            ), 'direction' => 'ltr',
            'person' => trans('customers.customer'),
            'prefix' => $prefix, 'status_block' => true,);
        $valid_token = token_validator('', 'i' . $invoice['id'] . $invoice['tid'], true);

        $company = Company::where('id', '=', $invoice['ins'])->first();


        config([
            'currency' => ConfigMeta::where('feature_id', '=', 2)->where('ins', '=', $company['id'])->first()->currency
        ]);

        $general['tax_string_total'] = trans('general.total_tax');
        $general['tax_id'] = trans('general.tax_id');
        if ($invoice['tax_format'] == 'igst' or $invoice['tax_format'] == 'cgst') $general['tax_string_total'] = trans('general.total_gst');
        $general['tax_id'] = trans('general.gstin');


        $link['preview'] = route('biller.view_bill', [$invoice['id'], $invoice['type'], $valid_token, 0]);


        $data = array('general' => $general, 'invoice' => $invoice, 'company' => $company, 'link' => $link);

        $this->pheight = 0;
        session(['height' => 0]);

        if ($data['invoice']['status'] != 'paid') {
            $data['qrc'] = 'pos_' . date('Y_m_d_H_i_s') . '_';
            $qrCode = new QrCode($data['link']['preview']);
            $qrCode->writeFile(Storage::disk('public')->path('qr/' . $data['qrc'] . '.png'));
            $data['image'] = Storage::disk('public')->path('qr/' . $data['qrc'] . '.png');

        }

        $html = view('focus.bill.print_compact_v1', $data)->render();
        $h = session('height');
        $file_name = 'Invoice_' . '_' . $data['invoice']['id'];
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'margin_left' => 1, 'margin_right' => 1, 'margin_top' => 1, 'margin_bottom' => 1]);
        $mpdf->_setPageSize(array(58, $h), $mpdf->DefOrientation);
        $mpdf->WriteHTML($html);
        ob_clean();
        $mpdf->Output(Storage::disk('public')->path('temp/' . $file_name . '.pdf'), 'F');
        if (isset($data['qrc'])) unlink(Storage::disk('public')->path('qr/' . $data['qrc'] . '.png'));

    }


}
