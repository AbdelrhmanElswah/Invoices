@extends('layouts.master')


@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">{{$invoices->section->section_name}}</h4>
        </div>
    </div>
</div>
</div>

@endsection

@section('content')
<div class="panel panel-primary tabs-style-2">
	<div class=" tab-menu-heading">
		<div class="tabs-menu1">
			<!-- Tabs -->
			<ul class="nav panel-tabs main-nav-line">
				<li><a href="#tab4" class="nav-link active" data-toggle="tab">Bill_Details</a></li>
				<li><a href="#tab5" class="nav-link" data-toggle="tab">Payment_Status</a></li>
				<li><a href="#tab6" class="nav-link" data-toggle="tab">Attachments</a></li>
			</ul>
		</div>
	</div>
	<div class="panel-body tabs-menu-body main-content-body-right border">
		<div class="tab-content">
			<div class="tab-pane active" id="tab4">
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">Bill No.</th>
                                <th class="border-bottom-0">Bill Date</th>
                                <th class="border-bottom-0">Due date</th>
                                <th class="border-bottom-0">Product</th>
                                <th class="border-bottom-0">Discount</th>
                                <th class="border-bottom-0">Tax rate</th>
                                <th class="border-bottom-0">Tax value</th>
                                <th class="border-bottom-0">Total</th>
                                <th class="border-bottom-0">Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$invoices->invoice_number}}</td>
                                <td>{{$invoices->invoice_Date}}</td>
                                <td>{{$invoices->due_date}}</td>
                                <td>{{$invoices->product}}</td>
                                <td>{{$invoices->discount}}</td>
                                <td>{{$invoices->rate_vat}}</td>
                                <td>{{$invoices->value_vat}}</td>
                                <td>{{$invoices->Total}}</td>
                                <td>{{$invoices->note}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
			<div class="tab-pane" id="tab5">
				<div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>  
                                <th class="border-bottom-0">Bill No.</th>  
                                <th class="border-bottom-0">Product</th>
                                <th class="border-bottom-0">Status</th>
                                <th class="border-bottom-0">Note</th>
                                <th class="border-bottom-0">Created_at</th>
                                <th class="border-bottom-0">User</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i=0;
                            @endphp
                            @foreach($details as $x)
                            @php
                                $i++
                            @endphp
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$x->invoice_number}}</td>
                                <td>{{$x->product}}</td>
                                <td>@if ($x->value_status ==1)
                                    <span class="text-success">{{$x->Status}}</span>
                                    @elseif($x->value_status ==2)
                                    <span class="text-danger">{{$x->Status}}</span>
                                    @else
                                    <span class="text-warning">{{$x->Status}}</span>
                                    @endif</td>
                                <td>{{$x->note}}</td>
                                <td>{{$x->created_at}}</td>
                                <td>{{$x->user}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
			</div>
			<div class="tab-pane" id="tab6"> 
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>  
                                <th class="border-bottom-0">File_Name</th>  
                                <th class="border-bottom-0">User</th>
                                <th class="border-bottom-0">Created_at</th>
                                <th class="border-bottom-0">Processes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i=0;
                            @endphp
                            @foreach($attachments as $attachmet)
                            @php
                                $i++
                            @endphp
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$attachmet->file_name}}</td>
                                <td>{{$attachmet->Created_by}}</td>
                                <td>{{$attachmet->created_at}}</td>
                                <td colspan="2">
                                    <a class="btn btn-outline-success btn-sm"
                                    href="{{url('view_file')}}/{{$invoices->invoice_number}}/{{$attachmet->file_name}}"
                                    role="button"><i class="fas fa-eye"></i>&nbsp; Show </a>
                                    
                                    <a class="btn btn-outline-info btn-sm"
                                    href="{{url('download')}}/{{$invoices->invoice_number}}/{{$attachmet->file_name}}"
                                    role="button"><i class="fas fa-download"></i>&nbsp; Download </a>
                                    
                                    <button class="btn btn-outline-danger btn-sm"
                                    data-toggle="modal"
                                    data-file_name={{$attachmet->file_name}}
                                    data-invoice_number={{$attachmet->invoice_number}}
                                    data-id_file={{$attachmet->id}}
                                    data-target=#delete_file>Delete</button>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

			</div>
		</div>
	</div>
</div>
@endsection
@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Jquery.mCustomScrollbar js-->
    <script src="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- Internal Input tags js-->
    <script src="{{ URL::asset('assets/plugins/inputtags/inputtags.js') }}"></script>
    <!--- Tabs JS-->
    <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
    <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>
    <!--Internal  Clipboard js-->
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>
    <!-- Internal Prism js-->
    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>
@endsection
