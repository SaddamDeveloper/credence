@extends('admin.template.master')

@section('content')
<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>New Sub-Category</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content"><br />
            @if(session()->has('msg'))
                <div class="alert alert-success">{{ session()->get('msg') }}</div>
            @endif
            <!-- Section For New User registration -->
            <form method="POST" autocomplete="off" action="{{ route('admin.add_sub_category') }}" class="form-horizontal form-label-left" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="well" style="overflow: auto">
                    <div class="form-row mb-3">
                        <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                            <label for="top_cate_name">Top-Category</label>
                            <select class="form-control" name="top_cate_name">
                                <option value="" selected disabled>Choose Top-Category</option>
                                @if(count($top_categories) > 0)
                                    @foreach($top_categories as $key => $value)
                                        <option value="{{ $value->id }}" {{old('top_cate_name') == $value->id ?'selected':''}}>{{ $value->top_cate_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('top_cate_name')
                                <span style="font-weight: bold; color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                         <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                            <label for="sub_cate_name">Sub-Category</label>
                            <input type="text"  name="sub_cate_name" id="sub_cate_name" class="form-control col-md-7 col-xs-12" value="{{ old('sub_cate_name') }}">
                            @error('sub_cate_name')
                                <span style="font-weight: bold; color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                            <label for="slug">Slug</label>
                            <input type="text" name="slug" id="slug"  class="form-control col-md-7 col-xs-12">
                            @error('slug')
                                <span style="font-weight: bold; color: red;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 pull-right">
                    <a href="{{ route('admin.all_sub_category') }}" class="btn btn-warning">Back</a>
                    <button type="submit" name="submit" class="btn btn-success">Submit</button>
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
        $("#slug").val($("#sub_cate_name").val().toLowerCase().replace(/[^a-zA-Z0-9]+/g,'-'));
    });
});
</script>
@endsection
