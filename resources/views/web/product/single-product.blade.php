@extends('web.templet.master')

  {{-- @include('web.include.seo') --}}

  @section('seo')
    <meta name="description" content="Credence">
  @endsection

  @section('content')
    <!-- Main Container -->
    <section class="main-container col1-layout">
      <div class="main">
        <div class="container">
          <div class="row">
            <div class="col-main">
              <div class="product-view">
                <div class="product-essential">
                    <div class="product-img-box col-lg-5 col-sm-6 col-xs-12">
                      <div class="new-label new-top-left"> New </div>
                      <div class="product-image">
                        <div class="product-full"> 
							<img id="product-zoom" src="{{ asset('assets/product_images/'.$product_detail->banner.'') }}" data-zoom-image="{{ asset('assets/product_images/'.$product_detail->banner.'') }}" alt="product-image"/> 
						</div>
                        <div class="more-views">
                          <div class="slider-items-products">
                            <div id="gallery_01" class="product-flexslider hidden-buttons product-img-thumb">
                              <div class="slider-items slider-width-col4 block-content">
                                @foreach ($product_detail->productAdditionalImages as $key => $item)
								<div class="more-views-items"> 
									<a href="#" data-image="{{ asset('assets/product_images/'.$item->additional_image.'') }}" data-zoom-image="{{ asset('assets/product_images/'.$item->additional_image.'') }}"> 
									<img id="product-zoom"  src="{{ asset('assets/product_images/'.$item->additional_image.'') }}" alt="product-image"/> 
									</a>
								</div>
                                @endforeach
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- end: more-images --> 
                    </div>
                    <div class="product-shop col-lg-7 col-sm-6 col-xs-12">
                      <div class="product-name">
                        <h1>{{ $product_detail->product_name }}</h1>
                      </div>
                        @php
                            $min_size = $product_detail->minSize;
                            $min_size = $min_size[0];
                            // dd($min_size);
                        @endphp
                      <div class="price-block">
                        <div class="price-box">
                            <p class="old-price"> <span class="price-label">Special Price</span> <span id="product-price-48" class="price"> ₹{{ number_format($min_size->discount, 2) }} </span> </p>&nbsp;

                            <p class="special-price"> <span class="price-label">Regular Price:</span> <span class="price"> ₹{{ number_format($min_size->price, 2) }} </span> </p>
                        </div>
                      </div>
                      <div class="info-orther">
                        <p>Item Code: #{{ $product_detail->sku_id }}</p>
                      
                        <p>Availability: <span class="in-stock">
                           @if(isset($min_size->stock) && ($min_size->stock > 0))
                                In Stock
                            @else
                                Out of Stock
                            @endif
                        </span></p>
                      </div>
                      {{-- <div class="short-description">
                        <h2>Quick Overview</h2>
                        <p>{{ $product_detail->desc }}</p>
                      </div> --}}
                      <div class="form-option">
                        <p class="form-option-title">Available Options:</p>

                        <form action="{{ route('web.add_cart') }}" method="POST" autocomplete="off" id="product">
                        @csrf
						    @if (!empty($product_detail->productColorMapping) && (count($product_detail->productColorMapping) > 0))
                            <div class="attributes">
                            <div class="attribute-label">Color:</div>
                            <div class="attribute-list">
                                <ul class="list-color" id="list-color">
                                @foreach ($product_detail->productColorMapping as $key => $item)
                                    @if($key == 0)
                                    <li class="col-sel color-sel selected">
                                        <span style="background:{{ $item->color_code }};"></span>
                                        <input type="radio" name="product_color_id" value="{{ $item->id }}" checked="" hidden="">
                                    </li>
                                    @else
                                    <li class="col-sel color-sel">
                                        <span style="background:{{ $item->color_code }};"></span>
                                        <input type="radio" name="product_color_id" value="{{ $item->id }}" hidden="">
                                    </li>
                                    @endif
                                @endforeach
                                </ul>
                            </div>
                            </div>  
                        @endif
                        @if (!empty($product_detail->productStock) && (count($product_detail->productStock) > 0))
                            <div class="attributes">
                                <div class="attribute-label">Size:</div>
                                <div class="attribute-list">
                                    <ul class="list-size" id="list-size">
                                    @foreach ($product_detail->productStock as $key => $item)
                                        @if ($key == 0)
                                            <li class="col-sel size-sel selected">
                                            <span>{{ $item->size }}</span>
                                            <input type="radio" name="product_size_id" value="{{ $item->id }}" checked="" hidden="">
                                            </li>
                                        @else 
                                            <li class="col-sel size-sel">
                                            <span>{{ $item->size }}</span>
                                            <input type="radio" name="product_size_id" value="{{ $item->id }}" hidden="">
                                            </li>
                                        @endif
                                    @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                        @if (session()->has('msg'))
                            <span style="color: red;">{{session()->get('msg')}}</span>
                        @endif
                        
                          
                        <div class="product-color-size-area">
                          <h2 class="saider-bar-title">Delivery Availability</h2>
                          <div id="pincode">
                            <div class="input-group flex">
                                @if (Session::has('pincode') && !empty(Session::get('pincode')))
                                  @php
                                    $pincode = Session::get('pincode');
                                  @endphp
                                  <input type="number" class="form-control" placeholder="Enter Pincode" value="{{ $pincode }}"id="pin">
                                @else
                                  <input type="number" class="form-control" placeholder="Enter Pincode" id="pin">
                                @endif
                              <button class="btn-search" type="button" onclick="checkDelivery()">Check</button>
                            </div>
                            {{-- Start --}}
                            <div class="delivery-info" id="delivery_info">
                              <p style="margin-top: 7px;">&nbsp;<span style="color: red">*</span>Please check the availablity of product on your pincode </p>
                            </div> 
                            {{-- if --}}
                            <div class="delivery-infos">
                              {{-- <p style="margin-top: 7px;color:#ff0000c7;font-weight:bold">&nbsp;Sorry Delivery Option Is Not Available In This Pin Code</p> --}}
                            </div>
                            {{-- else --}}
                            
                          </div>
                        </div>
                        <div class="add-to-box">
                          <div class="add-to-cart" >
                            <div class="pull-left">
                              <div class="custom pull-left">
                                <label>Qty :</label>
                                <button onClick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 1 ) result.value--;return false;" class="reduced items-count" type="button"><i class="fa fa-minus">&nbsp;</i></button>
                                <input type="number" class="input-text qty" title="Qty" value="1" maxlength="12" id="qty" min="1" name="qty">
                                <button onClick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty )) result.value++;return false;" class="increase items-count" type="button"><i class="fa fa-plus">&nbsp;</i></button>
                              </div>
                            </div>
                            @if(isset($min_size->stock) && !empty($min_size->stock))
                                <input type="hidden" value="{{ $product_detail->id }}" name="product_id">
                                <button class="button btn-cart" title="Add to Cart" type="submit">Add to Cart</button>
                            @else
                              <button class="button btn-cart" title="Out of Stock" type="button" disabled>Out of Stock</button>
                            @endif
                          </div>
                          <div class="email-addto-box">
                            <ul class="add-to-links">
                              <li> <a class="link-wishlist" href="{{ route('web.add_wish_list', ['product_id' => encrypt($product_detail->id)]) }}"><span>Add to Wishlist</span></a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="product-collateral col-lg-12 col-sm-12 col-xs-12">
              <div class="block-title">
                <h2>Product Detail</h2>
              </div>
              <div class="add_info">
                <div id="productTabContent" class="tab-content">
                  <div class="tab-pane fade in active" id="product_tabs_description">
                    <div class="std">
                      <p>{!! $product_detail->desc !!}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Main Container End --> 

    @if (!empty($related_product) && (count($related_product) > 0))
    <!-- Related Products Slider -->  
    <div class="container">
      <div class="upsell-section">
        <div class="slider-items-products">
          <div class="upsell-block">
            <div class="jtv-block-inner">
              <div class="block-title">
                <h2>Lastest Arrival</h2>
              </div>
            </div>
            <div id="" class="upsell-products-slider product-flexslider hidden-buttons">
              <div class="slider-items slider-width-col4 products-grid block-content">
                @foreach ($related_product as $key => $item)
                <div class="item">
                  <div class="item-inner">
                    <div class="item-img">
                      <div class="item-img-info"> <a href="{{ route('web.product_detail', ['slug' => $item->slug, 'product_id' => $item->id]) }}" class="product-image" title="{{ $item->product_name }}"> <img alt="{{ $item->product_name }}" src="{{ asset('assets/product_images/'.$item->banner.'') }}"> </a>
                      </div>
                    </div>
                    <div class="item-info">
                      <div class="info-inner">
                        <div class="item-title"> <a title="{{ $item->product_name }}" href="{{ route('web.product_detail', ['slug' => $item->slug, 'product_id' => $item->id]) }}"> {{ $item->product_name }} </a> </div>
                        <div class="item-content">
                          <div class="item-price">
                            <div class="price-box"> 
                              <span class="regular-price"> 
                                <span class="price">
                                  @if (!empty($item->price))
                                    <span class="old-price"> ₹{{ number_format($item->discount, 2) }}</span>
                                    <span class="special-price">₹{{ number_format($item->price, 2) }}</span>
                                  @else
                                    ₹{{ $item->price }}
                                  @endif
                                </span> 
                              </span> 
                            </div>
                          </div>
                          <div class="action">
                            <a class="link-wishlist" href="{{ route('web.add_wish_list', ['product_id' => encrypt($item->id)]) }}"><i class="icon-heart icons"></i><span class="hidden">Wishlist</span></a>
                              <a class="button btn-cart" type="button" title="" data-original-title="Add to Cart" href="{{ route('web.product_detail', ['slug' => $item->slug, 'product_id' => $item->id]) }}"><span>View Detail</span> </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Related Products Slider End --> 
    @endif
  
  @endsection

  @section('script') 
    <!--cloud-zoom js --> 
    <script type="text/javascript" src="{{asset('web/js/cloud-zoom.js')}}"></script>

    <script>
      $(document).on('click','#list-color li',function(){
          $(this).addClass('selected').siblings().removeClass('selected')
      });

      $('.color-sel').click(function() {
        $('.color-sel').removeClass('selected');
        $(this).addClass('selected').find('input').prop('checked', true)    
      });
    </script>

    <script>
      $(document).on('click','#list-size li',function(){
          $(this).addClass('selected').siblings().removeClass('selected')
      });

      $('.size-sel').click(function() {
        $('.size-sel').removeClass('selected');
        $(this).addClass('selected').find('input').prop('checked', true);

        var product_size_id = $("input[name='product_size_id']:checked").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });

        $.ajax({
            method: "POST",
            url   : "{{ url('product-price-check') }}",
            data  : {
                'stock_id': product_size_id
            },
            success: function(response) {

                var response = response.split(',');
                var price = response[0];
                var discount = response[1];

                if (price != "") {

                    if (discount != 0) {

                        $('.price-box').html('<p class=\"old-price\"><span class=\"price-label\">Special Price</span><span id=\"product-price-48\" class=\"price\">₹'+parseFloat(price).toFixed(2)+'</span></p>&nbsp;<p class=\"special-price\"><span class=\"price-label\">Regular Price:</span><span class=\"price\"> ₹'+parseFloat(discount).toFixed(2)+' </span> </p>');
                    } else {

                        $('.price-box').html('<p class=\"special-price\"> <span class=\"price-label\">Special Price</span> <span id=\"product-price-48\" class=\"price\"> ₹'+parseFloat(price).toFixed(2)+' </span> </p>');
                    }
                }
            }
        });

      });

      function checkDelivery(){
        var pincode = $("#pin").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });
        $.ajax({
            method: "POST",
            url   : "{{ route('web.pincode_check') }}",
            data  : {
                'pincode': pincode
            },
            success: function(response) {
              if(response == 1){
                $('.delivery-infos').html('<p style="margin-top: 7px;color: #0aa90fc7;font-weight:bold">&nbsp;Delivery available in this pincode </p>');
              }else if(response == 0){
                $('.delivery-infos').html('<p style="margin-top: 7px;color:#ff0000c7;font-weight:bold">&nbsp;Sorry Delivery Option Is Not Available In This Pin Code</p>');
              }
            }
        });

      }
    </script>
  @endsection
