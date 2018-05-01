<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\LoaiTin;
use App\TinTuc;
use App\Comment;

class TinTucController extends Controller
{
    public function getDanhSach(){
        $tintuc = TinTuc::orderBy('id', 'desc')->get();
        return view('admin.tintuc.danhsach', ['tintuc' => $tintuc]);
    }

    public function getThem(){
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
        return view('admin.tintuc.them')
            ->with('theloai', $theloai)
            ->with('loaitin', $loaitin);
    }

    public function postThem(Request $request){
        $this->validate($request, [
            'LoaiTin' => 'required',
            'TieuDe' => 'required|unique:TinTuc,TieuDe|min:3|max:100',
            'TomTat' => 'required',
            'NoiDung' => 'required',
        ],
        [
            'LoaiTin.required' => 'Bạn chưa nhập loại tin',
            'TomTat.required' => 'Bạn chưa nhập tóm tắt',
            'NoiDung.required' => 'Bạn chưa nhập nội dung',
            'TieuDe.required' => 'Bạn chưa nhập tên thể loại',
            'TieuDe.unique' => 'Tên thể loại đã tồn tại',
            'TieuDe.min' => 'Tên thể loại phải có độ dài từ 3 - 100 ký tự',
            'TieuDe.max' => 'Tên thể loại phải có độ dài từ 3 - 100 ký tự',
        ]);

        $tintuc = new TinTuc;
        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TomTat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;
        $tintuc->SoLuotXem = 0;

        if($request->hasFile('Hinh')){
            $file = $request->file('Hinh');
            
            $duoi = $file->getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi != 'png'){

            }

            $name = $file->getClientOriginalName();
            $Hinh = str_random(4)."_".$name;
            while(file_exists("upload/tintuc/".$Hinh)){
                $Hinh = str_random(4)."_".$name;
            }

            $file->move('upload/tintuc', $Hinh);
            $tintuc->Hinh = $Hinh;
        }else{
            $tintuc->Hinh = "";
        }

        $tintuc->save();

        return redirect('admin/tintuc/them')->with('thongbao', 'Thêm thành công!');
    }

    public function getSua($id){
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
        $tintuc = TinTuc::find($id);

        return view('admin.tintuc.sua')
            ->with('tintuc', $tintuc)
            ->with('theloai', $theloai)
            ->with('loaitin', $loaitin);
    }

    public function postSua(Request $request, $id){

        $this->validate($request, [
            'LoaiTin' => 'required',
            'TieuDe' => 'required|unique:TinTuc,TieuDe|min:3|max:100',
            'TomTat' => 'required',
            'NoiDung' => 'required',
        ],
        [
            'LoaiTin.required' => 'Bạn chưa nhập loại tin',
            'TomTat.required' => 'Bạn chưa nhập tóm tắt',
            'NoiDung.required' => 'Bạn chưa nhập nội dung',
            'TieuDe.required' => 'Bạn chưa nhập tên thể loại',
            'TieuDe.unique' => 'Tiêu đề đã tồn tại',
            'TieuDe.min' => 'Tên thể loại phải có độ dài từ 3 - 100 ký tự',
            'TieuDe.max' => 'Tên thể loại phải có độ dài từ 3 - 100 ký tự',
        ]);

        $tintuc = TinTuc::find($id);
        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TomTat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;
        $tintuc->SoLuotXem = 0;

        if($request->hasFile('Hinh')){
            $file = $request->file('Hinh');
            
            $duoi = $file->getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi != 'png'){

            }

            $name = $file->getClientOriginalName();
            $Hinh = str_random(4)."_".$name;
            while(file_exists("upload/tintuc/".$Hinh)){
                $Hinh = str_random(4)."_".$name;
            }
            
            $file->move('upload/tintuc', $Hinh);
            unlink("upload/tintuc/".$tintuc->Hinh);
            $tintuc->Hinh = $Hinh;
        }

        $tintuc->save();

        return redirect('admin/tintuc/sua/'.$id)->with('thongbao', 'Sửa thành công');
    }

    public function getXoa($id){
        $tintuc = TinTuc::find($id);
        $tintuc->delete();
        
        return redirect('admin/tintuc/danhsach')->with('thongbao', 'Xóa thành công') ;
    }
}
