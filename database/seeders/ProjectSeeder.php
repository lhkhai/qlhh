<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\carbon;
class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0;$i<=10;$i++) //Nhóm sản phẩm
        {
            \DB::table('categories')->insert(['manhom'=> \Str::random(15),'tennhom'=> 'Nhóm sản phẩm '.$i,
            'diengiai'=> 'Diễn giải '.$i]);
        }
        for($i=1;$i<=10;$i++){ //Khách hàng
            \DB::table('customers')->insert(['makh'=>'MAKH'.$i,'tenkh'=>'Khách hàng thứ '.$i,'diachi'=>'Số '.$i. 'Ninh Kiều, Cần Thơ ',
            'sdt'=>'0'.rand(2,9).rand(00000000,99999999),'email'=>'emailkhachhang'.$i.'@gmail.com','created_at'=>Carbon::now()]);
            }
        for($i=0;$i<=10;$i++) //nhà cung cấp
            {
                \DB::table('suppliers')->insert(['mancc'=> "NCC".$i,'tenncc'=> 'Nhà Cung cấp '.$i,
                'diachincc'=> 'Địa chỉ nhà cung cấp '.$i,'sdtncc'=> '09'.rand(000000000,99999999),'emailncc'=>'emailnhacungcap'.$i."@gmail.com",
                'ttthanhtoan'=> 'Phương thức, thông tin thanh toán của nhà cung cấp','ghichu'=>"Ghi chú NCC",'created_at'=> Carbon::now()]);
        }
        \DB::table('staff')->insert(['id'=>1,
                                    'manv'=>'NTHP',
                                    'hoten'=>'Nguyễn Thị Hồng Phượng',
                                    'ngaysinh'=>'2000-01-01',
                                    'diachi'=>"Ninh Kiều, Cần Thơ",
                                    'sdt'=>'0939123123',
                                    'trinhdo'=>'Cao Đẳng',
                                    'mucluong'=>5000000,
                                    'loaihd'=>'Chính thức']);
        \DB::table('promotiontypes')->insert([
                                        'id'=>1,
                                        'maloaikm'=>'promotioninvoice',
                                        'tenloaikm'=>"Khuyến mãi theo trị giá hóa đơn"
        ]);
        \DB::table('promotiontypes')->insert([
                                        'id'=>2,
                                        'maloaikm'=>'promotioninvoice',
                                        'tenloaikm'=>"Khuyến mãi theo trị giá hóa đơn"
                                    ]);                            
    }

   
     
    
    
}
