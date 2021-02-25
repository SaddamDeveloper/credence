@extends('web.templet.master')

{{-- @include('web.include.seo') --}}

@section('seo')
  <meta name="description" content="Credence">
@endsection

@section('content')

<form method="POST" action="{{route('web.order.refund')}}">
    @csrf
    <label for="reason">Reason</label>
    <input type="hidden" name="order_id" value="{{$order_id}}">
    <textarea name="reason"></textarea>
    <label for="ifsc">IFSC</label>
    <input type="text" name="ifsc">
    <label for="branch">Branch</label>
    <input type="text" name="branch">
    <label for="acc_no">Account No</label>
    <input type="number" name="acc_no">
    <label for="acc_name">Account Name</label>
    <input type="text" name="acc_name" >
    <button type="submit">Submit</button>
</form>

@endsection
