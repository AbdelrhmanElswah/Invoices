@extends('layouts.master')
@section('title')
Bills List
@stop
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>

@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">Bills</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Bills list</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
@if (session()->has('Add'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ session()->get('Add') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@if (session()->has('edit'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('edit') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if (session()->has('delete'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('delete') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if (session()->has('delete_invoice'))
<script>
	window.onload = function() {
		notif({
			msg: "Deleted",
			type: "success"
		})
	}

</script>
@endif
@if (session()->has('Status_Update'))
        <script>
            window.onload = function() {
                notif({
                    msg: "Payment status has been updated",
                    type: "success"
                })
            }

        </script>
    @endif

				<!-- row -->
				<div class="row">
						<!--div-->
						
						<div class="col-xl-12">
							<div class="card mg-b-20">
								<div class="card-header pb-0">
										<a  class="modal-effect btn btn-outline-primary btn-block" href="invoices/create">Add a bill</a>
								<div class="card-body">
									<div class="table-responsive">
										<table id="example1" class="table key-buttons text-md-nowrap">
											<thead>
												<tr>
													<th class="border-bottom-0">#</th>
													<th class="border-bottom-0">Bill No.</th>
													<th class="border-bottom-0">Bill Date</th>
													<th class="border-bottom-0">Due date</th>
													<th class="border-bottom-0">Product</th>
													<th class="border-bottom-0">Section</th>
													<th class="border-bottom-0">Discount</th>
													<th class="border-bottom-0">Tax rate</th>
													<th class="border-bottom-0">Tax value</th>
													<th class="border-bottom-0">Total</th>
													<th class="border-bottom-0">Status</th>
													<th class="border-bottom-0">Notes</th>
													<th class="border-bottom-0">Processes</th>
												</tr>
											</thead>
											<tbody>
												@php
													$i=0
												@endphp
												@foreach ($invoices as $item)
												@php
													$i++
												@endphp
												<tr>
													<td>{{$i}}</td>
													<td>{{$item->invoice_number}}</td>
													<td>{{$item->invoice_Date}}</td>
													<td>{{$item->due_date}}</td>
													<td>{{$item->product}}</td>
													<td><a href="{{url('InvoicesDetails')}}/{{$item->id}}"> {{$item->section->section_name}}</a></td>
													<td>{{$item->discount}}</td>
													<td>{{$item->rate_vat}}</td>
													<td>{{$item->value_vat}}</td>
													<td>{{$item->Total}}</td>
													<td>
														@if ($item->value_status ==1)
														<span class="text-success">{{$item->Status}}</span>
														@elseif($item->value_status ==2)
														<span class="text-danger">{{$item->Status}}</span>
														@else
														<span class="text-warning">{{$item->Status}}</span>
														@endif
													</td>
													<td>{{$item->note}}</td>
													<td><div class="dropdown">
														<button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary"
														data-toggle="dropdown" id="dropdownMenuButton" type="button">Processes<i class="fas fa-caret-down ml-1"></i></button>
														<div  class="dropdown-menu tx-13">
															<a class="dropdown-item" href="{{url('edit_invoice')}}/{{$item->id}}"
																><i class="fa fa-cogs"></i>&nbsp;&nbsp;Edit Bill</a>
															<a class="dropdown-item" href="#" data-invoice_id="{{ $item->id }}"
																data-toggle="modal" data-target="#delete_invoice"><i
																	class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;Delete Bill</a>
																	<a class="dropdown-item"
                                                            href="{{ URL::route('Status_show', [$item->id]) }}"><i
                                                                class=" text-success fas fa-money-bill"></i>&nbsp;&nbsp;
                                                            Payment Status</a>
														</div>
													</div>
													</td>
													
												</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>	
						<div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
						aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Delete Bill</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									<form action="{{ route('invoices.destroy', 'test') }}" method="post">
										{{ method_field('delete') }}
										{{ csrf_field() }}
								</div>
								<div class="modal-body">
									Are you sure about deleting the bill ?
									<input type="hidden" name="invoice_id" id="invoice_id" value="">
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
									<button type="submit" class="btn btn-danger">Confirm</button>
								</div>
								</form>
							</div>
						</div>
					</div>
					</div>
				</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<script>
	$('#delete_invoice').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var invoice_id = button.data('invoice_id')
		var modal = $(this)
		modal.find('.modal-body #invoice_id').val(invoice_id);
	})

</script>
<script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
<script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>
@endsection