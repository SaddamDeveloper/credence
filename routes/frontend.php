<?php

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Route;

Route::group(['namespace'=>'Web'],function(){

	// Cart Destro
	Route::get('cart/destroy', function () {
		Cart::destroy();
	});
	/** Index Router **/
	Route::get('/', 'IndexController@index')->name('web.index');
	/** Product Detail **/ 
	Route::get('product-detail/{slug}/{product_id}', 'ProductController@productDetail')->name('web.product_detail');
	/** Product List: No id means 0 **/ 
	Route::get('product-list/{slug}/{type}/{category_id}', 'ProductController@productList')->name('web.product_list');
	/** AJAX Operations **/
	Route::get('product-search/{keyword}', 'ProductController@productSearch');
	Route::post('product-price-check', 'ProductController@productPriceCheck');
	// Price Filter
	Route::post('/price/filter/', 'ProductController@priceFilter')->name('price_filter');

	// Sorting
	Route::post('/sorting/', 'ProductController@sorting')->name('sorting');

	/** Add Product to Cart **/
	Route::post('add-cart', 'CartController@addCart')->name('web.add_cart');
	// Route::get('add-cart/{id}/{color}/{size}', 'CartController@addCart')->name('web.add_cart');
	/** View Cart **/
	Route::get('view-cart', 'CartController@viewCart')->name('web.view_cart');
	// Route::get('add-cart', 'CartController@viewCart')->name('web.view_cart');
	/** Remove Cart Item **/
	Route::get('remove-cart-item/{id}', 'CartController@removeCartItem')->name('web.remove_cart_item');
	// Route::get('remove-cart-item/{id}', 'CartController@removeItem')->name('web.remove_cart_item');
	/** Update Cart **/
	Route::post('update-cart', 'CartController@updateCart')->name('web.update_cart');
	
    /** User Registration Routes **/
    Route::get('registration-page', 'RegisterController@registrationPage')->name('web.registration_page');
    Route::get('registration', 'RegisterController@registration')->name('web.registration');

    /** User Login Route */
	Route::get('login', 'UsersLoginController@showUserLoginForm')->name('web.login');
	Route::post('login', 'UsersLoginController@userLogin');

	/** User Logout **/
	Route::get('logout', 'UsersLoginController@logout')->name('web.logout');

	/** User Forgot Password **/
	Route::get('forgot-pass-form', 'UsersLoginController@showForgotPasswordForm')->name('web.forgot_pass_form');
	Route::post('verfication-code', 'UsersLoginController@verficationCode')->name('web.verfication_code');
	Route::get('set-pass-form/{user_id}', 'UsersLoginController@showSetPasswordForm')->name('web.set_pass_form');
	Route::get('set-password/{user_id}', 'UsersLoginController@setPassword')->name('web.set_password');
	/** Coupon Check **/
	Route::post('/pincode', 'PinController@pincode')->name('web.pincode_check');
	Route::post('/coupon', 'CouponController@coupon')->name('web.coupon_check');
	
	Route::group(['middleware'=>'auth:users'],function(){
		Route::get('confirm/{order_id}/{address_id}', 'CheckoutController@showConfirm')->name('web.confirm');
		/** Checkout Page **/
		Route::get('checkout', 'CheckoutController@showCheckoutForm')->name('web.checkout');
		/** Place Order **/
		Route::post('place-order', 'CheckoutController@placeOrder')->name('web.place_order');
		/** Thank You Page On Online **/
		Route::post('pay-success/', 'CheckoutController@paySuccess')->name('web.pay_success');
		/** Thank You Page On Cash **/
		Route::get('thank-you', 'CheckoutController@thankYou')->name('web.thankYou');

		/** Address List **/
		Route::get('address-list', 'AddressController@addressList')->name('web.address_list');
		/** Add Address **/
		Route::post('add-address', 'AddressController@addAddress')->name('web.add_address');
		/** Update Address **/
		Route::post('update-address/{address_id}', 'AddressController@updateAddress')->name('web.update_address');
		/** Delete Address **/
		Route::get('edit-address/{address_id}', 'AddressController@editAddress')->name('web.edit_address');

		/** Add to Wish List **/
		Route::get('add-wish-list/{product_id}', 'WishListController@addWishList')->name('web.add_wish_list');
		/** Wish List **/
		Route::get('wish-list', 'WishListController@wishList')->name('web.wish_list');
		/** Remove Wish List Item **/
		Route::get('remove-wish-list/{product_id}', 'WishListController@removeWishList')->name('web.remove_wish_list');

		/** My Orders History **/
		Route::get('order-history', 'OrdersController@orderHistory')->name('web.order_history');

		/** My Profile **/
		Route::get('my-profile', 'UsersController@myProfile')->name('web.my_profile'); 
		/** Edit My Profile **/
		Route::get('edit-my-profile', 'UsersController@editMyProfile')->name('web.edit_my_profile'); 
		/** Update My Profile **/
		Route::post('update-my-profile', 'UsersController@updateMyProfile')->name('web.update_my_profile');

				//========= order =========//

		Route::get('/Order', 'OrdersController@orderDetail')->name('web.order.order');
		Route::get('/order/details/{id}','OrdersController@orderDetailss')->name('web.order.order_details');
		Route::get('/order/cancel/{order_id}','OrdersController@cancelOrder')->name('web.order.cancel_order');
		Route::get('/order/refund/{order_id}','OrdersController@refundForm')->name('web.order.refund_form');
		Route::post('/refund/order/','OrdersController@refund')->name('web.order.refund');
		Route::get('/return/request/{id}','OrdersController@returnRequest')->name('web.order.return_request');
		Route::post('/request/return/','OrdersController@requestReturn')->name('web.order.request_return');
		Route::get('/exchange/request/{id}','OrdersController@exchangeRequest')->name('web.order.exchange_request');
		Route::post('/request/exchange/','OrdersController@postExchangeRequest')->name('web.order.request_exchange');


		
	});
});

