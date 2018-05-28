<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\SaleInvoice;
use App\Customer;
use App\Unit;
use App\Contact;
use App\Business;
use App\Driver;
use App\Vehicle;

class FileController extends Controller
{
    public function importExportExcelORCSV()
    {
        return view('file_import_export');
    }

    public function makeManifest()
    {
        \PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif','enable_html5_parser' => true, 'orientation'=> 'landscape' ]);

        $data =  [
            'invoice' => SaleInvoice::first(),
            'business' => Business::first(),
            'driver' => Driver::first(),
            'vehicle' => Vehicle::first(),
            'invoice' => SaleInvoice::first(),
            'products' => SaleInvoice::all(),
        ];

/*       return view('manifest_pg1',$data);*/

       $pdf = \PDF::loadView('manifest_pg1', $data);
        return $pdf->stream('manifest.pdf');


    }

    public function get_contact($customer_id)
    {
        $name = 'noo contact';
        if ($customer_id) {
            $sku = [];
            $skus = Contact::where('customer_id', '1');
            foreach ($skus as $skuItem) {
                $name = $skuItem->name;
                break;
            }
        }
        return $name;
    }

    public function importUnitsIntoDB()
    {

        $path = storage_path('app/public/product.uom.csv');
        $data = \Excel::load($path)->get();
        if ($data->count()) {
            foreach ($data as $key => $value) {
                $arr[] = [
                    'ext_id' => $value->id,
                    'name' => $value->name,
                ];

            }
            if (!empty($arr)) {
                \DB::table('units')->delete();
                \DB::table('units')->insert($arr);
                dd('Insert Units Records successfully.');
            }
        }
        dd('Request data does not have any files to import.');
    }

    public function importInvoiceIntoDB()
    {

        $path = storage_path('app/public/sale.order.csv');
        $data = \Excel::load($path)->get();
        if ($data->count()) {
            foreach ($data as $key => $value) {
                $arr[] = [
                    'ext_id_shipping' => $value->partner_shipping_idid,
                    'order_date' => date_format(date_create($value->date_order), "Y-m-d"),
                    'invoice_number' => $value->name,
                    'name' => $value->order_linename,
                    'quantity' => $value->order_lineproduct_uom_qty,
                    'ext_id_unit' => $value->order_lineproduct_uomid,
                    'unit_price' => $value->order_lineprice_unit,
                ];

            }
            if (!empty($arr)) {
                \DB::table('sale_invoices')->delete();
                \DB::table('sale_invoices')->insert($arr);
                dd('Insert Invoice Records successfully.');
            }
        }
        dd('Request data does not have any files to import.');
    }

    public function importCustomersIntoDB()
    {

        $path = storage_path('app/public/res.partner.csv');
        $data = \Excel::load($path)->get();
        if ($data->count()) {
            foreach ($data as $key => $value) {
                $arr[] = [
                    'ext_id' => $value->id,
                    'ext_id_contact' => $value->child_idsid,
                    'name' => $value->name,
                    'street' => $value->street,
                    'street2' => $value->street2,
                    'city' => $value->city,
                    'zip' => $value->zip,
                    'phone' => $value->phone,
                    'license' => $value->x_studio_field_mu5dt
                ];

            }
            if (!empty($arr)) {
                \DB::table('customers')->delete();
                \DB::table('customers')->insert($arr);
                dd('Insert Customers Records successfully.');
            }
        }
        dd('Request data does not have any files to import.');
    }

    public function importContactsIntoDB()
    {
        $path = storage_path('app/public/res.partner.csv');
        $data = \Excel::load($path)->get();
        if ($data->count()) {
            foreach ($data as $key => $value) {
                $arr[] = [
                    'ext_id' => $value->id,
                    'name' => $value->name,
                    'phone' => $value->phone,
                    'customer_id' => $value->parent_idid,
                ];

            }
            if (!empty($arr)) {
                \DB::table('contacts')->delete();
                \DB::table('contacts')->insert($arr);
                dd('Insert Contacts Records successfully.');
            }
        }
        dd('Request data does not have any files to import.');
    }

    public function importProductsIntoDB()
    {

        $path = storage_path('app/public/product.template.csv');
        $data = \Excel::load($path)->get();
        if ($data->count()) {
            foreach ($data as $key => $value) {
                $arr[] = [
                    'ext_id' => $value->id,
                    'name' => $value->name,
                    'description' => $value->name,
                ];

            }
            if (!empty($arr)) {
                \DB::table('products')->delete();
                \DB::table('products')->insert($arr);
                dd('Inserted Product Records successfully.');
            }
        }
        dd('Request data does not have any files to import.');
    }


    public function downloadExcelFile($type)
    {
        $products = Product::get()->toArray();
        return \Excel::create('expertphp_demo', function ($excel) use ($products) {
            $excel->sheet('sheet name', function ($sheet) use ($products) {
                $sheet->fromArray($products);
            });
        })->download($type);
    }
}
