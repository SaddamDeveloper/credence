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
                            @foreach ($orders as $order)
                              @foreach ($order->orderDetails as $od)
                                <div class="row">
                                    <div class="col-md-2 singleorderimg">
                                        <a href="#"><img src="{{ asset('assets/product_images/'.$od->product_image.'') }}" alt=""></a>
                                    </div>
                                    <div class="col-md-10 singleordercontent"><a href="#">{{ $od->stock->product->product_name }}</a>
                                        <div class="cart-price" style="text-align: left;">
                                            <div class="quantity">
                                              <p><small>₹{{ number_format($od->discount, 2) }}</small> ₹{{ number_format($od->price, 2) }} </p> <b>|</b>
                                              <label style="margin-bottom: 0;">Quantity:</label>&nbsp;&nbsp;{{ $od->quantity }}
                                          </div>
                                        </div>
                                        <div class="varient">
                                          <b class="sub-tag">Color : <span style="background:{{ $od->stock->color->color_code }}"></span></b>
                                          <b class="sub-tag spl">Size : {{ $od->stock->size }} </b>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style=""><hr style="margin: 0"></div>
                                    <div class="col-md-12 singleordercontent" style="padding: 10px 15px;">
                                        <div class="varient">
                                          <b class="sub-tag">Delivery Status : <strong>Delivered</strong> </b>
                                          <a href="#" class="editproduct oth" style="margin-left: 10px">Return</a>
                                        </div>
                                    </div>
                                </div>
                              @endforeach
                            @endforeach
                          @else
                              <div class="row">
                                <div class="col-md-12">
                                    <span>No Orders Yet</span>
                                </div>
                              </div>
                          @endif
                            {{-- <div class="row">
                                <div class="col-md-2 singleorderimg">
                                    <a href="#"><img src="web/images/products/img02.jpg" alt=""></a>
                                </div>
                                <div class="col-md-10 singleordercontent"><a href="#">Royal velvet</a>
                                    <div class="cart-price" style="text-align: left;">
                                        <div class="quantity">
                                          <p><small>₹1025</small> ₹1025 </p> <b>|</b>
                                          <label style="margin-bottom: 0;">Quantity:</label>&nbsp;&nbsp;2
                                        </div>
                                    </div>
                                    <div class="varient">
                                      <b class="sub-tag">Color : <span style="background: blue"></span></b>
                                      <b class="sub-tag spl">Size : L </b>
                                    </div>
                                </div>
                                <div class="col-md-12" style=""><hr style="margin: 0"></div>
                                <div class="col-md-12 singleordercontent" style="padding: 10px 15px;">
                                    <div class="varient">
                                      <b class="sub-tag">Delivery Status : <strong>Transit</strong> </b>
                                      <a href="#" class="editproduct oth" style="margin-left: 10px">Cancel</a>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
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