@extends('admin.template.master')

@section('content')
<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>New Size Mapping</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content"><br />
            @if(session()->has('msg'))
                <div class="alert alert-success">{{ session()->get('msg') }}</div>
            @endif
            <!-- Section For New User registration -->
            <form method="POST" autocomplete="off" action="{{ route('admin.update_grocery_mappping_size', ['size_mapping_id' => encrypt($mapping_size_record[0]->id)]) }}" class="form-horizontal form-label-left">
                @csrf

                <div class="well" style="overflow: auto">
                    <div class="form-row mb-3">

                        <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                            <label for="top_cate_id">Top-Category</label>
                            <input type="text" name="top_cate_id" value="{{ $top_category_record[0]->top_cate_name }}" class="form-control col-md-7 col-xs-12" disabled readonly>
                            @error('top_cate_id')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                            <label for="sub_cate_id">Sub-Category</label>
                            <input type="text" name="sub_cate_id" value="{{ $sub_category_record[0]->sub_cate_name }}" class="form-control col-md-7 col-xs-12" disabled readonly>
                            @error('sub_cate_id')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                            <label for="size">Size</label>
                            <select  name="size" class="form-control col-md-7 col-xs-12">
                                <option selected disabled value="">Choose Size</option>
                                @if(isset($all_size) && !empty($all_size) && (count($all_size) > 0))
                                    @foreach($all_size as $key => $value)
                                        @if($value->id == $mapping_size_record[0]->size_id)
                                            <option value="{{ $value->id }}" selected>{{ $value->size }}</option>
                                        @else
                                            <option value="{{ $value->id }}">{{ $value->size }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            @error('color')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" name="submit" class="btn btn-success form-text-element">Update Mapping</button>
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

@endsection