@extends('admin.template.master')

@section('content')
<div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Active Products List</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
					
                    <table id="all_product_table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                            <th>Sl No</th>
							<th>Image</th>
                            <th>Product Name</th>
							<th>Slug</th>
							<th>Top-Category</th>
							<th>Sub-Category</th>
                            <th>3rd Sub-Category</th>
                            <th>Brand</th>
                            <th>Product Images</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
@endsection

@section('script')
<script type="text/javascript">
    
$(document).ready(function(){

    $('#all_product_table').DataTable({

        "processing": true,
        "serverSide": true,
        "ajax":{
            "url": "{{ route('admin.active_in_active_product_list_data') }}",
            "dataType": "json",
            "type": "POST",
            "data":{ 
                _token: "{{csrf_token()}}",
                'status': 1
            }
        },
        "columns": [
            { "data": "id" },
			{ "data": "image" },
            { "data": "product_name" },
            { "data": "slug" },
			{ "data": "top_category" },
            { "data": "sub_category" },
            { "data": "third_sub_category" },
            { "data": "brand" },
            { "data": "product_images" },
            { "data": "action" }
        ],    
    });
});
</script>
@endsection