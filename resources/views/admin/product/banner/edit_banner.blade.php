@extends('admin.template.master')

@section('content')
<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit Banner</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content"><br />
            <center>
                @if(session()->has('msg'))
                    <b>{{ session()->get('msg') }}</b>
                @endif
                <br>
                <img src="{{ $url }}" alt="Product Banner" height="200px" name="product_banner" id="product_banner"><br><br>
            </center>
            <!-- Section For New User registration -->
            <form method="POST" autocomplete="off" action="{{ route('admin.update_apparel_product_banner', ['product_id' => encrypt($product_id) ]) }}" class="form-horizontal form-label-left" enctype="multipart/form-data">
                @method('PUT')
                @csrf
               
              <div class="form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Product Banner : <span class="required">*</span></label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="file"  name="icon" id="icon"  class="form-control col-md-7 col-xs-12" required>
                    @error('icon')
                        {{ $message }}
                    @enderror
                </div>
              </div>

              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" name="submit" class="btn btn-success">Save Banner</button>
                    <a onclick="window.close()" class="btn btn-warning">Close</a>
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
$('#icon').change(function(e){

    var url = URL.createObjectURL(e.target.files[0]);
    $('#product_banner').attr('src', url);
});
</script>
@endsection