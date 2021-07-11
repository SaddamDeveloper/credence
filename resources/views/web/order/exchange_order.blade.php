@extends('web.templet.master')

{{-- @include('web.include.seo') --}}

@section('seo')
  <meta name="description" content="Credence">
@endsection

@section('content')

<form method="POST" action="{{route('web.order.request_exchange')}}">
    @csrf
    <label for="ifsc">Order ID</label>
    <input readonly="readonly" value="{{$order->order_id}}">
    <label for="reason">Reason</label>
    <input type="hidden" name="order_id" value="{{$order->id}}">
    <textarea name="reason"></textarea>
   
  
    <button type="submit">Submit</button>
</form>

@endsection
