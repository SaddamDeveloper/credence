
@extends('admin.template.master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8" style="margin-top:50px;">
            <div class="x_panel">

                <div class="x_title">
                    @if(isset($coupons) && !empty($coupons))
                        <h2>Update Coupon</h2>
                    @else
                        <h2>Add New Coupon</h2>
                    @endif
                    <div class="clearfix"></div>
                </div>

                 <div>
                    @if (Session::has('message'))
                        <div class="alert alert-success">{{ Session::get('message') }}</div>
                    @endif @if (Session::has('error'))
                        <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif
                </div>

                <div>

                    
                    <div class="x_content">
                        @if(isset($coupons) && !empty($coupons))
                            <form method="POST" action="{{ route('admin.coupon_update',['coupons'=>$coupons->id])}}">
                                @method('put')
                                @csrf
                        @else
                            <form method="POST" action="{{ route('admin.coupon_insert_form')}}">
                                @csrf
                        @endif
                        
                        <div class="form-group">
                            <label for="code">Coupon Code</label>
                            @if(isset($coupons) && !empty($coupons))
                                <input type="text" value="{{ $coupons->code }}" name="code" class="form-control">
                            @else 
                                <input type="text" name="code" class="form-control">
                            @endif
                           @if($errors->has('code'))
                               <span class="invalid-feedback" role="alert" style="color:red">
                                   <strong>{{ $errors->first('code') }}</strong>
                               </span>
                           @enderror
                       </div>

                       <div class="form-group">
                            <label for="discount">Discount</label>
                            @if(isset($coupons) && !empty($coupons))
                                <input type="number" value="{{ $coupons->discount }}" name="discount" class="form-control">
                            @else
                                <input type="number" name="discount" class="form-control">
                            @endif
                            @if($errors->has('discount'))
                                <span class="invalid-feedback" role="alert" style="color:red">
                                    <strong>{{ $errors->first('discount') }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="desc">Description</label>
                            @if(isset($coupons) && !empty($coupons))
                            <textarea class="form-control" name="desc">{{ $coupons->description }}</textarea>
                            @else
                                <textarea class="form-control" name="desc"></textarea>
                            @endif
                            @if($errors->has('desc'))
                                <span class="invalid-feedback" role="alert" style="color:red">
                                    <strong>{{ $errors->first('desc') }}</strong>
                                </span>
                            @enderror
                        </div>



                        <div class="form-group">
                            @if(isset($coupons) && !empty($coupons))
                                <input type="submit" value="save" class="btn btn-success">
                            @else
                                <input type="submit" class="btn btn-success">
                            @endif
                            <a href="{{route('admin.coupon_list')}}" class="btn btn-warning">Back</a>

                        </div>
                    </form>

                    </div>
                   
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>

    <div class="clearfix"></div>
</div>
 @endsection

 @section('script')
     <script>
          $(document).ready(function(){
            $("#category").change(function(){
                var category = $(this).val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type:"GET",
                    url:"{{ url('/admin/sub/category/list/with/category/')}}"+"/"+category+"",
                    success:function(data){
                        console.log(data);
                        $("#sub_category").html("<option value=''>Please Select Sub Category</option>");

                        $.each( data, function( key, value ) {
                            $("#sub_category").append("<option value='"+value.id+"'>"+value.name+"</option>");
                        });

                    }
                });
            });
        });
     </script>
 @endsection
