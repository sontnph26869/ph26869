<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class VouchersController extends Controller
{
    public function vouchers(Request $request)
    {
        $vouchers = Voucher::query();
        if ($request->has('trangthai')) {
            if ($request->input('trangthai') == 'saphethan') {
                $vouchers = Voucher::where('end_date', '>=', now())
                    ->orderBy('end_date', 'asc')
                    ->orderByRaw('end_date - NOW() ASC')
                    ->paginate(5);
                $vouchers1 = $vouchers;
            } elseif ($request->input('trangthai') == 'moi') {


                $vouchers1 = $vouchers->latest()->paginate(5);
            }
        }else {
            $vouchers1 = $vouchers->latest()->paginate(5);
        }
        if ($request->has('giamgia')) {
            if ($request->input('giamgia') == 'theophantram') {
                $vouchers = Voucher::where('type', '=', 2)
                    ->paginate(5);
                $vouchers1 = $vouchers;
            } elseif ($request->input('giamgia') == 'theogia') {
                $vouchers = Voucher::where('type', '=', 1)
                ->paginate(5);
            $vouchers1 = $vouchers;
            }
        }


        return view('client.vouchers.vouchers-list', compact('vouchers1'));
    }

    public function detailVouchers($id)
    {
        $vouchers = Voucher::query();
        $vouchers1 =    $vouchers->find($id);

        return view('client.vouchers.vouchers-detail', compact('vouchers1'));
    }

    public function apllyVouchers(Request $request){
        $voucher=Voucher::where('code',$request->code)->first();

        // if (session()->has('voucher')) {
        //     toastr()->warning('Bạn đã áp dụng một mã giảm giá rồi.');
        //     return back();
        // }

        if (!$voucher) {
            toastr()->error('Mã giảm giá không tồn tại');
            return back();
        }
        $now = Carbon::now();
        if ($now->isBefore($voucher->start_date)) {
            toastr()->error('Mã giảm giá chưa đến ngày sử dụng');
            return back();
        } elseif ($now->isAfter($voucher->end_date)) {
            toastr()->error('Mã giảm giá đã hết hạn');
            return back();
        }
        if ($voucher->status == 2) {
            toastr()->error('Mã giảm giá không hoạt động');
            return back();
        }
        if ($voucher->quantity == 0) {
            toastr()->error('Mã giảm giá đã hết lượt sử dụng');
            return back();
        }

        $totalPrice = $request->totalPrice;
        $discount = 0;
        $totalPriceVoucher = 0;

        if ($voucher->type == 1 && $voucher->min_order_amount == "" && $voucher->max_order_amount == "") {
            // Giảm tất cả hoá đơn theo %
            $discount = $totalPrice * ($voucher->value/100);
            $totalPriceVoucher = $totalPrice - $discount;
        } elseif (
            $voucher->type == 1 && $voucher->min_order_amount <= $totalPrice && $voucher->max_order_amount >= $totalPrice
            && $voucher->min_order_amount != "" && $voucher->max_order_amount != ""
        ) {
            // Giảm theo % đối với khoảng đơn hàng cụ thể
            $discount = $totalPrice * ($voucher->value/100);
            $totalPriceVoucher = $totalPrice - $discount;
        } elseif ($voucher->type == 1 && $voucher->min_order_amount <= $totalPrice && $voucher->max_order_amount == "") {
            // Giảm theo % đối với đơn hàng trên mức tối thiểu
            $discount = $totalPrice * ($voucher->value/100);
            $totalPriceVoucher = $totalPrice - $discount;
        } elseif ($voucher->type == 1 && $voucher->min_order_amount == "" && $voucher->max_order_amount >= $totalPrice) {
            // Giảm theo % đối với đơn hàng trên mức tối thiểu
            $discount = $totalPrice * ($voucher->value/100);
            $totalPriceVoucher = $totalPrice - $discount;
        } elseif ($voucher->type == 2 && $voucher->min_order_amount == "" && $voucher->max_order_amount == "") {
            // Giảm tất cả hoá đơn theo giá
            $discount = $voucher->value;
            $totalPriceVoucher = $totalPrice - $discount;
        } elseif ($voucher->type == 2 && $voucher->min_order_amount <= $totalPrice && $voucher->max_order_amount >= $totalPrice) {
            // Giảm theo giá đối với khoảng đơn hàng cụ thể
            $discount = $voucher->value;
            $totalPriceVoucher = $totalPrice - $discount;
        } elseif ($voucher->type == 2 && $voucher->min_order_amount <= $totalPrice && $voucher->max_order_amount == "") {
            // Giảm theo giá đối với đơn hàng trên mức tối thiểu
            $discount = $voucher->value;
            $totalPriceVoucher = $totalPrice - $discount;
        } elseif ($voucher->type == 2 && $voucher->min_order_amount == "" && $voucher->max_order_amount >= $totalPrice) {
            // Giảm theo giá đối với đơn hàng trên mức tối thiểu
            $discount = $voucher->value;
            $totalPriceVoucher = $totalPrice - $discount;
        } else {
            // Thông báo lỗi khi mã giảm giá không áp dụng
            if ($voucher->min_order_amount != "" && $voucher->max_order_amount != "") {
                $error = 'Mã giảm giá áp dụng cho đơn từ ' . number_format($voucher->min_order_amount, 0, ',', '.') . ' VNĐ' . ' đến ' . number_format($voucher->max_order_amount, 0, ',', '.') . ' VNĐ';
            } elseif ($voucher->min_order_amount != "") {
                $error = 'Mã giảm giá áp dụng cho đơn từ ' . number_format($voucher->min_order_amount, 0, ',', '.') . ' VNĐ';
            } elseif ($voucher->max_order_amount != "") {
                $error = 'Mã giảm giá áp dụng cho đơn không quá ' . number_format($voucher->max_order_amount, 0, ',', '.') . ' VNĐ';
            }
            toastr()->error($error);
            return back();
        }


        Session::put('voucher', [
            'code' => $voucher->code,
            'discount' => $discount,
            'totalPriceVoucher' => $totalPriceVoucher,
        ]);
        toastr()->success('Áp mã giảm giá thành công');
        return back();


    }
}
