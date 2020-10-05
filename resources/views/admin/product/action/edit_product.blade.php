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
                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="top_cate_name">Top-Category</label>
                            <input class="form-control" value="{{ $top_category->top_cate_name }}" required readonly>
                            <input type="hidden" name="top_cate_name" value="{{ $top_category->top_cate_name}}">
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
                                <option value="" selected disabled></option>
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

                    {{-- Price & Discount & Stock--}}
                </div>
                @if(isset($stocks) && !empty($stocks))
                <div class="well" style="overflow: auto">
                    <div class="form-row mb-3">
                        @foreach ($stocks as $key => $item)
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-3 multple_stock_div">
                                <div class="col-md-2 col-sm-12 col-xs-12 mb-3">
                                    <label for="size">Size Name</label>
                                    <input type="hidden" value="{{ $item->id }}" name="stock_id[]" required >
                                    <input type="text" class="form-control"  placeholder="Enter size" name="size[]" value="{{ $item->size }}">
                                </div>
                                <div class="col-md-2 col-sm-12 col-xs-12 mb-3">
                                    <label for="stock">Stock</label>
                                    <input type="number" min="0" class="form-control" value="{{ $item->stock }}" placeholder="Enter stock" name="stock[]">
                                </div>
                                <div class="col-md-2 col-sm-12 col-xs-12 mb-3">
                                    <label for="price">Price</label>
                                    <input type="number" min="1" step="0.01" class="form-control" name="price" value="{{ $product_record->price }}">
                                </div>
                                <div class = "col-md-2 col-sm-12 col-xs-12 mb-3">
                                    <label for="mrp">MRP</label>
                                    <input type="number" min="0" class="form-control" name="discount" value="{{ $product_record->discount }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="well" style="overflow: auto;" id="whole_stock_div">
                    <div class="form-row mb-3">
                        <div class="col-md-12 col-sm-12 col-xs-12 mb-3" id="stock_div">
                            <div class="col-md-10 col-sm-12 col-xs-12 mb-3 input_fields_wrap">
                                <div class="col-md-2 col-sm-12 col-xs-12 mb-3"> 
                                    <input type="text" class="form-control" name="size[]" placeholder="Size">
                                </div>
                                <div class="col-md-2 col-sm-12 col-xs-12 mb-3"> 
                                    <input type="number" min="0" class="form-control" placeholder="Stock" name="stock[]">
                                </div>
                                <div class="col-md-2 col-sm-12 col-xs-12 mb-3">
                                    <input type="number" class="form-control" placeholder="Price" name="price[]">
                                </div>
                                <div class="col-md-2 col-sm-12 col-xs-12 mb-3">
                                    <input type="number" class="form-control" name="discount[]" placeholder="MRP">
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                    <button type="button" class="btn btn-primary" id="add_stock_btn">Add</button>
                                </div>
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
                                        <input type="hidden" name="color_id[]" value="{{ $item->id }}">
                                        <input type="text" class="form-control"  placeholder="Enter Color" name="color[]" value="{{ $item->color }}">
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                        <input type="color" class="form-control"  placeholder="Enter Color Code" name="color_code[]" value="{{ $item->color_code }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="well" style="overflow: auto;" id="whole_color_div">
                    <div class="form-row mb-3">
                        <div class="col-md-12 col-sm-12 col-xs-12 mb-3" id="color_div">
                            
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-3"> 
                                <div class="col-md-4 col-sm-12 col-xs-12 mb-3"> 
                                    <input type="text" class="form-control" placeholder="Enter color" name="color[]" id="input_color"> 
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12 mb-3"> 
                                    <input type="color" class="form-control" placeholder="Enter color code" name="color_code[]" id="input_color_code"> 
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12 mb-3">  
                                    <button type="button" id="add_color_btn" class="btn btn-primary" >Add Color</button>
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

    var max_fields_color      = 10; //maximum input boxes allowed
    var wrapper_color   		= $("#color_div"); //Fields wrapper
    var add_color_button      = $("#add_color_btn"); //Add button ID
    var y = 1; //initlal text box count

    $(add_color_btn).click(function(){

        y++;
        $("#color_div").append('<div class=\"col-md-12 col-sm-12 col-xs-12 mb-3\" id=\"color_row'+y+'\"> <div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\"> <input type=\"text\" class=\"form-control\" placeholder=\"Enter color\" name=\"color[]\" required> </div><div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\"> <input type=\"color\" class=\"form-control\" placeholder=\"Enter color code\" name=\"color_code[]\" required> </div><div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\"> <button type=\"button\" onclick=\"removeColorRow('+y+')\" class=\"btn btn-danger\">Remove</button> </div></div>');
    });
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper   		= $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $("#add_stock_btn"); //Add button ID
    var x = 1; //initlal text box count


    $(add_button).click(function(e){
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div class=\"col-md-12 col-sm-12 col-xs-12 mb-3\" id=\"stock_row'+x+'\"><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"><input type=\"text\" class=\"form-control\" name=\"size[]\" required></div><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"><input type=\"number\" min=\"0\" class=\"form-control\" name=\"stock[]\" required></div><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"><input type=\"number\" min=\"0\" class=\"form-control\" name=\"price[]\" required></div><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"><input type=\"number\" class=\"form-control\" name=\"discount[]\" required></div><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"><button type=\"button\" onclick=\"removeCosPerRow('+x+')\" class=\"btn btn-danger\">Remove</button></div></div>'); //add input box
            }
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