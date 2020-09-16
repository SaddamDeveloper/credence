@extends('admin.template.master')

@section('content')

<div class="right_col" role="main">

    <div class="row">
      <div class="col-md-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Product Details</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <section class="content invoice">
              <div class="row invoice-info">
                @if (!empty($product_record))                    
                <div class="col-sm-6 invoice-col">
                  <table class="table table-striped">
                    <caption>Product Deails</caption>
                    @if(!empty($product_record->sku_id))
                    <tr>
                      <th style="width:150px;">Product ID : </th>
                      <td>{{$product_record->sku_id}}</td>
                    </tr> 
                    @endif
                    <tr>
                      <th style="width:150px;">Product Type : </th>
                      <td>
                            @if($product_record->product_type == 1)
                                Cloth
                            @elseif($product_record->product_type == 2)
                                Cosmetic/Perfumes
                            @else
                                Other
                            @endif
                      </td>
                    </tr>
                    <tr>
                      <th style="width:150px;">Name : </th>
                      <td>{{$product_record->product_name}}</td>
                    </tr>
                    @if(!empty($product_record->third_level_sub_category_name))
                    <tr>
                      <th style="width:150px;">Third Level Sub-Category : </th>
                      <td>{{$product_record->third_level_sub_category_name}}</td>
                    </tr> 
                    @endif
                    @if(!empty($product_record->sub_cate_name))
                    <tr>
                      <th style="width:150px;">Sub-Category : </th>
                      <td>{{$product_record->sub_cate_name}}</td>
                    </tr> 
                    @endif
                    <tr>
                      <th style="width:150px;">Top-Category : </th>
                      <td>{{$product_record->top_cate_name}}</td>
                    </tr> 
                    @if(!empty($product_record->brand_name))
                    <tr>
                      <th style="width:150px;">Brand : </th>
                      <td>{{$product_record->brand_name}}</td>
                    </tr>
                    @endif
                    @if(!empty($product_record->price))
                    <tr>
                      <th style="width:150px;">Price : </th>
                      <td>₹{{number_format($product_record->price, 2) }}</td>
                    </tr>
                    @endif
                    @if(!empty($product_record->discount))
                    <tr>
                      <th style="width:150px;">MRP : </th>
                      <td>₹{{number_format($product_record->discount, 2)}}</td>
                    </tr>
                    @endif
                    <tr>
                      <th style="width:150px;">Description : </th>
                      <td>{!!$product_record->desc!!}</td>
                    </tr>
                    @if(!empty($product_record->stock))
                    <tr>
                      <th style="width:150px;">Stock : </th>
                      <td>{{$product_record->stock}}</td>
                    </tr>
                    @endif
                    <tr>
                      <th style="width:150px;">Status : </th>
                      <td>
                            @if($product_record->status == 1)
                                Active
                            @else
                                In-Active
                            @endif
                      </td>
                    </tr>
                  </table>
                </div>
                @endif

                <div class="col-sm-6 invoice-col">

                    @if(!empty($product_stock) && count($product_stock) > 0)
                    <table class="table table-striped">
                      <caption>Stock Deails</caption>
                        @foreach($product_stock as $key => $value)
                        <tr>
                            <td>{{ $value->size }}</td>
                            <td>{{ $value->stock }}</td>
                            @if(!empty($value->price))
                              <td>{{$value->price}}</td>
                            @endif
                            <td>{{$value->discount}}</td>
                        </tr>
                        @endforeach
                      </table>
                    @endif

                    @if(!empty($colors) && count($colors) > 0)
                    <table class="table table-striped">
                      <caption>Color Availablity</caption>
                        @foreach($colors as $key => $value)
                        <tr>
                            <td>{{ $value->color }}</td>
                            <td>{{ $value->color_code }}</td>
                        </tr>
                        @endforeach
                      </table>
                    @endif

                    <table class="table table-striped">
                      <caption>Product Image</caption>                     
                        <tr>
                          <td colspan="2">
                            <img src="{{ asset('assets/product_images/'.$product_record->banner) }}" style="max-width:400px;" >
                          </td>
                        </tr>                   
                    </table>
                </div>
              </div>
              <!-- /.row -->
              <hr>
           
              <div class="row">
                <button class="btn btn-warning" onclick="javascript:window.close()">Close</button>
              </div>
              <!-- /.row -->
            </section>
          </div>
        </div>
      </div>
    </div>

</div>
@endsection
