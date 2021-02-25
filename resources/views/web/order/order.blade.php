@extends('web.templet.master')

{{-- @include('web.include.seo') --}}

@section('seo')
  <meta name="description" content="Credence">
@endsection

@section('content')
  <!-- JTV Home Slider -->
  <section class="main-container col2-left-layout">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-2"></div>:
        <div class="col-sm-9">
          <article class="col-main" style="width: 100%;">
            <div class="container-fluid">
                <div class="row">
                  <div class="col-md-1"></div>
                  <div class="col-md-9">
                      <div class="block-title" style="border-bottom: 0;text-decoration: underline;">MY ORDERS</div>
                      <div class="row singleorder">
                          @if (isset($orders) && !empty($orders))
                          <div>
                          <table class="table table-responsive text-center">
                              <thead>
                              <tr>
                                  <th class="text-center">Order ID</th>
                                  <th class="text-center">Track ID</th>
                                  <th class="text-center">Order Date</th>
                                  <th class="text-center">Order Status</th>
                                  <th class="text-center">Action</th>
                              </tr>
                              </thead>
                              <tbody>
                                  @foreach ($orders as $order)
                                      <tr>
                                          <td>{{ $order->order_id }}</td>
                                          <td>
                                            @if ($order->order_status == 1)
                                                <label class="label label-warning">Pending</label>
                                            @else
                                              {{ $order->awb_no }}</td>
                                            @endif
                                          <td>{{ $order->created_at }}</td>
                                          <td>
                                            @if ($order->order_status == 1)
                                                <label class="label label-warning">Pending</label>
                                            @elseif($order->order_status == 2)
                                                <label class="label label-info">Shipped</label>
                                            @elseif($order->order_status == 3)
                                                <label class="label label-success">Delivered</label>
                                            @elseif($order->order_status == 4)
                                                <label class="label label-danger">Canceled</label>
                                            @elseif($order->order_status == 5)
                                                <label class="label label-warning">Return Requested</label>
                                            @elseif($order->order_status == 6)
                                                <label class="label label-success">Return Request Accepted</label>
                                            @elseif($order->order_status == 7)
                                                <label class="label label-danger">Return Request Rejected</label>
                                            @elseif($order->order_status ==8)
                                                <label class="label label-success">Returned</label>
                                            @elseif($order->order_status ==9)
                                              <label class="label label-warning">Exchange Requested</label>
                                            @elseif($order->order_status ==10)
                                              <label class="label label-success">Exchange Request Accepted</label>
                                            @elseif($order->order_status ==11)
                                              <label class="label label-danger">Exchange Request Rejected</label>
                                            @elseif($order->order_status ==12)
                                              <label class="label label-success">Exchanged</label>
                                            @endif
                                          </td>
                                          <td>
                                            <a class="btn btn-primary" href="{{ route('web.order.order_details', ['id' =>$order->id]) }}">View details</a>
                                            @if($order->order_status ==1 || $order->order_status ==2 )
                                              <a class="btn btn-danger"  onclick="if (!confirm('Are you sure?')) return false;" href="{{ route('web.order.cancel_order', ['order_id' =>$order->id]) }}">Cancel Order</a>
                                            @endif
                                            @php
                                                $delivery_date = $order->updated_at;
                                                $today_date = Carbon\Carbon::now();
                                                $new = Carbon\Carbon::parse($delivery_date);
                                                $today= Carbon\Carbon::now()->toDateString();
                                                if( $new->diffInDays($today) <=7){
                                                  $status =1;
                                                }else{
                                                  $status =2;
                                                }
                                            @endphp
                                            @if($order->order_status ==3 && $status ==1 && $order->order_status != 5 && $order->order_status !=9 && $order->order_status != 8)
                                              <a class="btn btn-warning"  onclick="if (!confirm('Are you sure?')) return false;" href="{{route('web.order.return_request',['id'=>$order->id])}}">Return Order</a>
                                            @endif
                                            @if($order->order_status ==3 && $order->order_status !=5)
                                            <a class="btn btn-info"  onclick="if (!confirm('Are you sure?')) return false;" href="{{route('web.order.exchange_request',['id'=>$order->id])}}">Exchange Order</a>
                                            @endif
                                          </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                              </table>
                              </div>
                        @else
                            <div class="row">
                              <div class="col-md-12">
                                  <span>No Orders Yet</span>
                              </div>
                            </div>
                        @endif
                      </div>
                    <a href="{{route('web.index')}}" class="button text-center">GO TO HOME</a>
                  </div>
                </div>
            </div>
          </article>
          <!--  ///*///======    End article  ========= //*/// -->
        </div>
      </div>
    </div>
  </section>

@endsection

@section('script')
@endsection