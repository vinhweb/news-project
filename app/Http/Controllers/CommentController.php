<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\TinTuc;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    public function getXoa($id, $idTinTuc){
        $comment = Comment::find($id);
        $comment->delete();

        return redirect('admin/tintuc/sua/'.$idTinTuc)->with('thongbao', 'Xóa thành công');
    }

    public function postComment($id, Request $request){
        $idTinTuc = $id;
        $tintuc = TinTuc::find($id); 

        $comment = new Comment;
        $comment->idTinTuc = $id;
        $comment->idUser = Auth::user()->id;
        $comment->NoiDung = $request->NoiDung;
        $comment->save();

        return redirect('tintuc/'.$id.'/'.$tintuc->TieuDeKhongDau.'.html')
            ->with('thongbao', 'Bình luận thành công!');
    }
}
