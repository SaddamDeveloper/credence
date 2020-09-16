@extends('admin.template.master')

@section('content')
<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit Sub-Category</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content"><br />
            @if(session()->has('msg'))
                <div class="alert alert-success">{{ session()->get('msg') }}</div>
            @endif
            <!-- Section For New User registration -->
            <form method="POST" autocomplete="off" action="{{ route('admin.update_grocery_sub_category', ['subCategoryId' => encrypt($data[0]->id)]) }}" class="form-horizontal form-label-left" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="well" style="overflow: auto">
                    <div class="form-row mb-3">
                        <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                            <label for="top_cate_name">Top-Category</label>
                            <select class="form-control form-text-element" name="top_cate_name" required>
                                <option value="" selected disabled>Choose Top-Category</option>
                                @if(count($all_top_category) > 0)
                                    @foreach($all_top_category as $key => $value)
                                        @if($value->id == $data[0]->top_category_id)
                                            <option value="{{ $value->id }}" class="form-text-element" selected>{{ $value->top_cate_name }}</option>
                                        @else
                                            <option value="{{ $value->id }}" class="form-text-element">{{ $value->top_cate_name }}</option>
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
                            <input type="text"  name="sub_cate_name" id="sub_cate_name"  class="form-control col-md-7 col-xs-12 form-text-element" value="{{ $data[0]->sub_cate_name }}" required>
                            @error('sub_cate_name')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                            <label for="slug">Slug</label>
                            <input type="text" name="slug" id="slug"  class="form-control col-md-7 col-xs-12" value="{{ $data[0]->slug }}" required>
                            @error('slug')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" name="submit" class="btn btn-success form-text-element">Save Sub-Category</button>
                    <a href="{{ route('admin.all_sub_category') }}" class="btn btn-warning">Back</a>
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

    $("#sub_cate_name").keyup(function(){
        $("#slug").val($("#sub_cate_name").val().toLowerCase());
    });
});
</script>
@endsection