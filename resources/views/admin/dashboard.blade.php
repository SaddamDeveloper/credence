@extends('admin.template.master')

@section('content')

<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="row top_tiles">
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-user"></i></div>
                  <div class="count">{{ $total_user }}</div>
                  <h3>Total</h3>
                  <p><b>Users</b></p>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-comments-o"></i></div>
                  <div class="count">0</div>
                  <h3>Total</h3>
                  <p><b>Products</b></p>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-sort-amount-desc"></i></div>
                  <div class="count">{{ $total_brand }}</div>
                  <h3>Total</h3>
                  <p><b>Brands</b></p>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-shopping-cart"></i></div>
                  <div class="count">{{ $total_order }}</div>
                  <h3>Total</h3>
                  <p><b>Orders</b></p>
                </div>
              </div>
            </div>
            <p><h4>Latest 6 New Orders</h4></p>
            <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">Sl No. </th>
                            <th class="column-title">Order Id </th>
                            <th class="column-title">User Name </th>
                            <th class="column-title">Payment Id </th>
                            <th class="column-title">Payment Status </th>
                            <th class="column-title">Order Date </th>
                            <th class="column-title no-link last">
                              <span class="nobr">Action</span>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                         @if(!empty($latest_ten_order))
                              @php
                                   $sl_no = 1;
                              @endphp
                              @foreach($latest_ten_order as $key => $item)
                                   @php
                                        if($item->payment_status == 2)
                                             $payment_status = "Paid";
                                        else
                                             $payment_status = "Failed";
                                   @endphp
                          <tr class="odd pointer">
                            <td class=" ">{{ $sl_no++ }}</td>
                            <td class=" ">{{ $item->order_id }}</td>
                            <td class=" "><a href="{{ route('admin.users_profile', ['user_id' => encrypt($item->user_id)]) }}" title="Click Me" target="_blank">{{ $item->name }}</a></td>
                            <td class=" ">{{ $item->payment_id }}</td>
                            <td class=" ">{{ $payment_status }}</td>
                            <td class="a-right a-right ">{{ \Carbon\Carbon::parse($item->created_at)->toDayDateTimeString() }}</td>
                            <td class=" last"><a href="{{ route('admin.order_detail', ['order_id' => encrypt($item->id) ]) }}" target="_blank">View</a>
                            </td>
                          </tr>
                          @endforeach
                         @endif
                        </tbody>
                      </table>
                    </div>
          </div>
        </div>
        <!-- /page content -->

@endsection