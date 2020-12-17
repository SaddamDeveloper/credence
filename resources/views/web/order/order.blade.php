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
                                  <th class="text-center">Order Date</th>
                                  <th class="text-center">Order Status</th>
                                  <th class="text-center">Action</th>
                              </tr>
                              </thead>
                              <tbody>
                                  @foreach ($orders as $order)
                                      <tr>
                                          <td>{{ $order->id }}</td>
                                          <td>{{ $order->created_at }}</td>
                                          <td>Delivered</td>
                                          <td><a class="btn btn-primary" href="{{ route('web.order.order_details', ['id' =>$order->id]) }}">View details</a></td>
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