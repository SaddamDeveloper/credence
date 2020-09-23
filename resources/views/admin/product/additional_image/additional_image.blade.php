@extends('admin.template.master')
@section('content')
<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>{{ $product_record->product_name }}</h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_content">
                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                      </div>

                      <div class="clearfix"></div>

                      @if(!$additional_image_record->isEmpty())
                            @foreach($additional_image_record as $value)
                                <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                                    <div class="well profile_view">
                                        <div class="col-sm-12">
                                            <div class="left col-xs-7">
                                                <img src="{{ asset('assets/product_images/thumb/'.$value->additional_image) }}" style="width: 170px;" id="img">
                                            </div>
                                        </div>
                                    </div>
                                    @if($product_record->banner == $value->additional_image)
                                    <div class="row">
                                        <button class="btn btn-default">Thumbnail</button>
                                    </div>
                                    @else
                                        <div class="row button-group">
                                            <a class="btn btn-info" href="{{ route('admin.set_as_thumb', [ 'banner' => $value->additional_image, 'id' => encrypt($product_record->id)]) }}">Set as Thumbnail</a>
                                            <a class="btn btn-danger" href="{{ route('admin.delete_thumb', ['id' => encrypt($product_record->id), 'pId' => $value->id ]) }}">Delete</a>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                      @endif
                      
                    </div>
                  </div>
                </div>
              </div>
              <div class="x_panel">
                  <div class="x_content">
                      <div class="col-xs-12 bottom text-center">
                        <form method="POST" autocomplete="off" action="{{ route('admin.update_product_additional_image') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product_record->id }}">
                        <div class="col-md-3"></div>
                          <p  class="col-xs-12 col-sm-4 ratings">
                            <input type="file" name="additional_image[]"  accept="image/*" multiple required class="form-control">
                        </p>
                        <div class="col-xs-12 col-sm-1 emphasis">
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </div>
                        </form>
                      </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
@endsection
@section('script')
<script type="text/javascript">
$('#additional_image').change(function(e){

    var url = URL.createObjectURL(e.target.files[0]);
    $('#img').attr('src', url);
});
</script>
@endsection

