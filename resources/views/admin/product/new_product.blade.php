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
            @if (Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif
            <!-- Section For New User registration -->
            <form method="post" action="{{ route('admin.add_product') }}" class="form-horizontal form-label-left" enctype="multipart/form-data">
                @csrf
                <div class="well" style="overflow: auto">
                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="product_name">Product Name</label>
                            <input type="text" class="form-control" name="product_name" placeholder="Product Name" id="product_name" value="{{ old('product_name') }}" required>
                            </select>
                            @if($errors->has('product_name'))
                                <span class="invalid-feedback" role="alert" style="color:red">
                                    <strong>{{ $errors->first('product_name') }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" name="slug" id="slug" value="{{ old('slug') }}" readonly >
                            </select>
                            @if($errors->has('slug'))
                                <span class="invalid-feedback" role="alert" style="color:red">
                                    <strong>{{ $errors->first('slug') }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="top_cate_name">Top-Category</label>
                            <select name="top_cate_name" id="top_cate_name"  class="form-control col-md-7 col-xs-12" required>
                                <option disabled selected>Choose Top-Category</option>
                                @if(count($top_category) > 0)
                                    @foreach($top_category as $key => $value)
                                        <option value="{{ $value->id }}" {{old('top_cate_name') == $value->id ? 'selected':''}}>{{ $value->top_cate_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @if($errors->has('top_cat_name'))
                                <span class="invalid-feedback" role="alert" style="color:red">
                                    <strong>{{ $errors->first('top_cat_name') }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="sub_cate_name">Sub-Category</label>
                            <select name="sub_cate_name" id="sub_cate_name" class="form-control col-md-7 col-xs-12">
                                <option value="" disabled selected>Choose Sub-Category</option>
                            </select>
                            @if($errors->has('sub_cate_name'))
                                <span class="invalid-feedback" role="alert" style="color:red">
                                    <strong>{{ $errors->first('sub_cate_name') }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="third_level_sub_cate_name">Third Level Sub-Category</label>
                            <select name="third_level_sub_cate_name" id="third_level_sub_cate_name" class="form-control col-md-7 col-xs-12">
                                <option value="" disabled selected>Choose Sub-Category</option>
                            </select>
                            @if($errors->has('third_level_sub_cate_name'))
                                <span class="invalid-feedback" role="alert" style="color:red">
                                    <strong>{{ $errors->first('third_level_sub_cate_name') }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="brand">Brand</label>
                            <select name="brand" id="brand" class="form-control col-md-7 col-xs-12">
                                <option value="" disabled selected>Choose Brand</option>
                            </select>
                            @if($errors->has('brand'))
                                <span class="invalid-feedback" role="alert" style="color:red">
                                    <strong>{{ $errors->first('brand') }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="product_images">Product Images (Max 700 * Max 700)</label>
                            <input type="file" class="form-control" name="product_images[]" multiple  value="{{ old('product_images.*') }}" required>
                            @if($errors->has('product_images'))
                                <span class="invalid-feedback" role="alert" style="color:red">
                                    <strong>{{ $errors->first('product_images') }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="well" style="overflow: auto;" id="whole_stock_div">
                    <div class="form-row mb-3">
                        <div class="col-md-12 col-sm-12 col-xs-12 mb-3" id="stock_div">
                            <div class="col-md-10 col-sm-12 col-xs-12 mb-3 input_fields_wrap">
                                <div class="col-md-2 col-sm-12 col-xs-12 mb-3"> 
                                    <label for="size">Size Name</label> 
                                    <input type="text" class="form-control" name="size[]" value="{{ old('size.*') }}" >
                                </div>
                                <div class="col-md-2 col-sm-12 col-xs-12 mb-3"> 
                                    <label for="stock">Stock</label> 
                                    <input type="number" min="0" class="form-control" name="stock[]" value="{{ old('stock.*') }}" required>
                                </div>
                                <div class="col-md-2 col-sm-12 col-xs-12 mb-3">
                                    <label for="price">Price</label> 
                                    <input type="number" class="form-control" name="price[]" value="{{ old('price.*') }}" required>
                                    @if($errors->has('price.*'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('price') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-2 col-sm-12 col-xs-12 mb-3">
                                    <label for="discount">MRP</label> 
                                    <input type="number" class="form-control" name="discount[]" value="{{ old('discount.*') }}" required>
                                    @if($errors->has('discount.*'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('discount') }}</strong>
                                    </span>
                                @enderror
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                    <button type="button" class="btn btn-primary" id="add_stock_btn">Add</button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="well">
                        <div class="form-row mb-3">
                            <div class="color-selection form-inline">
                                <div class="radio">
                                    <label for="color">Product Has color?</label>
                                    <label><input type="radio" id="no" name="color-selection" checked>No</label>
                                    <label><input type="radio" id="yes" name="color-selection">Yes</label>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="well" style="overflow: auto; display: none;" id="whole_color_div">
                    <div class="form-row mb-3">
                        <div class="col-md-12 col-sm-12 col-xs-12 mb-3" id="color_div">
                            <button type="button" id="add_color_btn" class="btn btn-primary" >Add Color</button>
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-3"> 
                                <div class="col-md-4 col-sm-12 col-xs-12 mb-3"> 
                                    <input type="text" class="form-control" placeholder="Enter color" name="color[]"> 
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12 mb-3"> 
                                    <input type="color" class="form-control" placeholder="Enter color code" name="color_code[]"> 
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
                            @if($errors->has('desc'))
                                <span class="invalid-feedback" role="alert" style="color:red">
                                    <strong>{{ $errors->first('desc') }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" name="submit" class="btn btn-success form-text-element pull-right">Submit</button>
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
        $("#slug").val($("#product_name").val().toLowerCase().replace(/[^a-zA-Z0-9]+/g,'-'));
    });

    $("#product_type").change(function(){
        // var product_type = $("#product_type").val();

        color_cnt = 0;
        cnt = 0;
    });
    
    var max_fields_y      = 10; //maximum input boxes allowed
    var wrapper_y   		= $("#color_div"); //Fields wrapper
    var add_color_button_y      = $("#add_color_btn"); //Add button ID
    var color_cnt = 1; //initlal text box count
    $(add_color_btn).on('click', function(e){
        e.stopPropagation();
        color_cnt++;
        $("#color_div").append('<div class=\"col-md-12 col-sm-12 col-xs-12 mb-3\" id=\"color_row'+color_cnt+'\"> <div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\"> <input type=\"text\" class=\"form-control\" placeholder=\"Enter color\" name=\"color[]\" required> </div><div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\"> <input type=\"color\" class=\"form-control\" placeholder=\"Enter color code\" name=\"color_code[]\" required> </div><div class=\"col-md-4 col-sm-12 col-xs-12 mb-3\"> <button type=\"button\" onclick=\"removeColorRow('+color_cnt+')\" class=\"btn btn-danger\">Remove</button> </div></div>');
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

    $("#whole_color_div").hide()
    $("input[id$='yes']").click(function() {
            $("#whole_color_div").show();
    });
    $("input[id$='no']").click(function() {
            $("#whole_color_div").hide();
    });
});

// function addClothRow() {
//      //CutOFF Generate
//      var max_fields      = 10; //maximum input boxes allowed
//         var wrapper   		= $(".input_fields_wrap"); //Fields wrapper
//         var add_button      = $("#add"); //Add button ID

//     cnt++;
//     $("#stock_div").append('<div class=\"col-md-12 col-sm-12 col-xs-12 mb-3\" id=\"stock_row'+cnt+'\"><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"><input type=\"text\" class=\"form-control\" name=\"size[]\" required></div><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"><input type=\"number\" min=\"0\" class=\"form-control\" name=\"stock[]\" required></div><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"><input type=\"number\" min=\"0\" class=\"form-control\" name=\"price[]\" required></div><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"><input type=\"number\" class=\"form-control\" name=\"discount[]\" required></div><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"><button type=\"button\" onclick=\"removeCosPerRow('+cnt+')\" class=\"btn btn-danger\">Remove</button></div></div>');
// }

// function addCosPerRow() {

//     cnt++;
//     $("#stock_div").append('<div class=\"col-md-12 col-sm-12 col-xs-12 mb-3\" id=\"stock_row'+cnt+'\"><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"><input type=\"text\" class=\"form-control\" name=\"size[]\" required></div><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"><input type=\"number\" min=\"0\" class=\"form-control\" name=\"stock[]\" required></div><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"><input type=\"number\" min=\"0\" class=\"form-control\" name=\"price[]\" required></div><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"><input type=\"number\" class=\"form-control\" name=\"discount[]\" required></div><div class=\"col-md-2 col-sm-12 col-xs-12 mb-3\"><button type=\"button\" onclick=\"removeCosPerRow('+cnt+')\" class=\"btn btn-danger\">Remove</button></div></div>');
// }

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