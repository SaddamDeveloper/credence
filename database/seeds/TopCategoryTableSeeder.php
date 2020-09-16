<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TopCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('top_category')->insert([
        	[
            	'top_cate_name' => 'Apparel',
                'slug' => 'apparel',
            	'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
            	'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
	    	],	
	    	[
            	'top_cate_name' => 'Cosmetics',
                'slug' => 'cosmetics',
            	'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
            	'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
	    	],    
            [
                'top_cate_name' => 'Perfumeries',
                'slug' => 'perfumeries',
                'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
            ],  
            [
                'top_cate_name' => 'Krafts',
                'slug' => 'krafts',
                'created_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
                'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
            ]
		]);
    }
}
