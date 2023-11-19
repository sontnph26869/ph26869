<?php

namespace App\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\softDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;



class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'email',
        'password',
        'email',
        'gauth_id',
        'facebook_id',
        'password',
        'phone',
        'address',
        'gender',
        'avatar',
        'status',
        'email_verified_at',
        'remember_token',
        'created_at',
        'updated_at',
        'gauth_type',
        'gauth_token'
    ];
    public function order()
    {
        return $this->hasMany(OrderFood::class);
    }
    // User.php

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];




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
        } else {
            $this->status = 1;
            $this->save();
        }
        if ($this->quantity == 0) {
            $this->status = 4; // Cập nhật trạng thái thành 4 (hết vé)
            $this->save();
        } else {
            $this->status = 1;
            $this->save();
        }
    }
}
