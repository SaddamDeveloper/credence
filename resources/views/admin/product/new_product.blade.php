@extends('admin.template.master')

@section('content')
<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>New Product</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content"><br />
            @if(session()->has('msg'))
                <div class="alert alert-success">{{ session()->get('msg') }}</div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger">{{ session()->get('error') }}</div>
            @endif
            <!-- Section For New User registration -->
            <form method="POST" autocomplete="off" action="{{ route('admin.add_product') }}" class="form-horizontal form-label-left" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="well" style="overflow: auto">
                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="product_type">Product Type</label>
                            <select name="product_type" id="product_type"  class="form-control col-md-7 col-xs-12" required>
                                <option disabled selected></option>
                                <option value="1">Cloths</option>
                                <option value="2">Cosmetic/Perfumes</option>
                                <option value="3">Other</option>
                            </select>
                            @error('top_cate_name')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="top_cate_name">Top-Category</label>
                            <select name="top_cate_name" id="top_cate_name"  class="form-control col-md-7 col-xs-12" required>
                                <option disabled selected>Choose Top-Category</option>
                                @if(count($top_category) > 0)
                                    @foreach($top_category as $key => $value)
                                        <option value="{{ $value->id }}">{{ $value->top_cate_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('top_cate_name')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="sub_cate_name">Sub-Category</label>
                            <select name="sub_cate_name" id="sub_cate_name" class="form-control col-md-7 col-xs-12">
                                <option value="" disabled selected>Choose Sub-Category</option>
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
                                <option value="" disabled selected>Choose Sub-Category</option>
                            </select>
                            @error('third_level_sub_cate_name')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="brand">Brand</label>
                            <select name="brand" id="brand" class="form-control col-md-7 col-xs-12">
                                <option value="" disabled selected>Choose Brand</option>
                            </select>
                            @error('brand')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="product_name">Product Name</label>
                            <input type="text" class="form-control" name="product_name" id="product_name" value="{{ old('product_name') }}" required>
                            </select>
                            @error('product_name')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" name="slug" id="slug" value="{{ old('slug') }}" readonly required>
                            </select>
                            @error('slug')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="form-row mb-3" id="single_price_div" style="display: none;">

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="price">Price</label>
                            <input type="number" min="1" step="0.01" class="form-control" name="price" value="{{ old('price') }}" id="input_price">
                            </select>
                            @error('price')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="discount">MRP</label>
                            <input type="number" min="0" class="form-control" name="discount" value="{{ old('discount') }}">
                            </select>
                            @error('discount')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="product_images">Product Images (Max 700 * Max 700)</label>
                            <input type="file" class="form-control" name="product_images[]" multiple required>
                            @error('product_images[]')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3" style="display: none;" id="size_chart">
                            <label for="size_chart">Size Chart (In Image)</label>
                            <input type="file" class="form-control" name="size_chart" id="input_size_cart">
                            @error('size_chart')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3" id="stock_single_div" style="display: none;">
                            <label for="stock">Stock</label>
                            <input type="number" min="0" class="form-control" name="stock" value="{{ old('stock') }}" id="input_stock">
                            </select>
                            @error('stock')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="well" style="overflow: auto; display: none;" id="whole_stock_div">
                    <div class="form-row mb-3">
                        <div class="col-md-12 col-sm-12 col-xs-12 mb-3" id="stock_div">
                            
                        </div>
                    </div>
                </div>

                <div class="well" style="overflow: auto; display: none;" id="whole_color_div">
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

                <div class="well" style="overflow: auto">
                    <div class="form-row mb-3">
                        <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                            <label for="desc">Description</label>
                            <textarea class="form-control form-text-element ckeditor" name="desc" required>
                                {{ old('desc') }}
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
                    <button type="submit" name="submit" class="btn btn-success form-text-element">Add Product</button>
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
$(document).ready(function(){
    $('#top_cate_name').change(function(){
        var top_category_id = $('#top_cate_name').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });

        $.ajax({
            method: "POST",
            url   : "{{ url('/admin/retrive-sub-category') }}",
            data  : {
                'category_id': top_category_id
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
        var top_category_id = $('#top_cate_name').val();
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
                'top_category_id': top_category_id,
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

        $.ajax({
            method: "POST",
            url   : "{{ url('/admin/retrive-brand') }}",
            data  : {
                'top_category_id': top_category_id,
                'sub_category_id': sub_category_id
            },
            success: function(response) {

                $('#brand').html(response);
            }
        }); 
    });

    $("#product_name").keyup(function(){
        $("#slug").val($("#product_name").val().toLowerCase());
    });

    $("#product_type").change(function(){
        var product_type = $("#product_type").val();

        color_cnt = 0;
        cnt = 0;

        if (product_type == 1) {

            $('#whole_stock_div').show();
            $('#whole_color_div').show();
            $('#single_price_div').show();
            $('#size_chart').show();
            $('#stock_single_div').hide();

            $("#input_price").prop('required', true);
            $("#input_stock").prop('required', false);
            $("#input_color").prop('required', true);
            $("#input_color_code").prop('required', true);
            $("#input_size_cart").prop('required', true);

            $("#stock_div").html('<div class=\"col-md-12 col-sm-12 col-xs-12 mb-3\"> <button type=\"button\" class=\"btn btn-primary\" onclick=\"addClothRow();\">Add</button></div><div class=\"col-md-12 col-sm-12 col-xs-12 mb-3\"><div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\"> <label for=\"size\">Size</label> <input type=\"text\" class=\"form-control\" name=\"size[]\" required></div><div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\"> <label for=\"stock\">Stock</label> <input type=\"number\" min=\"0\" class=\"form-control\" name=\"stock[]\" required></div></div><div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\"></div></div>');
        }
        else if(product_type == 2) {

            $('#whole_stock_div').show();
            $('#whole_color_div').hide();
            $('#single_price_div').hide();
            $('#size_chart').hide();

            $("#input_price").prop('required', false);
            $("#input_stock").prop('required', false);
            $("#input_color").prop('required', false);
            $("#input_color_code").prop('required', false);
            $("#input_size_cart").prop('required', false);

            $("#stock_div").html('<div class=\"col-md-12 col-sm-12 col-xs-12 mb-3\"><button type=\"button\" class=\"btn btn-primary\" onclick=\"addCosPerRow();\">Add</button></div><div class=\"col-md-12 col-sm-12 col-xs-12 mb-3\"><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"><label for=\"size\">Size</label><input type=\"text\" class=\"form-control\" name=\"size[]\" required></div><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"><label for=\"stock\">Stock</label><input type=\"number\" min=\"0\" class=\"form-control\" name=\"stock[]\" required></div><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"><label for=\"price\">Price</label><input type=\"number\" min=\"0\" class=\"form-control\" name=\"price[]\" required></div><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"><label for=\"discount\">Discount</label><input type=\"number\" class=\"form-control\" name=\"discount[]\" ></div><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"></div></div>');
        }
        else if(product_type == 3) {

            $('#whole_stock_div').hide();
            $('#whole_color_div').hide();
            $('#single_price_div').show();
            $('#size_chart').hide();
            $('#stock_single_div').show();

            $("#stock_div").html('');

            $("#input_price").prop('required', false);
            $("#input_stock").prop('required', true);
            $("#input_color").prop('required', false);
            $("#input_color_code").prop('required', false);
            $("#input_size_cart").prop('required', false);
        }
    });

    $("#add_color_btn").click(function(){

        color_cnt++;
        $("#color_div").append('<div class=\"col-md-12 col-sm-12 col-xs-12 mb-3\" id=\"color_row'+color_cnt+'\"> <div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\"> <input type=\"text\" class=\"form-control\" placeholder=\"Enter color\" name=\"color[]\" required> </div><div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\"> <input type=\"color\" class=\"form-control\" placeholder=\"Enter color code\" name=\"color_code[]\" required> </div><div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\"> <button type=\"button\" onclick=\"removeColorRow('+color_cnt+')\" class=\"btn btn-danger\">Remove</button> </div></div>');
    });
});

function addClothRow() {

    cnt++;
    $("#stock_div").append('<div class=\"col-md-12 col-sm-12 col-xs-12 mb-3\" id=\"stock_row'+cnt+'\"><div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\"> <input type=\"text\" class=\"form-control\" name=\"size[]\" required></div><div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\"> <input type=\"number\" min=\"0\" class=\"form-control\" name=\"stock[]\" required></div><div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\"> <button type=\"button\" onclick=\"removeClothRow('+cnt+')\" class=\"btn btn-danger\">Remove</button></div></div>');
}

function addCosPerRow() {

    cnt++;
    $("#stock_div").append('<div class=\"col-md-12 col-sm-12 col-xs-12 mb-3\" id=\"stock_row'+cnt+'\"><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"><input type=\"text\" class=\"form-control\" name=\"size[]\" required></div><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"><input type=\"number\" min=\"0\" class=\"form-control\" name=\"stock[]\" required></div><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"><input type=\"number\" min=\"0\" class=\"form-control\" name=\"price[]\" required></div><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"><input type=\"number\" class=\"form-control\" name=\"discount[]\" required></div><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"><button type=\"button\" onclick=\"removeCosPerRow('+cnt+')\" class=\"btn btn-danger\">Remove</button></div></div>');
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