
@extends('admin.template.master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8" style="margin-top:50px;">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Update Charges</h2>
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
                        <form method="POST" action="{{ route('admin.charges_update',['charges'=>$charges->id]) }}">
                            @csrf
                            <div class="form-group">
                                <input type="number" name="amount" value="{{ $charges->amount }}" class="form-control" placeholder="Enter Amount">
                               
                                @if($errors->has('amount'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span> 
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary">
                                <a href="{{route('admin.charges_list')}}" class="btn btn-warning">Back</a>
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