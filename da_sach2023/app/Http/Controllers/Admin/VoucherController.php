<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Voucher\StoreRequest;
use App\Http\Requests\VoucherRequest;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index(Request $request)
    {
        $query = Voucher::query();

        // Tìm kiếm theo name
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('code', 'like', '%' . $search . '%');
        }
        // Lọc theo status
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status != 0) {
                $query->where('status', $status);
            }
        }
        $vouchers = $query->orderBy('id', 'DESC')->paginate(5);
        foreach ($vouchers as $voucher) {
            $voucher->checkAndSetStatus();
        }
        return view('admin.voucher.index', [
            'vouchers' => $vouchers
        ]);
    }



    public function store(VoucherRequest $request)
    {
        if ($request->isMethod('POST')) {
            $voucher = new Voucher();
            $voucher->code = $request->code;
            $voucher->type = $request->type;
            $voucher->value = $request->value ;
            $voucher->quantity = $request->quantity;
            $voucher->min_order_amount = $request->min_order_amount;
            $voucher->max_order_amount = $request->max_order_amount;
            $voucher->start_date = $request->start_date;
            $voucher->end_date = $request->end_date;
            $voucher->description = $request->description;
            $voucher->save();
            if ($voucher->id) {
                toastr()->success('Thành công thêm mới mã giảm giá');
                return redirect()->back();
            }
        }
        return view('admin.voucher.add');
    }


    public function show($id)
    {
        //
    }

    public function update(VoucherRequest $request, $id)
    {
        $voucher = Voucher::find($id);
        if ($request->isMethod('POST')) {
            $voucher->code = $request->code;
            $voucher->type = $request->type;
            $voucher->value = $request->value ;
            $voucher->quantity = $request->quantity;
            $voucher->min_order_amount = $request->min_order_amount;
            $voucher->max_order_amount = $request->max_order_amount;
            $voucher->start_date = $request->start_date;
            $voucher->end_date = $request->end_date;
            $voucher->description = $request->description;
            $voucher->save();
            $voucher->checkAndUpdateStatus();
            toastr()->success('Thành công chỉnh sửa mã giảm giá');
            return redirect()->back();

        }
        return view('admin.voucher.edit', [
            'voucher' => $voucher
        ]);
    }

    public function destroy($id)
    {
        $data = Voucher::find($id);
        $data->delete();
        toastr()->success('Thành công xoá mã giảm giá');
        return redirect()->back();
    }
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            Voucher::whereIn('id', $ids)->delete();
            toastr()->success( 'Thành công xoá các mã giảm giá đã chọn');
        } else {
            toastr()->warning( 'Không tìm thấy các mã giảm giá đã chọn');
        }
    }
    public function trash(Request $request)
    {
        $query = Voucher::onlyTrashed();

        // Tìm kiếm theo name trong trash
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('code', 'like', '%' . $search . '%');
        }
        // Lọc theo status trong trash
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status != 0) {
                $query->where('status', $status);
            }
        }

        $vouchers = $query->orderBy('id', 'DESC')->paginate(5);
        return view('admin.voucher.trash', [
            'vouchers' => $vouchers
        ]);
    }


    public function permanentlyDelete($id)
    {
        $voucher = Voucher::withTrashed()->findOrFail($id);
        $voucher->forceDelete();
        toastr()->success('Thành công', 'Thành công xoá vĩnh viễn mã giảm giá');
        return redirect()->route('voucher.trash');
    }
    public function permanentlyDeleteSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $voucher = Voucher::withTrashed()->whereIn('id', $ids);
            $voucher->forceDelete();
            toastr()->success('Thành công', 'Thành công xoá vĩnh viễn mã giảm giá');

        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các mã giảm giắ đã chọn');
        }
        return redirect()->route('voucher.trash');
    }

    public function restoreSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $voucher = Voucher::withTrashed()->whereIn('id', $ids);
            $voucher->restore();
            toastr()->success('Thành công', 'Thành công khôi phục mã giảm giắ');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các mã giảm giắ đã chọn');
        }
        return redirect()->route('voucher.trash');
    }
    public function restore( $id)
    {
        if ($id) {
            $voucher = Voucher::withTrashed()->findOrFail($id);
            $voucher->restore();
            toastr()->success('Thành công', 'Thành công khôi phục mã giảm giắ');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các mã giảm giắ đã chọn');
        }
        return redirect()->route('voucher.trash');
    }

    public function cleanupTrash()
    {
        $thirtyDaysAgo = Carbon::now()->subDays(1);
        Voucher::onlyTrashed()->where('deleted_at', '<', $thirtyDaysAgo)->forceDelete();
        return redirect()->route('index.voucher')->withSuccess('Đã xoá vĩnh viễn mã giảm giá trong thùng rác');
    }
    public function updateStatus(Request $request, $id) {
        $item = Voucher::find($id);

        if (!$item) {
            return response()->json(['message' => 'Không tìm thấy mục'], 404);
        }
        $newStatus = $request->input('status');
        $item->status = $newStatus;
        $item->save();

        return response()->json(['message' => 'Cập nhật trạng thái thành công'], 200);
    }
}
