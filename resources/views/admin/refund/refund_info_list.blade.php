@extends('admin.template.master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
    	<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:50px;">
    	    <div class="x_panel"> 
            @if (Session::has('message'))
              <div class="alert alert-success">{{ Session::get('message') }}</div>
            @endif @if (Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif

    	        <div class="x_title">
                    <h2>Refund Info List</h2>
                    <div class="clearfix"></div>
    	        </div>
    	        <div>
    	            <div class="x_content">
                        <table id="category" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Sl</th>
                              <th>User Name</th>                              
                              <th>Order ID</th>
                              <th>Amount</th>
                              <th>Reason</th>
                              <th>Account No</th>
                              <th>Account Name</th>
                              <th>IFSC</th>
                              <th>Branch</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>  
                            @if (isset($refund) && !empty($refund))
                            @php
                              $count=1;
                            @endphp
                                @foreach ($refund as $item)
                                    <tr>
                                      <td>{{$count++}}</td>
                                      <td>{{$item->user->name??null}}</td>
                                      <td>{{$item->order->order_id??null}}</td>
                                      <td>{{$item->order->amount??null}}</td>
                                      <td>{{$item->reasons}}</td>
                                      <td>{{$item->ac_no}}</td>
                                      <td>{{$item->ac_name}}</td>
                                      <td>{{$item->ifsc}}</td>
                                      <td>{{$item->branch}}</td>
                                      <td>@if($item->status==1)
                                            <button class="btn btn-warning">Pending</button>
                                          @else
                                            <button class="btn btn-success">Paid</button>
                                          @endif
                                      </td>
                                      <td>@if(empty($item->reasons))
                                            <a href="{{route('admin.add_refund_details',['id'=>$item->id])}}" class="btn btn-warning">Add Account Details</a>
                                         @endif
                                         @if($item->status==1 && !empty($item->reasons))
                                            <a   onclick="if (!confirm('Are you sure?')) return false;" href="{{route('admin.refund_now',['id'=>$item->id])}}" class="btn btn-primary">Refund</a>
                                         @else
                                          @if($item->status==2)
                                            <a   class="btn btn-info">Already Refunded</a>
                                          @endif
                                         @endif
                                      </td>
                                      
                                    </tr>
                                @endforeach
                            @else
                              <tr>
                                <td colspan="6" style="text-align: center">No Refund Details Found</td>
                              </tr>  
                            @endif                   
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
         $(function () {
            var table = $('#category').DataTable();
        });
     </script>
    
 @endsection