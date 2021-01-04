
@if (isset($response) && !empty($response))
<html>
<button id="rzp-button1" hidden>Pay</button>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var options = {
    "key": "{{$response['key_id']}}",
    "amount": "{{$response['amount']}}",
    "currency": "INR",
    "name": "Acme Corp",
    "description": "Test Transaction",
    "image": "{{asset('web/images/logo/logo-2.png')}}",
    "order_id": "{{$response['order_id']}}",
    "handler": function (response){
        console.log(response.razorpay_payment_id);
        document.getElementById("rzp_paymentId").value = response.razorpay_payment_id;
        document.getElementById("rzp_orderId").value = response.razorpay_order_id;
        document.getElementById("rzp_signature").value = response.razorpay_signature;
        document.getElementById('callback_btn').click();
        // alert(response.razorpay_payment_id);
        // alert(response.razorpay_order_id);
        // alert(response.razorpay_signature)
    },
    "prefill": {
        "name": "{{$response['name']}}",
        "email": "{{$response['email']}}",
        "contact": "{{$response['mobile']}}"
    },
    "notes": {
        "address": "Ashia Product Payment"
    },
    "theme": {
        "color": "#F37254"
    }
};
var rzp1 = new Razorpay(options);
window.onload = function(){
    document.getElementById('rzp-button1').click();
}
document.getElementById('rzp-button1').onclick = function(e){
    rzp1.open();
    e.preventDefault();
}
</script>
<form action="{{route('web.pay_success')}}" method="POST" hidden>
    @csrf
    <input type="hidden" id="rzp_paymentId" name="paymentId">
    <input type="hidden" id="rzp_orderId" name="orderId">
    <input type="hidden" id="rzp_signature" name="signature">
    <button id="callback_btn">Submit</button>
</form>
</html>
@endif

