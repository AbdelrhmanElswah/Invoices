@extends('layouts.master')
@section('title')
Products
@stop
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
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">Settings</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Products</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
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
				<!-- row -->
				<div class="row">
					<div class="col-xl-12">
						<div class="card mg-b-20">
									<a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8" >Add a product</a>
							<div class="card-body">
								<div class="table-responsive">
									<table id="example1" class="table key-buttons text-md-nowrap">
										<thead>
											<tr>
												<th class="border-bottom-0">#</th>
												<th class="border-bottom-0">Product_Name</th>
												<th class="border-bottom-0">Section_Name</th>
												<th class="border-bottom-0">Notes</th>
												<th class="border-bottom-0">Processes</th>
											</tr>
										</thead>
										<tbody>
											<?php $i =0?>		
											@foreach($products as $Product)
											<?php $i++?>
											<tr>
												<td>{{$i}}</td>
												<td>{{$Product->product_name}}</td>
												<td>{{$Product->section->section_name}} </td>
												<td>{{$Product->notes}}</td>

												<td>
													<a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
													data-name="{{ $Product->product_name }}" data-pro_id="{{ $Product->id}}"
													data-section_name="{{ $Product->section->section_name }}"
													data-description="{{ $Product->notes }}" data-toggle="modal"
													href="#edit_Product" title="Edit"><i class="las la-pen"></i></a>
			
														<a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
														data-pro_id="{{ $Product->id}}" data-product_name="{{ $Product->Product_name }}" data-toggle="modal"
														 href="#delete_product" title="Delete"><i class="las la-trash"></i></a>		
												</td>											
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
							<div class="modal" id="modaldemo8">
								<div class="modal-dialog" role="document">
									<div class="modal-content modal-content-demo">
										<div class="modal-header">
											<h6 class="modal-title">Add a product</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
										</div>
										<div class="modal-body">
											<form action="{{route('products.store')}}" method="post" autocomplete="off">
												{{csrf_field()}}
												<div class="modal-body">
													<div class="form-group">
														<label for="exampleInputEmail1">Product_Name</label>
														<input type="text" class="form-control" id="Product_name" name="Product_name" required >
			
													</div>
			
													<label class="my-1 mr-2" for="inlineFormCustomSelectPref">Section</label>
													<select name="section_id" id="section_id" class="form-control" required>
														<option value="" selected disabled> -- Select --</option>
														@foreach ($sections as $section)
															<option value="{{ $section->id }}">{{ $section->section_name }}</option>
														@endforeach
													</select>
			
													<div class="form-group">
														<label for="exampleFormControlTextarea1">Notes</label>
														<textarea class="form-control" id="description" name="description" rows="3"></textarea>
													</div>
			
												</div>
												<div class="modal-footer">
													<button type="submit" class="btn btn-success">Confirm</button>
													<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
												</div>
											</form>

										</div>
									</div>
								</div>
							</div>
							
						</div>
					</div>	
					<div class="modal fade" id="edit_Product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
					aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Product Modification</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<form action='products/update' method="post">
								{{ method_field('patch') }}
								{{ csrf_field() }}
								<div class="modal-body">
		
									<div class="form-group">
										<label for="title">Product Name</label>
										<input type="hidden" class="form-control" name="pro_id" id="pro_id" value="">
										<input type="text" class="form-control" name="Product_name" id="Product_name">
									</div>
		
									<label class="my-1 mr-2" for="inlineFormCustomSelectPref">Section</label>
									<select name="section_name" id="section_name" class="custom-select my-1 mr-sm-2" required>
										@foreach ($sections as $section)
											<option>{{ $section->section_name }}</option>
										@endforeach
									</select>
		
									<div class="form-group">
										<label for="des"> Notes</label>
										<textarea name="description" cols="20" rows="5" id='description'
											class="form-control"></textarea>
									</div>
		
								</div>
								<div class="modal-footer">
									<button type="submit" class="btn btn-primary">Confirm</button>
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								</div>
							</form>
						</div>
					</div>
					
				</div>
				<div class="modal fade" id="delete_product">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content modal-content-demo">
						<div class="modal-header">
							<h6 class="modal-title">Delete product</h6>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form action="products/destroy" method="post">
							{{ method_field('delete') }}
							{{ csrf_field() }}
							<div class="modal-body">
								<p>Are sure of deleting this row ?</p><br>
								<input type="hidden"  name="pro_id" id="pro_id" value="">
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
								<button type="submit" class="btn btn-danger">Cofirm</button>
							</div>
						</form>
					</div>
				</div>
			</div>

				</div>
				<!-- row closed -->
		
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
<script src="{{URL::asset('assets/js/modal.js')}}"></script>

<script>
	$('#edit_Product').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var Product_name = button.data('name')
		var section_name = button.data('section_name')
		var description = button.data('description')
		var pro_id = button.data('pro_id')
		var modal = $(this)
		modal.find('.modal-body #Product_name').val(Product_name);
		modal.find('.modal-body #section_name').val(section_name);
		modal.find('.modal-body #description').val(description);
		modal.find('.modal-body #pro_id').val(pro_id);
	})
	
	$('#delete_product').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var Product_name = button.data('Product_name')
			var pro_id = button.data('pro_id')
            var modal = $(this)

            modal.find('.modal-body #Product_name').val(Product_name);
			modal.find('.modal-body #pro_id').val(pro_id);
        })

    </script>
@endsection