//========= Product =========//
Route::get('/Return', function () {
    return view('web.order.return');
})->name('web.order.return');

Route::get('/Exchange', function () {
    return view('web.order.exchange');
})->name('web.order.exchange');

//========= Product =========//
Route::get('/single-product', function () {
    return view('web.product.single-product');
})->name('web.product.single-product');

//========= user =========//
Route::get('/Login', function () {
    return view('web.user.login');
})->name('web.user.login');

Route::get('/Register', function () {
    return view('web.user.register');
})->name('web.user.register');

Route::get('/Forgot-password', function () {
    return view('web.user.forgot-password');
})->name('web.user.forgot-password');

Route::get('/Forgot-password/Change-password', function () {
    return view('web.user.forgot-change-password');
})->name('web.user.forgot-change-password');

//========= Address =========//
Route::get('/address', function () {
    return view('web.address.address');
})->name('web.address.address');

Route::get('/address/Edit', function () {
    return view('web.address.edit-address');
})->name('web.address.edit-address');

//========= profile =========//
Route::get('/Profile', function () {
    return view('web.profile.profile');
})->name('web.profile.profile');

Route::get('/Profile/Edit', function () {
    return view('web.profile.edit-profile');
})->name('web.profile.edit-profile');

Route::get('/Profile/Change-password', function () {
    return view('web.profile.change-password');
})->name('web.profile.change-password');

//========= checkout =========//
Route::get('/cart', function () {
    return view('web.checkout.cart');
})->name('web.checkout.cart');

//========= Order Placed =========//
Route::get('/Order-placed', function () {
    return view('web.checkout.corfirm');
})->name('web.checkout.corfirm');

//========= wishlist =========//
Route::get('/Wishlist', function () {
    return view('web.wishlist.wishlist');
})->name('web.wishlist.wishlist');

//========= Terms and Condition =========//
Route::get('/Terms&Condition', function () {
    return view('web.other.terms');
})->name('web.other.terms');

//========= Return and replacement policy =========//
Route::get('/Return&Replacement/policy', function () {
    return view('web.other.returnandreplacement');
})->name('web.other.returnandreplacement');



