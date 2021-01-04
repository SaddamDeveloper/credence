@extends('admin.template.master')

@section('content')
<div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>New Orders List</h2>
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

      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Enter Dispatch Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <textarea class="form-control" placeholder="e.g Package Dispatched through ecom express with tracking no: AWB342334" id="awb_no"></textarea>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="submit">Submit</button>
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
                'status': 1
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
    $(document).on('click', '#out', function(){
      $('#exampleModal').modal('toggle');
      var id = $(this).data('id');
    $(document).on('click', '#submit', function(){
      const awb_no = $('#awb_no').val();
      const order_id = id;
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          type:"POST",
          url:"{{ route('admin.out_for_delivery') }}",
          data: {awb_no: awb_no, order_id: order_id},
          success:function(data){
             if(data == 1){
               alert('Successfully for out for delivery');
               $('#exampleModal').modal('toggle');
               window.location.reload();
             }else{
               alert('Something went wrong!');
             }
          }
      });
    });
  });
});
</script>
@endsection