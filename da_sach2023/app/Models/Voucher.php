<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'vouchers';
    public $fillable = ['code', 'type', 'value', 'quantity', 'min_order_amount', 'max_order_amount', 'start_date', 'end_date', 'description', 'status'];

    public function checkAndSetStatus()
    {
        $now = Carbon::now();
        // Kiểm tra nếu ngày hiện tại vượt qua end_date
        if ($now > $this->end_date) {
            $this->status = 3; // Cập nhật trạng thái thành 3 (hết hạn)
            $this->save(); // Lưu thay đổi vào cơ sở dữ liệu
        }
        if ($this->quantity == 0) {
            $this->status = 4; // Cập nhật trạng thái thành 4 (hết vé)
            $this->save();
        }
    }
    public function checkAndUpdateStatus()
    {
        $now = Carbon::now();
        // Kiểm tra nếu ngày hiện tại vượt qua end_date
        if ($now > $this->end_date) {
            $this->status = 3; // Cập nhật trạng thái thành 3 (hết hạn)
            $this->save(); // Lưu thay đổi vào cơ sở dữ liệu
        }else{
            $this->status = 1;
            $this->save();
        }
        if ($this->quantity == 0) {
            $this->status = 4; // Cập nhật trạng thái thành 4 (hết vé)
            $this->save();
        }else{
            $this->status = 1;
            $this->save();
        }
    }
}
