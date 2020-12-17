<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Mail\OrderEmail;
use Mail;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\ProductColorMapping;
use App\Models\ProductStock;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function showCheckoutForm()
    {
        $all_address = Address::where('user_id', Auth::guard('users')->user()->id)->orderBY('id', "DESC")->get();
        $shipping_charge = DB::table('charges')->first();
        
        $shipping_charge = $shipping_charge->amount;
       
        $total = 0;
        $grand_total = 0;
        $tax= 0;
        $user_id = Auth::guard('users')->user()->id;
        $cart = Cart::where('user_id', $user_id)->get();
        $total = collect($cart)->sum(function ($row) {
     
            return $row->sizes->price* $row->quantity;
        });
        $tax = collect($cart)->sum(function ($row){
            return ($row->sizes->price * $row->product->topCategory->tax)/100;
        });
        $grand_total = $total + $shipping_charge+$tax;
       
        
    	return view('web.checkout.checkout', ['all_address' => $all_address,'tax'=>$tax,'shipping_charge'=>$shipping_charge, 'total' => $total, 'grand_total' => $grand_total]);
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
        $address = Address::find($address_id);
        
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
        $order_id = null;
        if($request->input('payment_type') == 1){
            try {
               
                DB::transaction(function () use($address_id, &$order_id) {
                    $shipping_charge = DB::table('charges')->first();
                    $shipping_charge = $shipping_charge->amount;
                    $total = 0;
                    $tax = 0;
                   
                    $grand_total = 0;
                    $user_id = Auth::guard('users')->user()->id;
                    $cart = Cart::where('user_id', $user_id)->get();
                    $total = collect($cart)->sum(function ($row) {
                        
                        return $row->sizes->price * $row->quantity;
                    });
                   
                    $grand_total = $total + $shipping_charge+$tax;
                    $order = new Order();
                    $order->order_id = time();
                    $order->user_id = $user_id;
                    $order->address_id = $address_id;
                    $order->payment_type =1;
                    
                    $order->amount = $grand_total;
                    $order->payment_status = 1;
                    if($order->save()){
                        $order_id = $order->id;
                        $payment_status = DB::table('order')
                        ->where('id', $order->id)
                        ->update([
                            'payment_status' => 3
                        ]);
                    }
                    $cart = Cart::where('user_id',$user_id)->get();
                    foreach ($cart as $item) {
                        $product = Product::where('id', $item->product_id)->where('status', 1)->first();
                        $size = ProductStock::find($item->size_id);
                        $color = ProductColorMapping::where('product_id', $product->id)->first();
                            DB::table('order_detail')
                                    ->insert([
                                        'order_id' => $order->id,
                                        'product_id' =>$product->id,
                                        'stock_id' => $item->size_id,
                                        'price' => $item->sizes->price,
                                        'discount' => $item->sizes->discount,
                                        'quantity' => $item->quantity,
                                        'product_image' => $item->product->banner
                                ]);

                        // Stock
                        for ($i=0; $i < $item->qty; $i++) { 
                            $stock = DB::table('product_stock')
                                ->where('id', $size->id)
                                ->first();

                            if ($stock->stock > 0) {
                                DB::table('product_stock')
                                    ->where('id', $size->id)
                                    ->update([
                                        'stock' => $stock->stock - 1 
                                    ]);
                            }
                        }
                    }
                     // /** Sending Order Email **/
                    // $user_detail = DB::table('users')
                    //     ->where('id', Auth()->user()->id)
                    //     ->first();
                    //        $request_info = "<table width=\"100%\">
                    //             <tr>
                    //                 <td>
                    //                     <address>
                    //                         <strong>Billed to</strong>
                    //                         <br>".$user_detail->name."
                    //                         <br>Phone: ".$user_detail->contact_no."
                    //                         <br>Email: ".$user_detail->email."
                    //                     </address>
                    //                 </td>
                    //                 <td>
                    //                     <address>
                    //                         <strong>Ciel Couture</strong>
                    //                         <br>Guwahati, Assam
                    //                         <br>Phone: 88638746953
                    //                         <br>Email: info@cielcouture.com
                    //                      </address>
                    //                 </td>
                    //             </tr>
                    //         </table><br>
                    //         <table border=\"1\" class=\"table\">
                    //             <tr>
                    //                 <th>Product Name</th>
                    //                 <th>Description</th>
                    //                 <th>Price</th>
                    //                 <th>Quantity</th>
                    //                 <th>Amount</th>
                    //             </tr>";
                    //             $request_info = $request_info."
                    //             <tr>
                    //                 <td colspan=\"4\" align=\"right\" style=\"font-weight: bold;\">Subtotal</td>
                    //                 <td>".$total."</td>
                    //             </tr>
                    //             <tr>
                    //                 <td colspan=\"4\" align=\"right\" style=\"font-weight: bold;\">Discount</td>
                    //                 <td>".(0.00)."</td>
                    //             </tr>
                    //             <tr>
                    //             <td colspan=\"4\" align=\"right\" style=\"font-weight: bold;\">Shipping Charge</td>
                    //             <td>".$shipping_charge."</td>
                    //             <td colspan=\"4\" align=\"right\" style=\"font-weight: bold;\">Shipping Charge</td>
                    //             <td>".$tax."</td>
                    //         </tr>
                    //             <tr>
                    //                 <td colspan=\"4\" align=\"right\" style=\"font-weight: bold;\">Total</td>
                    //                 <td>".$grand_total."</td>
                    //             </tr>
                    //         </table>
                    //         <p style=\"text-align: left;\">Date : ".date('d-m-Y')."</p>";
                    //         $subject = "Ciel Couture Order Confirmation";
                    
                    //         $data = [
                    //             'message' => $request_info,
                    //             'subject' => $subject,
                    //         ];

                            // Mail::to(Auth::guard('users')->user()->email)->send(new OrderEmail($data));
                            
                            // $arr = array('msg' => 'Payment successfully credited', 'status' => true);
                            
                            // return Response()->json($arr); 
                            // return $order_id;
                          
                });
                    return redirect()->route('web.confirm', ['order_id' => encrypt($order_id), 'address_id' => encrypt($address_id)]);
            } catch (\Exception $e) {
                dd($e);
                return redirect()->back()->with('error', 'Something went Wrong! Try after sometime!');
            }
        }else{
            // Online Payment
            dd("Online Payment Inbtegration");
        }


    }

    public function thankyou()
    {
    	return view('web.checkout.thankyou');
    }
}
