@extends('admin.template.master')

@section('content')
<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit Product</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content"><br />
            @if(session()->has('msg'))
                <div class="alert alert-success">{{ session()->get('msg') }}</div>
            @endif
            <!-- Section For New User registration -->
            <form method="POST" autocomplete="off" action="{{ route('admin.update_product', ['product_id' => $product_record->id]) }}" class="form-horizontal form-label-left" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="well" style="overflow: auto">
                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="p_id">Product ID</label>
                            <input class="form-control" name="p_id" disabled value="{{ $product_record->sku_id }}">
                            <input class="form-control" type="hidden" name="sku_id" value="{{ $product_record->sku_id }}">
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="sub_cate_name">Product Type</label>
                            @if($product_record->product_type == 1)
                            <input type="text" class="form-control" value="Cloths" required disabled>
                            <input type="hidden" name="product_type" class="form-control" value="1" required>
                            @elseif($product_record->product_type == 2)
                            <input type="text" class="form-control" value="Cosmetic/Perfumes" required disabled>
                            <input type="hidden" name="product_type" class="form-control" value="2" required>
                            @else
                            <input type="text" class="form-control" value="Other" required disabled>
                            <input type="hidden" name="product_type" class="form-control" value="3" required>
                            @endif
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="top_cate_name">Top-Category</label>
                            <input class="form-control" value="{{ $top_category->top_cate_name }}" required readonly>
                        </div>

                         <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="sub_cate_name">Sub-Category</label>
                            <select name="sub_cate_name" id="sub_cate_name"  class="form-control col-md-7 col-xs-12">
                                <option value="" selected disabled>Choose Sub-Category</option>
                                @if(count($sub_category_list) > 0)
                                    @foreach($sub_category_list as $key => $value)
                                        @if($product_record->sub_category_id == $value->id)
                                            <option value="{{ $value->id }}"  selected>{{ $value->sub_cate_name }}</option>
                                        @else
                                            <option value="{{ $value->id }}">{{ $value->sub_cate_name }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            @error('sub_cate_name')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="third_level_sub_cate_name">Third Level Sub-Category</label>
                            <select name="third_level_sub_cate_name" id="third_level_sub_cate_name" class="form-control col-md-7 col-xs-12">
                                <option disabled selected>Choose Sub-Category</option>
                                @if(count($third_level_sub_category_list) > 0)
                                    @foreach($third_level_sub_category_list as $key => $value)
                                        @if($product_record->third_level_sub_category_id == $value->id)
                                            <option value="{{ $value->id }}"  selected>{{ $value->third_level_sub_category_name }}</option>
                                        @else
                                            <option value="{{ $value->id }}">{{ $value->third_level_sub_category_name }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            @error('third_level_sub_cate_name')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="brand">Brand</label>
                            <select name="brand" id="brand" class="form-control col-md-7 col-xs-12">
                                <option selected></option>
                                @if(count($brand_list) > 0)
                                    @foreach($brand_list as $key => $value)
                                        @if($product_record->brand_id == $value->id)
                                            <option value="{{ $value->id }}" selected>{{ $value->brand_name }}</option>
                                        @else
                                            <option value="{{ $value->id }}">{{ $value->brand_name }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            @error('brand')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="product_name">Product Name</label>
                            <input type="text" class="form-control" name="product_name" id="product_name" value="{{ $product_record->product_name }}" required>
                            @error('product_name')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" name="slug" id="slug" value="{{ $product_record->slug }}" required readonly>
                            @error('slug')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    @if(($product_record->product_type == 1) || ($product_record->product_type == 3))
                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="price">Price</label>
                            <input type="number" min="1" step="0.01" class="form-control" name="price" value="{{ $product_record->price }}">
                            </select>
                            @error('price')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="discount">MRP</label>
                            <input type="number" min="0" class="form-control" name="discount" value="{{ $product_record->discount }}">
                            @error('discount')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    @endif

                    @if($product_record->product_type == 1)
                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="stock_type">Size Chart (In Image)</label>
                            <input type="file" class="form-control" name="size_chart" id="input_size_chart">
                            @error('size_chart')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <img src="{{ asset('assets/product_size_chart/'.$product_record->size_chart.'') }}" width="80px" height="80px" id="img_size_chart">
                        </div>
                    </div>
                    @endif

                    @if($product_record->product_type == 3)
                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="stock">Stock</label>
                            <input type="number" min="0" class="form-control" name="stock" value="{{ $product_record->stock }}" id="input_stock">
                            </select>
                            @error('stock')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    @endif
                </div>

                @if(!empty($stocks) && ($product_record->product_type == 1))
                <div class="well" style="overflow: auto">
                    <div class="form-row mb-3">
                        @foreach ($stocks as $key => $item)
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-3 multple_stock_div">
                                <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                    <input type="hidden" value="{{ $item->id }}" name="stock_id[]" required >
                                    <input type="text" class="form-control"  placeholder="Enter size" name="size[]" value="{{ $item->size }}" required>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                    <input type="number" min="0" class="form-control" value="{{ $item->stock }}" placeholder="Enter stock" name="stock[]" required>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                @if ($item->status == 1)
                                    <a class="btn btn-success">Active</a>
                                    <a class="btn btn-danger" href="{{ route('admin.update_product_stock_status', ['stock_id' => $item->id, 'status' => 2]) }}">In-Active</a>
                                @else
                                    <a class="btn btn-danger">In-Active</a>
                                    <a class="btn btn-success" href="{{ route('admin.update_product_stock_status', ['stock_id' => $item->id, 'status' => 1]) }}">Active</a>
                                @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="well" style="overflow: auto;" id="whole_stock_div">
                    <div class="form-row mb-3">
                        <div class="col-md-12 col-sm-12 col-xs-12 mb-3" id="stock_div">
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-3"> 
                                <button type="button" class="btn btn-primary" onclick="addClothRow();">Add</button>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                <div class="col-md-4 col-sm-12 col-xs-12 mb-3"> 
                                    <label for="size">Size</label> 
                                    <input type="text" class="form-control" name="size[]">
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12 mb-3"> 
                                    <label for="stock">Stock</label> 
                                    <input type="number" min="0" class="form-control" name="stock[]" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(!empty($stocks) && ($product_record->product_type == 2))
                <div class="well" style="overflow: auto">
                    <div class="form-row mb-3">
                    @foreach ($stocks as $key => $item)
                        <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                            <div class="col-md-2 col-sm-12 col-xs-12 mb-3">
                                <label for="size">Size</label>
                                <input type="text" class="form-control" value="{{ $item->size }}" name="size[]">
                            </div>
                            <div class="col-md-2 col-sm-12 col-xs-12 mb-3">
                                <label for="stock">Stock</label>
                                <input type="hidden" value="{{ $item->id }}" name="stock_id[]" required >
                                <input type="number" min="0" class="form-control" value="{{ $item->stock }}" name="stock[]" required>
                            </div>
                            <div class="col-md-2 col-sm-12 col-xs-12 mb-3">
                                <label for="price">Price</label>
                                <input type="number" min="0" class="form-control" value="{{ $item->price }}" name="price[]" required>
                            </div>
                            <div class="col-md-2 col-sm-12 col-xs-12 mb-3">
                                <label for="discount">MRP</label>
                                <input type="number" class="form-control" value="{{ $item->discount }}" name="discount[]">
                            </div>
                            <div class="col-md-2 col-sm-12 col-xs-12 mb-3">
                                @if ($item->status == 1)
                                    <a class="btn btn-success btn-sm" style="margin-top: 25px;">Active</a>
                                    <a class="btn btn-danger btn-sm" href="{{ route('admin.update_product_stock_status', ['stock_id' => $item->id, 'status' => 2]) }}" style="margin-top: 25px;">In-Active</a>
                                @else
                                    <a class="btn btn-danger btn-sm" style="margin-top: 25px;">In-Active</a>
                                    <a class="btn btn-success btn-sm" href="{{ route('admin.update_product_stock_status', ['stock_id' => $item->id, 'status' => 1]) }}" style="margin-top: 25px;">Active</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>

                <div class="well" style="overflow: auto;" id="whole_stock_div">
                    <div class="form-row mb-3">
                        <div class="col-md-12 col-sm-12 col-xs-12 mb-3" id="stock_div">
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                <button type="button" class="btn btn-primary" onclick="addCosPerRow();">Add</button>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                <div class="col-md-2 col-sm-12 col-xs-12 mb-3">
                                    <label for="size">Size</label>
                                    <input type="text" class="form-control" name="size[]">
                                </div>
                                <div class="col-md-2 col-sm-12 col-xs-12 mb-3">
                                    <label for="stock">Stock</label>
                                    <input type="number" min="0" class="form-control" name="stock[]">
                                </div>
                                <div class="col-md-2 col-sm-12 col-xs-12 mb-3">
                                    <label for="price">Price</label>
                                    <input type="number" min="0" class="form-control" name="price[]">
                                </div>
                                <div class="col-md-2 col-sm-12 col-xs-12 mb-3">
                                    <label for="discount">MRP</label>
                                    <input type="number" class="form-control" name="discount[]" >
                                </div>
                                <div class="col-md-2 col-sm-12 col-xs-12 mb-3">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if (!empty($colors) && (count($colors) > 0))
                <div class="well" style="overflow: auto">
                    <div class="form-row mb-3">
                        <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                            @foreach ($colors as $key => $item)
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                        <input type="hidden" name="color_id[]" required value="{{ $item->id }}">
                                        <input type="text" class="form-control"  placeholder="Enter Color" name="color[]" value="{{ $item->color }}" required>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                        <input type="color" class="form-control"  placeholder="Enter Color Code" name="color_code[]" value="{{ $item->color_code }}" required>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                        @if ($item->status == 1)
                                            <a class="btn btn-success">Active</a>
                                            <a class="btn btn-danger" href="{{ route('admin.update_product_color_status', ['color_id' => $item->id, 'status' => 2]) }}">In-Active</a>
                                        @else
                                            <a class="btn btn-danger">In-Active</a>
                                            <a class="btn btn-success" href="{{ route('admin.update_product_color_status', ['color_id' => $item->id, 'status' => 1]) }}">Active</a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="well" style="overflow: auto;" id="whole_color_div">
                    <div class="form-row mb-3">
                        <div class="col-md-12 col-sm-12 col-xs-12 mb-3" id="color_div">
                            <button type="button" id="add_color_btn" class="btn btn-primary" >Add Color</button>
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-3"> 
                                <div class="col-md-4 col-sm-12 col-xs-12 mb-3"> 
                                    <input type="text" class="form-control" placeholder="Enter color" name="color[]" id="input_color"> 
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12 mb-3"> 
                                    <input type="color" class="form-control" placeholder="Enter color code" name="color_code[]" id="input_color_code"> 
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12 mb-3">  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="well" style="overflow: auto">
                    <div class="form-row mb-3">
                        <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                            <label for="desc">Description</label>
                            <textarea class="form-control ckeditor" name="desc" required>
                                {{ $product_record->desc }}
                            </textarea>
                            @error('desc')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="submit" name="submit" class="btn btn-success">Update</button>
                        <a onclick="javascript:window.close()" class="btn btn-warning">Close</a>
                    </div>
                </div>
            </form>
            <!-- End New User registration -->
            </div>
          </div>
        </div>
      </div>
</div>
@endsection

@section('script')
<script src="{{ asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
<script type="text/javascript">
$('.ckeditor').ckeditor();
color_cnt = 0;
cnt = 0;
$(document).ready(function(){
    $('#top_cate_name').change(function(){
        var category_id = $('#top_cate_name').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });

        $.ajax({
            method: "POST",
            url   : "{{ url('/admin/retrive-sub-category') }}",
            data  : {
                'category_id': category_id
            },
            success: function(response) {

                if (response == "<option value=\"\" disabled selected>Choose Sub-Category</option>") {
                    $("#sub_cate_name").prop('required', false);
                    $('#sub_cate_name').html(response);
                } else {
                    $("#sub_cate_name").prop('required', true);
                    $('#sub_cate_name').html(response);
                }
            }
        }); 
    });

    $('#sub_cate_name').change(function(){
        var category_id = $('#top_cate_name').val();
        var sub_category_id = $('#sub_cate_name').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });

        $.ajax({
            method: "POST",
            url   : "{{ url('/admin/retrive-third-level-sub-category') }}",
            data  : {
                'top_category_id': category_id,
                'sub_category_id': sub_category_id
            },
            success: function(response) {
                
                if (response == "<option value=\"\" disabled selected>Choose Sub-Category</option>") {
                    $("#third_level_sub_cate_name").prop('required', false);
                    $('#third_level_sub_cate_name').html(response);
                } else {
                    $("#third_level_sub_cate_name").prop('required', true);
                    $('#third_level_sub_cate_name').html(response);
                }
            }
        }); 
    });

    $("#product_name").keyup(function(){
        $("#slug").val($("#product_name").val().toLowerCase());
    });

    $("#add_color_btn").click(function(){

        color_cnt++;
        $("#color_div").append('<div class=\"col-md-12 col-sm-12 col-xs-12 mb-3\" id=\"color_row'+color_cnt+'\"> <div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\"> <input type=\"text\" class=\"form-control\" placeholder=\"Enter color\" name=\"color[]\" required> </div><div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\"> <input type=\"color\" class=\"form-control\" placeholder=\"Enter color code\" name=\"color_code[]\" required> </div><div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\"> <button type=\"button\" onclick=\"removeColorRow('+color_cnt+')\" class=\"btn btn-danger\">Remove</button> </div></div>');
    });
});

