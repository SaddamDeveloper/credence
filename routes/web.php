<?php
use Illuminate\Support\Facades\Route;

require __DIR__.'/frontend.php';

/** Admin Login Route */
Route::get('/admin/login', 'Admin\AdminLoginController@showAdminLoginForm')->name('admin.login');
Route::get('/register/admin', 'Admin\AdminRegisterController@showAdminRegisterForm')->name('admin.register');
Route::get('/admin/logout', 'Admin\AdminLoginController@logout')->name('admin.logout');

Route::post('/admin/login', 'Admin\AdminLoginController@adminLogin');
Route::post('/register/admin', 'Admin\AdminRegisterController@createAdmin');

/** End of Admin Login Route */

Route::group(['middleware'=>'auth:admin','prefix'=>'admin','namespace'=>'Admin'],function(){
    Route::get('dashboard', 'AdminDashboardController@index')->name('admin.dashboard');
    Route::get('profile', 'AdminDashboardController@profile')->name('admin.profile');
    // Admin Password Change
    Route::get('/change/password', 'AdminDashboardController@changePasswordPage')->name('admin.change_password');
    Route::post('/changePassword','AdminDashboardController@changePassword')->name('admin.changePassword');

    Route::group(['namespace'=>'TopCategory'],function(){

        /** New Top-Category Form **/
        Route::get('new-top-category', 'TopCategoryController@showNewTopCategoryForm')->name('admin.new_top_category');
        /** Add Top-Category **/
        Route::post('add-top-category', 'TopCategoryController@addTopCategory')->name('admin.add_top_category');
        /** All Top-Categories **/
        Route::get('all-top-category', 'TopCategoryController@allTopCategory')->name('admin.all_top_category');
        /** Update Top-Category Status **/
        Route::get('update-top-category-status/{top_category_id}/{status}', 'TopCategoryController@updateTopCategoryStatus')->name('admin.update_top_category_status');
        /** Edit Top-Category Form **/
        Route::get('edit-top-category/{top_category_id}', 'TopCategoryController@showEditTopCategoryForm')->name('admin.edit_top_category');
        /** Update Top-Category Status **/
    	Route::post('update-top-category/{top_category_id}', 'TopCategoryController@updateTopCategory')->name('admin.update_top_category');
    });

    // Route::group(['namespace'=>'GroceryTopCategory'],function(){
     
    //   Route::get('grocery-new-top-category','GroceryTopCategoryController@showTopCategoryForm')->name('admin.grocery_new_top_category');
     
    //   Route::put('grocery-add-top-category','GroceryTopCategoryController@addTopCategory')->name('admin.grocery_add_top_category');
    
    //   Route::get('all-grocery-top-category', 'GroceryTopCategoryController@allTopCategory')->name('admin.all_grocery_top_category');
     
    //   Route::get('show-grocery-edit-top-category-form/{grocerytopCategoryId}','GroceryTopCategoryController@showGroceryTopCategoryForm')->name('admin.show_edit_grocery_top_category_form');
      
    //   Route::put('update-grocery-top-category/{grocerytopCategoryId}','GroceryTopCategoryController@updateGroceryTopCategory')->name('admin.update_grocery_top_category');
    // });

    // Route::group(['namespace'=>'GrocerySubCategory'],function(){
     
    //  Route::get('show-grocery-sub-category','GrocerySubCategoryController@showGrocerySubCategoryForm')->name('admin.show-grocery-sub-category');
     
    //  Route::put('add-grocery-sub-category','GrocerySubCategoryController@addGrocerySubCategory')->name('admin.add-grocery-sub-category');
     
    //  Route::get('list-grocery-sub-category','GrocerySubCategoryController@listGrocerySubCategory')->name('admin.list-grocery-sub-category');

    //   Route::get('edit-grocery-sub-category/{subCategoryId}', 'GrocerySubCategoryController@showGroceryEditSubCategoryForm')->name('admin.edit_grocery_sub_category_form');

    //  Route::put('update-grocery-sub-category/{grocerySubCategoryId}', 'GrocerySubCategoryController@updateGrocerySubCategory')->name('admin.update_grocery_sub_category');
    // });
     
    Route::group(['namespace'=>'SubCategory'],function(){

        /** New Sub-Category Form **/
    	Route::get('new-sub-category', 'SubCategoryController@showSubCategoryForm')->name('admin.new_sub_category');
    	/** Add Sub-Category **/
        Route::put('add-sub-category', 'SubCategoryController@addSubCategory')->name('admin.add_sub_category');
    	/** All Sub-Category **/
        Route::get('all-sub-category', 'SubCategoryController@allSubCategory')->name('admin.all_sub_category');
        /** Update Sub-Category Status **/
        Route::get('update-sub-category-status/{sub_category_id}/{status}', 'SubCategoryController@updateSubCategoryStatus')->name('admin.update_sub_category_status');
    	
        Route::get('edit-sub-category/{subCategoryId}', 'SubCategoryController@showEditSubCategoryForm')->name('admin.edit_sub_category');
    	
        Route::put('update-sub-category/{subCategoryId}', 'SubCategoryController@updateSubCategory')->name('admin.update_sub_category');
    });

    Route::group(['namespace'=>'ThirdLevelSubCategory'],function(){

        /** New 3rd Sub-Category Form **/
        Route::get('new-third-level-sub-category', 'ThirdLevelSubCategoryController@showThirdLevelSubCategoryForm')->name('admin.new_third_level_sub_category');
        /** Add 3rd Sub-Category **/
        Route::put('add-third-level-sub-category', 'ThirdLevelSubCategoryController@addThirdLevelSubCategory')->name('admin.add_third_level_sub_category');
        /** All 3rd Sub-Category **/
        Route::get('all-third-level-sub-category', 'ThirdLevelSubCategoryController@allThirdLevelSubCategory')->name('admin.all_third_level_sub_category');

        Route::get('update-third-sub-category-status/{third_sub_category_id}/{status}', 'ThirdLevelSubCategoryController@updateThirdSubCategoryStatus')->name('admin.update_third_sub_category_status');

        Route::get('edit-third-level-sub-category/{third_sub_category_id}', 'ThirdLevelSubCategoryController@showEditThirdLevelSubCategoryForm')->name('admin.edit_third_level_sub_category');
        
        Route::post('update-third-level-sub-category/{third_sub_category_id}', 'ThirdLevelSubCategoryController@updateThirdLevelSubCategory')->name('admin.update_third_level_sub_category');
    });

    // Route::group(['namespace'=>'GrocerySize'],function(){
   
    //     Route::get('grocery-new-size', 'GrocerySizeController@showGrocerySizeForm')->name('admin.grocery_new_size');

    //  Route::post('add-grocery-size', 'GrocerySizeController@addGrocerySize')->name('admin.add_grocery_size');

    //  Route::get('all-grocery-size', 'GrocerySizeController@allGrocerySize')->name('admin.all_grocery_size');

    //    Route::get('edit-grocery-size/{grocerysizeId}', 'GrocerySizeController@showEditGrocerySizeForm')->name('admin.edit_grocery_size');

    //    Route::post('update-grocery-size/{grocerysizeId}', 'GrocerySizeController@updateGrocerySize')->name('admin.update_grocery_size');

    //     Route::get('new-grocery-mappping-size', 'GrocerySizeController@showGroceryMappingSizeForm')->name('admin.new_grocery_mappping_size');

    //      Route::post('add-grocery-mappping-size', 'GrocerySizeController@addGroceryMappingSize')->name('admin.add_grocery_mapping_size');

    //        Route::get('edit-grocery-mappping-size/{size_mapping_id}', 'GrocerySizeController@showEditGroceryMappingSizeForm')->name('admin.edit_grocery_mappping_size');

    //        Route::post('update-mappping-size/{size_mapping_id}', 'GrocerySizeController@updateGroceryMappingSize')->name('admin.update_grocery_mappping_size');
    // });

    Route::group(['namespace'=>'Brand'],function(){
        Route::get('new-brand', 'BrandController@showBrandForm')->name('admin.new_brand');
        Route::post('add-brand', 'BrandController@addBrand')->name('admin.add_brand');
        Route::get('all-brand', 'BrandController@allBrand')->name('admin.all_brand');
        Route::get('edit-brand/{brand_id}', 'BrandController@showEditBrandForm')->name('admin.edit_brand');
        Route::post('update-brand/{brand_id}', 'BrandController@updateBrand')->name('admin.update_brand');
    });

    // Route::group(['namespace'=>'GroceryBrand'],function(){
    //     Route::get('grocery-new-brand', 'GroceryBrandController@showGroceryBrandForm')->name('admin.grocery_new_brand');
    //     Route::put('add-grocery-brand', 'GroceryBrandController@addGroceryBrand')->name('admin.add_grocery_brand');
    //     Route::get('all-grocery-brand', 'GroceryBrandController@allGroceryBrand')->name('admin.all_grocery_brand');
    //     Route::get('edit-grocery-brand/{grocery_brand_id}', 'GroceryBrandController@showGroceryEditBrandForm')->name('admin.grocery_edit_brand');
    //      Route::put('update-grocery-brand/{grocery_brand_id}', 'GroceryBrandController@updateGroceryBrand')->name('admin.update_grocery_brand');
    // });

    // Route::group(['namespace'=>'GroceryProduct'],function(){
        
    //      Route::get('new-grocery-product', 'GrocerProductController@showGroceryProductForm')->name('admin.new_grocery_product');
          
    //       Route::put('add-grocery-product', 'GrocerProductController@addGroceryProduct')->name('admin.add_grocery_product');

    //       Route::get('grocery-product-stock-entry/{product_id}', 'GrocerProductController@groceryProductStockAmountEntry')->name('admin.grocery_product_stock_entry');

    //        Route::post('add-grocery-amount-stock-entry/{product_id}', 'GrocerProductController@addGroceryStockEntry')->name('admin.add_grocery_amount_stock_entry');

    //          Route::get('grocery-product-list', 'GrocerProductController@groceryProductList')->name('admin.grocery_product_list');

    //          Route::get('grocery-product-list-data', 'GrocerProductController@groceryProductListData')->name('admin.grocery_product_list_data');
            
    //         Route::get('edit-grocery-prouduct-banner/{product_id}', 'GrocerProductController@showEditGroceryProductBanner')->name('admin.edit_grocery_product_banner');

    //         Route::put('update-grocery-prouduct-banner/{product_id}', 'GrocerProductController@updateGroceryProductBanner')->name('admin.update_grocery_product_banner');

    //         Route::get('additional-grocery-prouduct-image-list/{product_id}', 'GrocerProductController@showGroceryProductImageList')->name('admin.additional_grocery_product_image_list');

    //         Route::put('update-grocery-prouduct-additional-Image/{product_id}', 'GrocerProductController@updateGroceryProductAdditionalImage')->name('admin.update_grocery_product_additional_image');
    // });

    Route::group(['namespace'=>'Product'],function(){

        /** New Product **/
        Route::get('new-product', 'ProductController@showProductForm')->name('admin.new_product');
        Route::post('add-product', 'ProductController@addProduct')->name('admin.add_product');

        /** Products List **/
        Route::get('prouduct-list', 'ProductController@productList')->name('admin.product_list');
        Route::post('prouduct-list-data', 'ProductController@productListData')->name('admin.product_list_data');

        /** Product Status **/
        Route::get('update-product-status/{product_id}/{status}', 'ProductController@updateProductStatus')->name('admin.update_product_status');

        /** Product Additional Image **/
        Route::get('additional-prouduct-image-list/{product_id}', 'ProductController@showProductImageList')->name('admin.additional_product_image_list');
        Route::post('update-prouduct-additional-image/', 'ProductController@updateProductAdditionalImage')->name('admin.update_product_additional_image');
        
        Route::get('set/as/thumb/{id}/{banner}', 'ProductController@setAsThumb')->name('admin.set_as_thumb');
        Route::get('delete/thumb/{id}/{pId}', 'ProductController@deleteThumb')->name('admin.delete_thumb');


        /** Product View **/
        Route::get('view-product/{product_id}', 'ProductController@viewProduct')->name('admin.view_product');

        /** Edit Product **/
        Route::get('edit-product/{product_id}', 'ProductController@showEditProduct')->name('admin.edit_product');
        Route::put('update-product/{product_id}', 'ProductController@updateProduct')->name('admin.update_product');

        /** Product Stock Status **/
        Route::get('update-product-stock-status/{stock_id}/{status}', 'ProductController@updateProductStockStatus')->name('admin.update_product_stock_status');

        /** Delete Product **/
        Route::get('delete-product/{product_id}', 'ProductController@deleteProduct')->name('admin.delete_product');

        /** Product Color Status **/
        Route::get('update-product-color-status/{color_id}/{status}', 'ProductController@updateProductColorStatus')->name('admin.update_product_color_status');

        /** Active and In-Active Products List **/
        Route::get('active-prouduct-list', 'ProductController@activeProductList')->name('admin.active_product_list');
        Route::get('in-active-prouduct-list', 'ProductController@inactiveProductList')->name('admin.in_active_product_list');
        Route::post('active-in-active-prouduct-list-data', 'ProductController@activeInactiveProductListData')->name('admin.active_in_active_product_list_data');

        /** Ajax Route **/
        Route::post('retrive-sub-category', 'ProductController@retriveSubCategory');
        Route::post('retrive-third-level-sub-category', 'ProductController@retriveThirdLevelSubCategory');
        Route::post('retrive-brand', 'ProductController@retriveBrand');

       Route::post('retrive-grocery-sub-category', 'ProductController@retriveGrocerySubCategory');
        Route::post('retrive-grocery-size','ProductController@retriveGrocerySize');
    });

    Route::group(['namespace'=>'Users'],function(){

        /** Users List **/
        Route::get('users-list', 'UsersController@usersList')->name('admin.users_list');

        /** Ajax User Datatable **/
        Route::post('users-list-data', 'UsersController@usersListData')->name('admin.users_list_data');

        /** User Profile **/
        Route::get('users-profile/{user_id}', 'UsersController@usersProfile')->name('admin.users_profile');
    });

    Route::group(['namespace'=>'Orders'],function(){

        /** New Orders List **/
        Route::get('new-orders-list', 'OrdersController@newOrdersList')->name('admin.new_orders_list');

        /** Out for Delivery Orders List **/
        Route::get('out-for-delivery-orders-list', 'OrdersController@outForDeliveryOrdersList')->name('admin.out_for_delivery_orders_list');

        /** Delivered Orders List **/
        Route::get('delivered-orders-list', 'OrdersController@deliveredOrdersList')->name('admin.delivered_orders_list');

        /** Delivered Orders List **/
        Route::get('canceled-orders-list', 'OrdersController@canceledOrdersList')->name('admin.canceled_orders_list');

        /** User Order History List **/
        Route::get('users-orders-history-list/{user_id}', 'OrdersController@usersOrdersHistoryList')->name('admin.users_orders_history_list');

        /** Ajax Order Datatable **/
        Route::post('orders-list-data', 'OrdersController@ordersListData')->name('admin.orders_list_data');
        Route::post('orders-history-list-data', 'OrdersController@ordersHistoryListData')->name('admin.orders_history_list_data');

        /** View Order Details **/
        Route::get('order-detail/{order_id}', 'OrdersController@orderDetail')->name('admin.order_detail');

        /** Invoice **/
        Route::get('invoice/{order_id}', 'OrdersController@invoice')->name('admin.invoice');

        /** Order Status Update **/
        Route::get('order-status-update/{order_id}/{status}', 'OrdersController@orderStatusUpdate')->name('admin.order_status_update');
    });

    Route::group(['prefix'=>'charges'],function(){
        Route::get('list','ConfigurationController@chargesList')->name('admin.charges_list');
        Route::get('edit/{id}', 'ConfigurationController@chargesEdit')->name('admin.charges_edit');
        Route::post('update/{id}', 'ConfigurationController@chargesUpdate')->name('admin.charges_update');
        
    });

    Route::group(['prefix'=>'coupon'],function(){
        Route::get('list','ConfigurationController@couponList')->name('admin.coupon_list');
        Route::get('add/form','ConfigurationController@addCoupon')->name('admin.coupon_add_form');
        Route::post('insert/form', 'ConfigurationController@couponInsertForm')->name('admin.coupon_insert_form');
        Route::get('edit/{id}', 'ConfigurationController@couponEdit')->name('admin.coupon_edit');
        Route::put('update/{id}', 'ConfigurationController@couponUpdate')->name('admin.coupon_update');
        Route::get('status/{id}/{status}', 'ConfigurationController@couponStatus')->name('admin.coupon_status');
    });
    // Route::group(['namespace'=>'Review'],function(){

    //     /** New Reviews List **/
    //     Route::get('new-reviews-list', 'ReviewController@newReviewList')->name('admin.new_reviews_list');

    //     /** Verified Reviews List **/
    //     Route::get('verified-reviews-list', 'ReviewController@verifiedReviewList')->name('admin.verified_reviews_list');

    //     /** Ajax Order Datatable **/
    //     Route::post('reviews-list-data', 'ReviewController@reviewsListData')->name('admin.reviews_list_data');
    //     // Route::post('orders-history-list-data', 'OrdersController@ordersHistoryListData')->name('admin.orders_history_list_data');

    //     /** Verified Review **/
    //     Route::get('verified-review/{user_id}/{product_id}', 'ReviewController@verifiedReview')->name('admin.verified_review');

    //     /** Delete Review **/
    //     Route::get('delete-review/{user_id}/{product_id}', 'ReviewController@deleteReview')->name('admin.delete_review');

    //     /** Invoice **/
    //     // Route::get('invoice/{order_id}', 'OrdersController@invoice')->name('admin.invoice');

    //     /** Order Status Update **/
    //     // Route::get('order-status-update/{order_id}/{status}', 'OrdersController@orderStatusUpdate')->name('admin.order_status_update');
    // });
});
