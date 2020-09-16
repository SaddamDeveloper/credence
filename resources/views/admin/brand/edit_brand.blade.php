@extends('admin.template.master')

@section('content')
<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit Brand</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content"><br />
            @if(session()->has('msg'))
                <div class="alert alert-success">{{ session()->get('msg') }}</div>
            @endif

            @if(session()->has('error'))
                <div class="alert alert-warning">{{ session()->get('error') }}</div>
            @endif
            <!-- Section For New User registration -->
            <form method="POST" autocomplete="off" action="{{ route('admin.update_brand', ['brand_id' => $brand_record->id]) }}" class="form-horizontal form-label-left">
                @csrf
                <div class="well" style="overflow: auto">
                    <div class="form-row mb-3">
                        <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                            <label for="top_cate_name">Top-Category</label>
                            <select name="top_cate_name" id="top_cate_name"  class="form-control col-md-7 col-xs-12">
                                <option value="" disabled selected>Choose Top-Category</option>
                                @if(count($top_category) > 0)
                                    @foreach($top_category as $key => $value)
                                        @if($value->id == $brand_record->top_category_id)
                                            <option value="{{ $value->id }}" selected>{{ $value->top_cate_name }}</option>
                                        @else
                                            <option value="{{ $value->id }}">{{ $value->top_cate_name }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            @error('top_cate_name')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                            <label for="sub_cate_name">Sub-Category</label>
                            <select name="sub_cate_name" id="sub_cate_name"  class="form-control col-md-7 col-xs-12">
                                <option value="" disabled selected>Choose Sub-Category</option>
                                @if(count($sub_category) > 0)
                                    @foreach($sub_category as $key => $value)
                                        @if($value->id == $brand_record->sub_category_id)
                                            <option value="{{ $value->id }}" selected>{{ $value->sub_cate_name }}</option>
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

                        <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                            <label for="brand_name">Brand Name</label>
                            <input type="text" class="form-control" name="brand_name" value="{{ $brand_record->brand_name }}" required>
                            @error('brand_name')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" name="submit" class="btn btn-success">Save</button>
                    <a href="{{ route('admin.all_brand') }}" class="btn btn-warning">Back</a>
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
<script type="text/javascript">
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
});
</script>
@endsection