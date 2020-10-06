@extends('admin.template.master')

@section('content')
<div class="right_col" role="main">

    <div class="row">    

      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel" id="printable">
            
            <div class="x_title" style="border-bottom: white;">
              

              
              <div class="col-xs-12 col-sm-12 col-md-12">
                
            <div style="text-align: center"><h3>Order Detail</h3></div>

                <div class="col-md-4 col-sm-4 col-xs-4">
                    <h2>Order Account<small></small></h2><br><br>
                    <table> 
                        <tr>
                          <th>Name : </th>
                          <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                          <th>Email : </th>
                          <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                          <th>Mobile No : </th>
                          <td>{{ $user->contact_no }}</td>
                        </tr>
                        <tr>
                          <th>Opening Date : </th>
                          <td>{{ \Carbon\Carbon::parse($user->created_at)->toDayDateTimeString() }}</td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-4 col-sm-4 col-xs-4">
                    <h2>Payment Info.<small></small></h2><br><br>
                    <table> 
                        <tr>
                          <th>Order ID : </th>
                          <td>{{ $order->order_id }}</td>
                        </tr>
                        <tr>
                            @if($order->payment_type == 1)
                            <th>Payment Type : </th>
                          @else
                            <th>Payment Id : </th>
                          @endif
                          <td>
                            @if($order->payment_type == 1)
                              COD
                            @else
                              {{ $order->payment_id }}
                            @endif
                          </td>
                        </tr>
                        <tr>
                          <th>Status : </th>
                          <td>
                                @if($order->payment_status == 1)
                                      Failed
                                @elseif($order->payment_status == 2) 
                                  @if($order->cashondelivery == 1)
                                      COD PAY
                                  @else
                                      Paid VIA Online Pay
                                  @endif
                                @else
                                    No Action
                                @endif
                          </td>
                        </tr>
                        <tr>
                          <th>Order Date : </th>
                          <td>{{ \Carbon\Carbon::parse($order->created_at)->toDayDateTimeString() }}</td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-4 col-sm-4 col-xs-4">
                    <h2>Billing Address<small></small></h2><br><br>
                   <table>
                        <tr>
                          <th>Name : </th>
                          <td>{{ $address->name }}</td>
                        </tr> 
                        <tr>
                          <th>Address : </th>
                          <td>{{ $address->address }}</td>
                        </tr>
                        <tr>
                          <th>Email : </th>
                          <td>{{ $address->email }}</td>
                        </tr> 
                        <tr>
                          <th>Mobile No : </th>
                          <td>{{ $address->mobile_no }}</td>
                        </tr>
                        <tr>
                          <th>City & PIN : </th>
                          <td>{{ $address->city }}, {{ $address->pin_code }}</td>
                        </tr>
                        <tr>
                          <th>State : </th>
                          <td>{{ $address->state }}</td>
                        </tr>
                   </table>   
              </div>
                
                        
              </div>
            

            <div class="x_content table-responsive">
            <table class="table table-striped jambo_table bulk_action" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Sl</th>
                  <th>Product Name</th>
                  <th>Size</th>
                  <th>Color</th>
                  <th>Quantity</th>
                  <th>Rate</th>
                  <th>Sub-Total</th>
                </tr>
              </thead>
                      
              <tbody>
                    @php
                        $total = 0;
                    @endphp
                    @if(count($order_detail) > 0)
                        @php
                            $slno = 1;
                        @endphp
                        @foreach($order_detail as $key => $item)
                        @php
                            $sub_total = $item->price * $item->quantity;
                            $total = $total + $sub_total;
                            // dd($item->stock->product->product_name);
                        @endphp
                        <tr>
                            <td>{{ $slno++ }}</td>
                            <td><a href="{{ route('admin.view_product', ['product_id' => encrypt($item->stock->product->id)]) }}" target="_blank">{{ $item->stock->product->product_name }}</a></td>
                            <td>{{ $item->stock->size }}</td>
                            <td>{{ $item->stock->color->color}}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₹ {{ number_format($item->price, 2) }}</td>
                            <td>₹ {{ number_format($sub_total, 2 )}}</td>
                        </tr>
                        @endforeach
                    @endif
                   <tr>
                        <td colspan="6" align="right">Total: </td>
                        <td>₹ {{ number_format($total, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="6" align="right">Net Payable Amount: </td>
                        <td>₹ {{ number_format($total, 2) }}</td>
                    </tr>                    
              </tbody>
            </table>
            <center>
                <a class="btn btn-warning" onclick="window.close();">Close</a>
            </center>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
