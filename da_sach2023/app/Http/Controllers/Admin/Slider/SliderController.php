<?php

namespace App\Http\Controllers\Admin\Slider;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SliderRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $query = Slider::query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('alt_text', 'like', '%' . $search . '%');
        }
        //lấy tất dữ liệu trong bảng post
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status != 0) {
                $query->where('status', $status);
            }
        }
        $slider1=$query->paginate(3);
        return view('admin.sliders.index',compact('slider1'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SliderRequest $request)
    {
        try {
            $model = new Slider();
       
            $model->fill($request->all());
            // Initialize an empty array to store image paths
            $imageURLs = [];
            if ($request->hasFile('images_url')) {
                $images = $request->file('images_url');
    
                foreach ($images as $image) {
                    $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                    $path = 'storage/' . Storage::putFileAs('public', $image, $filename);
                    $imageURLs[] = $path;
                }
                $model->image_url = json_encode($imageURLs);
            }
            $model->save();
            // dd($model);
            toastr()->success('Thêm ảnh thành công!', 'success');
            return redirect()->route('slider.index');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] === 1062) { // Lỗi duplicate entry
                return redirect()->back()->withErrors(['slug' => 'Slug đã bị trùng lặp. Vui lòng sửa đường dẫn']);
            }
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data=Slider::find($id);
        return view('admin.sliders.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data=Slider::find($id);
        return view('admin.sliders.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SliderRequest $request, $id)
    {
        //
        try {
            $model = Slider::find($id);
            $model->fill($request->all());
            // Initialize an empty array to store image paths
            $imageURLs = [];
            if ($request->hasFile('images_url')) {
                $images = $request->file('images_url');
    
                foreach ($images as $image) {
                    $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                    $path = 'storage/' . Storage::putFileAs('public', $image, $filename);
                    //xóa ở đâu file /này a
                    //khomg
                    $imageURLs[] = $path;
                }
                $model->image_url = json_encode($imageURLs);
            }
            $model->save();
            toastr()->success('Thêm ảnh thành công!', 'success');
            return redirect()->route('slider.index');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] === 1062) { // Lỗi duplicate entry
                return redirect()->back()->withErrors(['slug' => 'Slug đã bị trùng lặp. Vui lòng sửa đường dẫn']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //xóa dữ liệu 
        // dd($id);
      
        try {
            $data=Slider::find($id);
            $data->delete();
            toastr()->success(' Xóa ảnh  thành công!', 'success');
            return redirect()->route('slider.index');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] === 1062) { // Lỗi duplicate entry
                return redirect()->back()->withErrors(['slug' => 'Slug đã bị trùng lặp.Vui lòng sửa đường dẫn']);
            }
        }
    }
        public function trash()
            {
                $trashedPosts = Slider::onlyTrashed()->get();
                return view('admin.sliders.trash', compact('trashedPosts'));
            }
            public function restore($id)
            {
                $post = Slider::withTrashed()->find($id);
                $post->restore();
                toastr()->success(' Khôi phục ảnh  thành công!', 'success');
                return redirect()->route('slider.trash');
            }
            public function forceDelete($id)
            {
                $post = Slider::withTrashed()->find($id);
                $post->forceDelete();
                toastr()->success(' Xóa ảnh  thành công!', 'success');
                return redirect()->route('slider.trash');
            }

            public function updateStatus(Request $request, $id) {
                $item = Slider::find($id);
        
                if (!$item) {
                    return response()->json(['message' => 'Không tìm thấy mục'], 404);
                }
                $newStatus = $request->input('status');
                $item->status = $newStatus;
                $item->save();
        
                return response()->json(['message' => 'Cập nhật trạng thái thành công'], 200);
            }

            public function deleteAll(Request $request)
            {
                $ids = $request->ids;
                if ($ids) {
                    Slider::whereIn('id', $ids)->delete();
                    toastr()->success( 'Thành công xoá các slider đã chọn');
                } else {
                    toastr()->warning( 'Không tìm thấy các slider đã chọn');
                }
            }
        
        
            public function permanentlyDeleteSelected(Request $request)
            {
                $ids = $request->ids;
                if ($ids) {
                    $model = Slider::withTrashed()->whereIn('id', $ids);
                    $model->forceDelete();
                    toastr()->success('Thành công', 'Thành công xoá vĩnh viễn slider');
        
                } else {
                    toastr()->warning('Thất bại', 'Không tìm thấy các slider đã chọn');
                }
                return redirect()->route('slider.trash');
            }
        
            public function restoreSelected(Request $request)
            {
                $ids = $request->ids;
                if ($ids) {
                    $model = Slider::withTrashed()->whereIn('id', $ids);
                    $model->restore();
                    toastr()->success('Thành công', 'Thành công khôi phục slider');
                } else {
                    toastr()->warning('Thất bại', 'Không tìm thấy các slider đã chọn');
                }
                return redirect()->route('slider.trash');
            }

}
