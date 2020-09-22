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
                        @if (!empty($item->price))
                        <span class="old-price"> ₹{{ number_format($item->discount, 2) }}</span>
                        <span class="special-price">₹{{ number_format($item->price, 2) }}</span>
                        @else
                          <span class="special-price">₹{{ number_format($item->price, 2) }}</span>
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