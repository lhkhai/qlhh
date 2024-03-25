<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\carbon;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i<=50;$i++) //Sản phẩm
        {
            $dv = '';
            $chatlieu = '';
            $var = $i%7;
            switch($var)
            {
                case 0 : $chatlieu = "Vải Jeans";
                break;
                case 1 : $chatlieu = "Vải Silk";
                break;
                case 2 : $chatlieu = "Vải Cotton";
                break;
                case 3 : $chatlieu = "Vải Kaki";
                break;
                case 4 : $chatlieu = "Vãi len";
                break;
                case 5 : $chatlieu = "Vãi Đũi";
                break;
                case 6 : $chatlieu = "Vãi Thun";
                break;
            }
            if($i%3==0) {$dv='cái';}
            else {$dv = 'bộ';}
            \DB::table("products")->insert(['masp'=>"MASP".sprintf("%03d", $i),
                                        'tensp'=>"Sản phẩm ".$i,
                                        'chatlieu'=>$chatlieu,
                                        'kichthuoc'=>rand(1,15),
                                        'donvi'=>$dv,
                                        'hinhanh'=>'["img ('.$i.').jpg"]',
                                        'categories_id'=>rand(1,5)
                
            ]);
        }
    }
}
