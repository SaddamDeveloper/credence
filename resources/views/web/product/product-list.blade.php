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
                        <input type="hidden" name="category_id" id="category_id" value="{{ $category_id }}">
                        <input type="hidden" name="type" id="type" value="{{ $type }}">
                      </span> 
                    </h2>
                  </div>
                  <div class="col-sm-5 text-right sort-by">
                    <label class="control-label" for="input-sort">Sort By:</label>
                    <select name="" id="sort">
                      <option selected disabled>Sort By</option>
                      <option value="1">Newest</option>
                      <option value="2">Price low to high</option>                      
                      <option value="3">Price high to low</option>
                    </select>
                  </div>
                </div>
              </div>
              <div id="pr">
                @include('web.include.products')
              </div>
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
                                <input type="hidden" name="top_category_id" id="top_category_id" value="{{ $item['top_category_id'] }}">
                                <input type="hidden" name="sub_category_id" id="sub_category_id" value="{{ $items->id }}">
                                <input type="hidden" name="last_category_id" id="last_category_id" value="{{ $itemss->id }}">
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
                        <input type="text" class="js-range-slider" name="my_range" value="" id="my_range" />
                    </div>
                  </div>
                </div>
              </div>
              {{-- Brand --}}

              @if (isset($brand) && !empty($brand))
                <div class="block product-price-range">
                    <div class="block-content">
                    <div>                    
                        <p class="block-subtitle">Brand</p>
                        <ul class="check-box-list">
                            @foreach ($brand as $item)
                              <li>
                                  <input type="checkbox" id="brand" name="brand" value="{{ $item->brand_name }}">
                                  <label for="p1"> 
                                    <span class="button"></span>{{ $item->brand_name }}
                                    <span class="count">
                                    </span>  
                                  </label>
                              </li>
                            @endforeach
                        </ul>                    
                    </div>
                    </div>
                </div>
              @endif
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
    @if(isset($price_range) && !empty($price_range) && !empty($price_range['min']) && !empty($price_range['max']))
    <script type="text/javascript">
        $(".js-range-slider").ionRangeSlider({
        min: '{{ $price_range['min'] }}',
        max: '{{ $price_range['max'] }}',
        type: 'double',
        prefix: "Rs ",
        prettify: false,
        hasGrid: false,
        onFinish: function (data) {
            var prices = data.from+";"+data.to;
            filterProduct(prices);
        },
        });
    </script>
    @else
    <script type="text/javascript">
        $(".js-range-slider").ionRangeSlider({
        min: 0,
        max: 1000,
        type: 'double',
        prefix: "Rs ",
        prettify: false,
        hasGrid: false,
        onFinish: function (data) {
            var prices = data.from+";"+data.to;
            filterProduct(prices);
        },
    });
    </script>
    @endif
    <!-- Custom Range Price slide JavaScript file-->
    <script type="text/javascript">
        function filterProduct(data){
            var price_range = data;
            var category_id = $("#category_id").val();
            var type = $("#type").val();
            var sort = $("#sort").val();
            var brand = new Array();
            $("input:checkbox[name=brand]:checked").each(function(){
                brand.push($(this).val());
            });

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
                url: "{{route('price_filter')}}",
                method: "POST",
                data: {category_id:category_id, type:type, sort:sort, brand:brand, price_range:price_range},
                success: function(data){
                    $("#pr").html(data);
                }
            });
        }
    $(function(){
      $('#sort').on('change', function() {
        filterProduct();
      });
    //   $('#brand').on('click', function(){
    //     filterProduct();
    //   });
    });

      
    // function get_filter(id_name) {
    //   var filter = [];
    //   $('#' + id_name + ':checked').each(function() {
    //       filter.push($(this).val());
    //   });
    //   return filter;
    // }
    // });

  </script>
  @endsection