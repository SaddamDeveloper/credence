@extends('admin.template.master')

@section('content')
<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit Third Level Sub-Category</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content"><br />
            @if(session()->has('msg'))
                <div class="alert alert-success">{{ session()->get('msg') }}</div>
            @endif
            <!-- Section For New User registration -->
            <form method="POST" autocomplete="off" action="{{ route('admin.update_third_level_sub_category', ['third_sub_category_id' => $third_level_sub_category->id]) }}" class="form-horizontal form-label-left">
                @csrf
                <div class="well" style="overflow: auto">
                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="top_cate_name">Top-Category</label>
                            <select class="form-control" name="top_cate_name" id="top_cate_name" required>
                                <option value="" selected disabled>Choose Top-Category</option>
                                @if(count($top_categories) > 0)
                                    @foreach($top_categories as $key => $value)
                                        @if($value->id == $third_level_sub_category->top_category_id)
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

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="sub_cate_name">Sub-Category</label>
                            <select class="form-control" name="sub_cate_name" id="sub_cate_name" required>
                                <option value="" selected disabled>Choose Sub-Category</option>
                                @if(count($sub_categories) > 0)
                                    @foreach($sub_categories as $key => $value)
                                        @if($value->id == $third_level_sub_category->sub_category_id)
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

                         <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="third_level_sub_cate_name">3rd Sub-Category</label>
                            <input type="text" name="third_level_sub_cate_name" id="third_level_sub_cate_name" class="form-control col-md-7 col-xs-12" value="{{ $third_level_sub_category->third_level_sub_category_name }}" required>
                            @error('third_level_sub_cate_name')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="slug">Slug</label>
                            <input type="text" name="slug" id="slug" value="{{ $third_level_sub_category->slug }}" class="form-control col-md-7 col-xs-12" required>
                            @error('slug')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" name="submit" class="btn btn-success">Save</button>
                    <a href="{{ route('admin.all_third_level_sub_category') }}" class="btn btn-warning">Back</a>
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

    $("#third_level_sub_cate_name").keyup(function(){
        $("#slug").val($("#third_level_sub_cate_name").val().toLowerCase());
    });

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

                $('#sub_cate_name').html(response);
            }
        }); 
    });
});
</script>
@endsection
