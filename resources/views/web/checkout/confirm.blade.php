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
          <div class="col-sm-9">
            <article class="col-main" style="width: 100%;">              
              <div class="ordernav" style="padding-bottom: 0.8%;">
                  <ul>
                    <li style="border-color: #323d61"><div>Cart information</div></li>
                    <li style="border-color: #323d61"><div>shipping information</div></li>
                    <li class="step"><div>Order confirmation</div></li>
                  </ul>
              </div>
              <div class="container-fluid">
                  <div class="row">
                    <!-- <div class="col-md-1"></div> -->
                    <div class="col-md-12">
                      <div class="orderconfim">
                        <svg class="checkmark1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>                           
                      </div>
                      <div class="col-md-7"> 
                        <label style="font-weight: 700">Order Detail</label>                       
                        <div class="row singleorder">
                            @if (isset($orders) && !empty($orders))
                                @foreach ($orders->orderDetails as $od)
                                    <div class="row">
                                        <div class="col-md-2 singleorderimg">
                                            <a href="{{ route('web.product_detail', ['slug' => $od->stock->product->slug, 'product_id' => $od->stock->product->id]) }}"><img src="{{ asset('assets/product_images/'.$od->product_image.'') }}" alt=""></a>
                                        </div>
                                        <div class="col-md-10 singleordercontent" style="padding-top: 10px;">
                                        <a href="{{ route('web.product_detail', ['slug' => $od->stock->product->slug, 'product_id' => $od->stock->product->id]) }}">{{ $od->stock->product->product_name }}</a>
                                        <div class="cart-price" style="text-align: left;">
                                            <div class="quantity">
                                                <p><small>₹{{ number_format($od->discount, 2) }}</small> ₹{{ number_format($od->price, 2) }} </p> <b>|</b> 
                                                <label class="" style="margin-bottom: 0;">Quantity:</label>&nbsp;&nbsp;{{ $od->quantity }}
                                            </div>                                      
                                        </div>
                                        <div class="varient">
                                            <b class="sub-tag">Color : <span style="background:{{ $od->stock->color->color_code }}"></span></b>
                                            <b class="sub-tag spl">Size : {{ $od->stock->size }} </b>
                                        </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                      </div>
                      <div class="col-md-5"> 
                        <label style="font-weight: 700">Shipping</label>
                        <div class="single-address orderconfim">
                          <div class="single-address-content">
                            <p>Name: {{ $address->name }}</p>
                            <p>Address: {{ $address->address }} </p>
                            <p>Email: {{ $address->email }} </p>
                            <p>Mobile No: {{ $address->mobile_no }} </p>
                            <p>City: {{ $address->city }} </p>
                            <p>Pincode: {{ $address->pin_code }}</p>
                            <p></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                    <div class="col-md-12" style="display:flex;justify-content: center;margin-top: 30px">
                      <a href="{{route('web.index')}}" class="button button--aylen btn">Continue Shopping</a>
                    </div>
              </div>
            </article>
            <!--  ///*///======    End article  ========= //*/// --> 
          </div>
          {{-- <div class="sidebar col-sm-3 col-xs-12">
            <aside class="sidebar">
              <div class="block-title" style="border-bottom: 0">PAYMENT INFORMATION</div>
              <div class="cartcalculation">
                <div class="paymttotal">
                  <h4 style="text-align: left;">Cart Amount  </h4>
                  <h4 style="text-align: right;" id="total">{{ Cart::subtotal() }}</h4>
                </div>
                <div class="paymttotal">
                  <h4 style="text-align: left;">Shipping  </h4>
                  <h4 style="text-align: right;" id="total">30</h4>
                </div>
                <div class="paymttotal">
                  <h4 style="text-align: left;font-weight: 700;border-bottom:0;">Grand Total </h4>
                  <h4 style="text-align: right;font-weight: 700;border-bottom:0;" id="total">{{ Cart::subtotal() }}</h4>
                </div>
              </div>
            </aside>
          </div> --}}
        </div>
      </div>
    </section>
       
  @endsection

  @section('script')
  @endsection