$('#input_size_chart').change(function(e){

    var url = URL.createObjectURL(e.target.files[0]);
    $('#img_size_chart').attr('src', url);
});

function addCosPerRow() {

    cnt++;
    $("#stock_div").append('<div class=\"col-md-12 col-sm-12 col-xs-12 mb-3\" id=\"stock_row'+cnt+'\"><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"><input type=\"text\" class=\"form-control\" name=\"size[]\" required></div><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"><input type=\"number\" min=\"0\" class=\"form-control\" name=\"stock[]\" required></div><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"><input type=\"number\" min=\"0\" class=\"form-control\" name=\"price[]\" required></div><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"><input type=\"number\" class=\"form-control\" name=\"discount[]\" required></div><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"><button type=\"button\" onclick=\"removeCosPerRow('+cnt+')\" class=\"btn btn-danger\">Remove</button></div></div>');
}

function addClothRow() {

    cnt++;
    $("#stock_div").append('<div class=\"col-md-12 col-sm-12 col-xs-12 mb-3\" id=\"stock_row'+cnt+'\"><div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\"> <input type=\"text\" class=\"form-control\" name=\"size[]\" required></div><div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\"> <input type=\"number\" min=\"0\" class=\"form-control\" name=\"stock[]\" required></div><div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\"> <button type=\"button\" onclick=\"removeClothRow('+cnt+')\" class=\"btn btn-danger\">Remove</button></div></div>');
}

function refresh() {
    location.reload();
}

function removeCosPerRow(counter){
    $('#stock_row'+counter).remove();
}

function removeClothRow(counter){
    $('#stock_row'+counter).remove();
}

function removeColorRow(color_counter){
    $('#color_row'+color_counter).remove();
}
</script>
@endsection