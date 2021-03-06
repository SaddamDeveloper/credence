@extends('admin.template.master')

@section('content')
<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit Top-Category</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content"><br />
            @if(session()->has('msg'))
                <div class="alert alert-success">{{ session()->get('msg') }}</div>
            @endif
            <!-- Section For New User registration -->
          <form method="POST" autocomplete="off" action="{{ route('admin.update_top_category', ['top_category_id' => $top_category_record->id ]) }}" class="form-horizontal form-label-left" enctype="multipart/form-data">
                @csrf

                <div class="well" style="overflow: auto">
                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="top_cate_name">Top-Category</label>
                            <input type="text" class="form-control" name="top_cate_name" id="top_cate_name" placeholder="Enter Top-Category" value="{{ $top_category_record->top_cate_name }}">
                            @error('top_cate_name')
                                <span style="font-weight: bold; color: red;">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" name="slug" placeholder="Enter Slug" id="slug" value="{{ $top_category_record->slug }}">
                            @error('slug')
                                <span style="font-weight: bold; color: red;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                          <label for="tax">Tax</label>%
                          <input type="number" class="form-control" name="tax" placeholder="Enter Tax" id="tax" value="{{ $top_category_record->tax }}">
                          @error('tax')
                              <span style="font-weight: bold; color: red;">{{ $message }}</span>
                          @enderror
                        </div>
                    </div>
                </div>

              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" name="submit" class="btn btn-success">Save</button>
                    <a href="{{ route('admin.all_top_category') }}" class="btn btn-warning">Back</a>
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

    $("#top_cate_name").keyup(function(){
        $("#slug").val($("#top_cate_name").val().toLowerCase());
    });
});
</script>
@endsection