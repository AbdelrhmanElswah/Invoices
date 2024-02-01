<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\invoices_attachments;
use App\Models\invoices_details;
use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices=Invoices::all();
        return view('invoices.invoices',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections=Sections::all();
        return view('invoices.add_invoice',compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         Invoices::create([
            'invoice_number'=>$request->invoice_number,
            'invoice_Date'=>$request->invoice_Date,
            'due_date'=>$request->Due_date,
            'section_id'=>$request->Section,
            'product'=>$request->product,
            'Amount_collection'=>$request->Amount_collection,
            'Amount_Commission'=>$request->Amount_Commission,
            'discount'=>$request->Discount,
            'rate_vat'=>$request->Rate_VAT,
            'value_vat'=>$request->Value_VAT,
            'Total'=>$request->Total,
            'Status'=>'Pending',
            'value_status'=>2,
            'note'=>$request->note,
        ]);
        $inv_id=Invoices::latest()->first()->id;
        invoices_details::create([
            'id_invoice'=>$inv_id,
            'invoice_number'=>$request->invoice_number,
            'product'=>$request->product,
            'Section'=>$request->Section,
            'Status'=>'unpayment',
            'value_status'=>2,
            'note'=>$request->note,
            'user'=>(Auth::user()->name)
        ]);
        if($request->hasFile('pic')){
        $inv_id=Invoices::latest()->first()->id;
        $image=$request->file('pic');
        $file_name=$image->getClientOriginalName();
        $user=(Auth::user()->name);
        $invoice_num=$request->invoice_number;


        $attachments= new invoices_attachments();
        $attachments->file_name=$file_name;
        $attachments->Created_by =$user;
        $attachments->invoice_number=$invoice_num;
        $attachments->invoice_id=$inv_id;
        $attachments->save();
        $request->pic->move(public_path('Attachments/'.$invoice_num),$file_name);
        }
        session()->flash('Add', 'Done ');
        return redirect('/invoices');


    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoices=Invoices::where('id',$id)->first();
        return view('invoices.status_update',compact('invoices'));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoices=Invoices::where('id',$id)->first();
        $sections=Sections::all();
        return view('invoices.edit_invoice',compact('invoices','sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $invoices=Invoices::findOrFail($request->invoice_id);
        $invoices->update([
            'invoice_number'=>$request->invoice_number,
            'invoice_Date'=>$request->invoice_Date,
            'due_date'=>$request->Due_date,
            'section_id'=>$request->Section,
            'product'=>$request->product,
            'Amount_collection'=>$request->Amount_collection,
            'Amount_Commission'=>$request->Amount_Commission,
            'discount'=>$request->Discount,
            'rate_vat'=>$request->Rate_VAT,
            'value_vat'=>$request->Value_VAT,
            'Total'=>$request->Total,
            'note'=>$request->note,
        ]);
        session()->flash('edit', 'Modified');
        return back();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id=$request->invoice_id;
        $invoices=Invoices::where('id',$id)->first();
        $details = invoices_attachments::where('invoice_id',$id)->first();
        if(!empty($details->invoice_number)){
            Storage::disk('public_uploads')->deleteDirectory($details->invoice_number);
        }
        $invoices->forceDelete();
        session()->flash('delete_invoice');
        return redirect('invoices');    
    }
    public function getproduct($id)
    {
        $product=DB::table('products')->where('section_id',$id)->pluck('product_name','id');
        return json_encode($product);
    }
    public function Status_Update($id, Request $request ){
        $invoices = invoices::findOrFail($id);

        if ($request->Status === 'Paid') {

            $invoices->update([
                'Value_Status' => 1,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);

            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }

        else {
            $invoices->update([
                'Value_Status' => 3,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 3,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }
        session()->flash('Status_Update');
        return redirect('/invoices');


    }
}