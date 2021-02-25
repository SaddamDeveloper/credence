
@extends('admin.template.master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8" style="margin-top:50px;">
            <div class="x_panel">

                <div class="x_title">
                    <h2>Add Account Details</h2>
                    
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
                       <form method="POST" action="{{ route('admin.post_refund_details',['id'=>$refund->id])}}">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="order_id">Order ID:</label>
                                <input value="{{$refund->order->order_id}}" readonly="readonly" class="form-control">
                              
                           </div>
                            <div class="form-group">
                                <label for="user_name">User name:</label>
                                <input value="{{$refund->user->name}}" readonly="readonly" class="form-control">
                              
                           </div>
                            <div class="form-group">
                                <label for="amount">Amount:</label>
                                <input value="{{$refund->order->amount}}" readonly="readonly" class="form-control">
                              
                           </div>
                            <div class="form-group">
                                <label for="amount">Reasons:</label>
                                <textarea name="reasons" class="form-control"></textarea>
                                @if($errors->has('reasons'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('reasons') }}</strong>
                                    </span>
                                @enderror
                              
                           </div>
                            <div class="form-group">
                                <label for="code">Account No:</label>
                                <input type="number" name="acc_no" class="form-control">
                            
                            @if($errors->has('acc_no'))
                                <span class="invalid-feedback" role="alert" style="color:red">
                                    <strong>{{ $errors->first('acc_no') }}</strong>
                                </span>
                            @enderror
                            </div>

                            <div class="form-group">
                                <label for="discount">Account Name:</label>
                                <input type="text" name="acc_name" class="form-control">
                                
                                @if($errors->has('acc_name'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('acc_name') }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="ifsc">IFSC:</label>
                                <input type="text" name="ifsc" class="form-control">
                                
                                @if($errors->has('ifsc'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('ifsc') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="ifsc">Branch:</label>
                                <input type="text" name="branch" class="form-control">
                                
                                @if($errors->has('branch'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('branch') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success">
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
