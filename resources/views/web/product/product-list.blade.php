@extends('web.templet.master')

  {{-- @include('web.include.seo') --}}

  @section('seo')
    <link rel="stylesheet" href="{{asset('web/css/ion.rangeSlider.min.css')}}"/>  
  @endsection

  @section('content')
    <style>.list-group {margin-bottom: 0}</style>
    <!-- JTV Home Slider -->
    <section class="main-container col2-left-layout">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-9 col-sm-push-3">
            <article class="col-main" style="width: 100%;">              
              <div class="toolbar toolbar-top" style="padding-bottom: 0.8%;border-bottom: 1px solid #ddd">
                <div class="row">
                  <div class="col-md-7 col-sm-5">
                    <h2 class="page-heading"> 
                      <span class="page-heading-title">
                        {{ $label }}
                      </span> 
                    </h2>
                  </div>
                  <div class="col-sm-5 text-right sort-by">
                    <label class="control-label" for="input-sort">Sort By:</label>
                    <select name="" onchange="javascript:location.href = this.value;">
                      <option selected disabled>Sort By</option>
                      <option value="1">Newest</option>
                      <option value="2">Price low to high</option>                      
                      <option value="3">Price high to low</option>
                    </select>
                  </div>
                </div>
              </div>
              @if(!empty($products) && (count($products) > 0))
              <div id="product_container">
                <div class="category-products">
                  <ul class="products-grid row">
                    @foreach($products as $key => $item) 
                    <li class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
                      <div class="item">
                        <div class="item-inner">
                          <div class="item-img">
                            <div class="item-img-info"> <a class="product-image" title="{{ $item->product_name }}" href="{{ route('web.product_detail', ['slug' => $item->slug, 'product_id' => $item->id]) }}"> <img alt="{{ $item->product_name }}" src="{{ asset('assets/product_images/'.$item->banner.'') }}"> </a>
                            </div>
                          </div>
                          <div class="item-info">
                            <div class="info-inner">
                              <div class="item-title"> <a title="{{ $item->product_name }}" href="{{ route('web.product_detail', ['slug' => $item->slug, 'product_id' => $item->id]) }}"> {{ $item->product_name }} </a> </div>
                              <div class="item-content">
                                <div class="item-price">
                                  <div class="price-box"> <span class="regular-price"> 
                                    <span class="price">
                                      @if (!empty($item->discount))
                                        @php
                                          $discount_amount = ($item->price * $item->discount) / 100;
                                          $amount = ($item->price - $discount_amount);
                                        @endphp
                                       <span class="old-price"> ₹{{ $item->price }}</span>
                                       <span class="special-price">₹{{ $amount }}</span>
                                      @else
                                        <span class="special-price">₹{{ $item->price }}</span>
                                      @endif
                                    </span> </span> </div>
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
                    </li>
                    @endforeach
                  </ul>
                </div>
                <div class="toolbar">
                  <div class="row">
                    <div class="col-sm-6 text-left">
                      <ul class="pagination">
                        {{ $products->links() }}
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              @else
                  <div style="background: #ffffff05; text-align: center;">
                    <img src="{{asset('web/images/not-found.jpg')}}" style="max-width: 100%"> <br>
                      <h4><strong>Sorry !!</strong> No Product Available...</h4>
                      <div class="action"><a href="{{ route('web.index') }}" type="button" class="button btn-cart"><span>Continue Shopping</span></a></div>
                  </div>    
                @endif
            </article>
            <!--  ///*///======    End article  ========= //*/// --> 
          </div>
          <div class="sidebar col-sm-3 col-xs-12 col-sm-pull-9">
            <aside class="sidebar">
              <div class="block-title">Shop By Catagories</div>
              <div class="block block-layered-nav">
                <div class="block-content" id="sidebar">
                    <p class="block-subtitle">Shopping Options</p> 
                    <ul class="cd-accordion-menu animated">
                    @if(!empty($categories) && (count($categories) > 0))

                      @foreach($categories as $key => $item) 

                        @if(!empty($item['sub_categories']) && (count($item['sub_categories']) > 0))
                      <!-- For 3 Level Catagory -->
                      <li class="has-children">
                        <input type="checkbox" name="group-{{ $key }}" id="group-{{ $key }}">
                        <label for="group-{{ $key }}">{{ $item['top_cate_name'] }}</label>
                        <ul>
                            @foreach($item['sub_categories'] as $keys => $items) 
                            @if (!empty($items->last_category) && (count($items->last_category) > 0))
                          <li class="has-children">
                            <input type="checkbox" name="sub-group-{{ $keys }}" id="sub-group-{{ $keys }}">
                            <label for="sub-group-{{ $keys }}">{{ $items->sub_cate_name }}</label>
                            <ul>
                                @foreach($items->last_category as $keyss => $itemss)
                              <li><a href="{{ route('web.product_list', ['slug' => $itemss->third_level_sub_category_name, 'top_category_id' => $item['top_category_id'], 'sub_category_id' => $items->id, 'last_category_id' => $itemss->id, 'sorted_by' => 0]) }}">{{ $itemss->third_level_sub_category_name }}</a></li>
                              @endforeach
                            </ul>
                          </li>
                          @else
                            <li><a href="{{ route('web.product_list', ['slug' => $items->sub_cate_name, 'top_category_id' => $item['top_category_id'], 'sub_category_id' => $items->id, 'last_category_id' => 0, 'sorted_by' => 0]) }}">{{ $items->sub_cate_name }}</a></li>
                            @endif
                            @endforeach
                        </ul>
                      </li>

                      <!-- For 2 Level Catagory -->
                   <!--    <li class="has-children">
                        <input type="checkbox" name="group-4" id="group-4">
                        <label for="group-4">COSMETICS</label>
                        <ul>
                          <li><a href="#0">Men</a></li>
                          <li><a href="#0">Women</a></li>
                        </ul>
                      </li> -->
                      @else
                      <!-- For Single Level Catagory -->
                      <li><a href="{{ route('web.product_list', ['slug' => $item['top_cate_name'], 'top_category_id' => $item['top_category_id'], 'sub_category_id' => 0, 'last_category_id' => 0, 'sorted_by' => 0]) }}">{{ $item['top_cate_name'] }}</a></li>
                      @endif
                       @endforeach
                    @endif
                    </ul>
                </div>
              </div> 

              <div class="block product-price-range ">
                <div class="block-content">
                  <p class="block-subtitle">Price</p>
                  <div class="slider-range">
                    <div class="demo__body">
                        <input type="text" class="js-range-slider" name="my_range" value="" />
                    </div>
                  </div>
                </div>
              </div>

              <div class="block product-price-range">
                <div class="block-content">
                  <div>                    
                    <p class="block-subtitle">Brand</p>
                    <ul class="check-box-list">
                      <li>
                        <input type="checkbox" id="p1" name="cc">
                        <label for="p1"> <span class="button"></span>Brand 1<span class="count">(5)</span> </label>
                      </li>
                      <li>
                        <input type="checkbox" id="p2" name="cc">
                        <label for="p2"> <span class="button"></span>Brand 3<span class="count">(10)</span> </label>
                      </li>
                      <li>
                        <input type="checkbox" id="p3" name="cc">
                        <label for="p3"> <span class="button"></span>Brand 2<span class="count">(12)</span> </label>
                      </li>
                      <li>
                        <input type="checkbox" id="p4" name="cc">
                        <label for="p4"> <span class="button"></span>Brand 3<span class="count">(10)</span> </label>
                      </li>
                      <li>
                        <input type="checkbox" id="p5" name="cc">
                        <label for="p5"> <span class="button"></span>Brand 2<span class="count">(12)</span> </label>
                      </li>
                    </ul>                    
                  </div>
                </div>
              </div>
            </aside>
          </div>
        </div>
      </div>
    </section>
        
  @endsection

  @section('script')  
    <!--jQuery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>    
    <!--Plugin JavaScript file-->
    <script src="{{asset('web/js/ion.rangeSlider.js')}}"></script>

    <!-- Custom Range Price slide JavaScript file-->
    <script type="text/javascript">
      $(".js-range-slider").ionRangeSlider({
        type: "double",
        min: 400,
        max: 2000,
        from: 500,
        to: 1000,
        grid: false
    });
  </script>
  @endsection