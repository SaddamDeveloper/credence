
@extends('admin.template.master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8" style="margin-top:50px;">
            <div class="x_panel">

                <div class="x_title">
                    <h2>Exchange Request {{$status==1?'Accept':'Reject'}}</h2>
                    
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
                       <form method="POST" action="{{route('admin.process_exchange_request')}}">
                            @csrf
                            <div class="form-group">
                                <label for="order_id">Order ID:</label>
                                <input value="{{$exchange->order_id}}" readonly="readonly" class="form-control">
                                <input value="{{$exchange->id}}" type="hidden" name="order_id" class="form-control">
                                <input value="{{$status}}" type="hidden" name="status" class="form-control">
                              
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
    
 @endsection
