@extends('admin.template.master')

@section('content')
<div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Delivered Orders List</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
					
                    <table id="all_orders_table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Order Id</th>
                            <th>User Name</th>
                            <th>Payment Id</th>
                            <th>Payment Status</th>
                            <th>Order Date</th>
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

    $('#all_orders_table').DataTable({

        "processing": true,
        "serverSide": true,
        "ajax":{
            "url": "{{ route('admin.orders_list_data') }}",
            "dataType": "json",
            "type": "POST",
            "data":{ 
                _token: "{{csrf_token()}}",
                'status': 3
            }
        },
        "columns": [
            { "data": "id" },
            { "data": "order_id" },
            { "data": "user_name" },
            { "data": "payment_id" },
            { "data": "payment_status" },
            { "data": "order_date" },
            { "data": "action" },
        ],    
    });
});
</script>
@endsection