@extends('admin.template.master')

@section('content')
<div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Exchange Request Orders List</h2>
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
                            <th>Track ID</th>
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
    
    var table = $('#all_orders_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('admin.exchange_request_list_ajax') }}",
    columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
        {data: 'order_id', name: 'order_id',searchable: true},
        {data: 'awb_no', name: 'awb_no',searchable: true},
        {data: 'username', name: 'username',searchable: true},
        {data: 'payment_id', name: 'payment_id' ,searchable: true},
        {data: 'payment_status', name: 'payment_status' ,searchable: true},  
        {data: 'order_date', name: 'order_date', searchable: true},                
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]
});
</script>
@endsection