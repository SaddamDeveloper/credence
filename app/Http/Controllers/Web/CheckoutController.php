<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Carbon\Carbon;
use Response;
use App\Mail\OrderEmail;
use Mail;
use App\Models\Address;
use Cart;
use App\Models\Order;
use App\Models\OrderDetails;
class CheckoutController extends Controller
{
    public function showCheckoutForm()
    {
        $all_address = Address::where('user_id', Auth::guard('users')->user()->id)->orderBY('id', "DESC")->get();
        
        // $cart = DB::table('cart')
        //     ->leftjoin('product_stock', 'cart.stock_id', '=', 'product_stock.id')
    	// 	->leftjoin('product','product_stock.product_id','=','product.id')
        //     ->select('product.id', 'product.price', 'product.discount','cart.quantity')
        //     ->where('cart.user_id', Auth()->user()->id)
        //     ->get();

        // $total = 0;
        // foreach ($cart as $key => $item) {
        // 	if (!empty($item->price)) {
		// 		$selling_amount = $item->price;
		// 		$sub_total = $selling_amount * $item->qty;
		// 	} else 
		// 		$sub_total = $item->price * $item->qty;

		// 	$total = $total + $sub_total;
        // }
    	return view('web.checkout.checkout', ['all_address' => $all_address]);
    }
    public function showConfirm($id, $address_id)
    {
        try{
            $id = decrypt($id);
            $address_id = decrypt($address_id);
        }catch(DecryptException $e) {
            abort(404);
        }
        $orders = Order::find($id);
        $address = Address::find($id);
		return view('web.checkout.confirm', compact('orders', 'address'));
    }
    public function placeOrder(Request $request)
    {
    	$request->validate([
    		'address_id' => 'required'
    	],
    	[	'address_id.required' => 'Select Billing Address'
        ]);
        $address_id = $request->input('address_id');
        
        if($request->input('payment_type') == 1){
            try {
                $id = DB::transaction(function () use($address_id) {
                    $order_id = DB::table('order')
                    ->insertGetId([
                        'order_id' => time(),
                        'user_id' => Auth()->user()->id,
                        'address_id' => $address_id,
                        // 'payment_id' => $request->input('razorpay_payment_id'),
                        // 'payment_order_id' => $request->input('razorpay_order_id'),
                        // 'payment_signature' => $request->input('razorpay_signature'),
                        'cashondelivery' => 1,
                        'amount' => Cart::subtotal(),
                        'payment_status' => 2,
                        'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                    ]);

                    foreach (Cart::content() as $key => $item) {
                               	DB::table('order_detail')
                                		->insert([
                                			'order_id' => $order_id,
                                			'stock_id' => $item->options->size->id,
                                			'price' => $item->price,
                                			'discount' => $item->options->discount,
                                			'quantity' => $item->qty
                                    ]);

                        // Stock
                        for ($i=0; $i < $item->qty; $i++) { 
                            $stock = DB::table('product_stock')
                                ->where('id', $item->options->size->id)
                                ->first();

                            if ($stock->stock > 0) {
                                DB::table('product_stock')
                                    ->where('id', $item->options->size->id)
                                    ->update([
                                        'stock' => $stock->stock - 1 
                                    ]);
                            }
                        }
                    }
                     // /** Sending Order Email **/
                    $user_detail = DB::table('users')
                        ->where('id', Auth()->user()->id)
                        ->first();
                           $request_info = "<table width=\"100%\">
                                <tr>
                                    <td>
                                        <address>
                                            <strong>Billed to</strong>
                                            <br>".$user_detail->name."
                                            <br>Phone: ".$user_detail->contact_no."
                                            <br>Email: ".$user_detail->email."
                                        </address>
                                    </td>
                                    <td>
                                        <address>
                                            <strong>Ciel Couture</strong>
                                            <br>Guwahati, Assam
                                            <br>Phone: 88638746953
                                            <br>Email: info@cielcouture.com
                                         </address>
                                    </td>
                                </tr>
                            </table><br>
                            <table border=\"1\" class=\"table\">
                                <tr>
                                    <th>Product Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                </tr>";
                                $request_info = $request_info."
                                <tr>
                                    <td colspan=\"4\" align=\"right\" style=\"font-weight: bold;\">Subtotal</td>
                                    <td>".Cart::subtotal()."</td>
                                </tr>
                                <tr>
                                    <td colspan=\"4\" align=\"right\" style=\"font-weight: bold;\">Discount</td>
                                    <td>".(0.00)."</td>
                                </tr>
                                <tr>
                                    <td colspan=\"4\" align=\"right\" style=\"font-weight: bold;\">Total</td>
                                    <td>".(Cart::subtotal())."</td>
                                </tr>
                            </table>
                            <p style=\"text-align: left;\">Date : ".date('d-m-Y')."</p>";
                            $subject = "Ciel Couture Order Confirmation";
                    
                            $data = [
                                'message' => $request_info,
                                'subject' => $subject,
                            ];

                            // Mail::to(Auth::guard('users')->user()->email)->send(new OrderEmail($data));
                            
                            // $arr = array('msg' => 'Payment successfully credited', 'status' => true);
                            
                            // return Response()->json($arr); 
                            return $order_id;
                });
                    return redirect()->route('web.confirm', encrypt(['id' => $id, 'address_id' => $address_id]));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Something went Wrong! Try after sometime!');
            }
        }else{
            // Online Payment
            dd(2);
        }


        // $cart = DB::table('cart')
        //     ->leftjoin('product_stock', 'cart.stock_id', '=', 'product_stock.id')
        //     ->leftjoin('product','product_stock.product_id','=','product.id')
        //     ->select('product.price', 'product.discount', 'cart.quantity', 'product_stock.id as stock_id')
        //     ->where('cart.user_id', Auth()->user()->id)
        //     ->get();

        // foreach ($cart as $key => $item) {

        // 	DB::table('order_detail')
	    // 		->insert([
	    // 			'order_id' => $order_id,
	    // 			'stock_id' => $item->stock_id,
	    // 			'price' => $item->price,
	    // 			'discount' => $item->discount,
	    // 			'quantity' => $item->quantity
	    // 		]);

        // //  Stock
        //         for ($i=0; $i < $item->quantity; $i++) { 
                
        //         $stock = DB::table('product_stock')
        //             ->where('id', $item->stock_id)
        //             ->first();

        //         if ($stock->stock > 0) {
        //             DB::table('product_stock')
        //                 ->where('id', $item->stock_id)
        //                 ->update([
        //                     'stock' => $stock->stock - 1 
        //                 ]);
        //         }
        //     }
        // }

        // DB::table('cart')
	    // 	->where('user_id', Auth()->user()->id)
	    // 	->delete();

        // /** Sending Order Email **/
        // $user_detail = DB::table('users')
        //     ->where('id', Auth()->user()->id)
        //     ->first();

        // $request_info = "<table width=\"100%\">
        //     <tr>
        //         <td>
        //             <address>
        //                 <strong>Billed to</strong>
        //                 <br>".$user_detail->name."
        //                 <br>Phone: ".$user_detail->contact_no."
        //                 <br>Email: ".$user_detail->email."
        //             </address>
        //         </td>
        //         <td>
        //             <address>
        //                 <strong>Ciel Couture</strong>
        //                 <br>Guwahati, Assam
        //                 <br>Phone: 88638746953
        //                 <br>Email: info@cielcouture.com
        //              </address>
        //         </td>
        //     </tr>
        // </table><br>
        // <table border=\"1\" class=\"table\">
        //     <tr>
        //         <th>Product Name</th>
        //         <th>Description</th>
        //         <th>Price</th>
        //         <th>Quantity</th>
        //         <th>Amount</th>
        //     </tr>";

        // $order_detail = DB::table('order_detail')
        //     ->leftJoin('product_stock', 'order_detail.stock_id', '=', 'product_stock.id')
        //     ->leftJoin('product', 'product_stock.product_id', '=', 'product.id')
        //     ->leftJoin('size', 'product_stock.size_id', '=', 'size.id')
        //     ->leftJoin('color', 'product_stock.color_id', '=', 'color.id')
        //     ->where('order_detail.order_id', $order_id)
        //     ->select('product_stock.product_id', 'product_stock.size_id', 'product_stock.color_id', 'product.product_name', 'size.size', 'color.color', 'order_detail.*')
        //     ->get();

        // $total_sub_total = 0;
        // $total_discount = 0;

        // foreach ($order_detail as $key => $item) {

        //     $sub_total = $item->price * $item->quantity;

        //     $request_info = $request_info."<tr>
        //         <td>".$item->product_name."</td>
        //         <td>Size: ".$item->size.", Color: ".$item->color."</td>
        //         <td>".$item->price."</td>
        //         <td>".$item->quantity."</td>
        //         <td>".$sub_total."</td>
        //     </tr>";

        //     if (!empty($item->discount)) {
                
        //         $discount = ($item->price * $item->discount) / 100;
        //         $total_discount_qty = $item->quantity * $discount;
        //     }

        //     $total_discount = $total_discount + $total_discount_qty;

        //     $total_sub_total = $total_sub_total + $sub_total;
        // }
    }

    public function thankyou()
    {
    	return view('web.checkout.thankyou');
    }
}
