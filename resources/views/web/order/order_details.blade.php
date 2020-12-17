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
                            @if (isset($order_details) && !empty($order_details))
                                    @foreach ($order_details as $order)
                                        <div class="row">
                                        
                                            <div class="col-md-2 singleorderimg">
                                                <a href="{{ route('web.product.single-product', ['slug' => $order->product->slug, 'id' => $order->product->id]) }}"><img src="{{ asset('assets/product_images/thumb/'.$order->product_image.'') }}" alt=""></a>
                                            </div>
                                            <div class="col-md-10 singleordercontent"><a href="{{ route('web.product.single-product', ['slug' => $order->product->slug, 'id' => $order->product->id]) }}">{{ $order->product->name }}</a>
                                                <div class="cart-price" style="text-align: left;">
                                                    <div class="quantity">
                                                    <p><small>₹{{ number_format($order->mrp, 2) }}</small> ₹{{ number_format($order->price, 2) }} </p> <b>|</b>
                                                    <label style="margin-bottom: 0;">Quantity:</label>&nbsp;&nbsp;{{ $order->quantity }}
                                                </div>
                                                </div>
                                                <div class="varient">
                                                <b class="sub-tag spl">Size : {{ $order->stock->size }} </b>
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
                            @else
                                <div class="row">
                                    <div class="col-md-12">
                                        <span>No Orders Yet</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                      <a href="{{route('web.index')}}" class="button">GO TO HOME</a>
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