@extends('admin.layout.app')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Loại tin
                    <small>Danh sách</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            @include('admin.layout.messages')
            
            <?php
                $source = "upload/slide/1.jpg";
                $image = imagecreatefromjpeg($source);

                $output = "upload/slide/text_img.jpg";

                $white = imagecolorallocate($image, 255, 255, 255);
                $black = imagecolorallocate($image, 0, 0, 0);

                $font = public_path().'\upload\DoHyeon.ttf';
                $text = "Vinh web";

                $text1= imagettftext($image, 150, 0, 120, 150, $black, $font, $text);
                $text1= imagettftext($image, 150, 0, 122, 150, $white, $font, $text);

                imagejpeg($image, $output, 99);
            ?>

            <img width="500px" src="{{$output}}" alt="">
            
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr align="center">
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Tên không dấu</th>
                        <th>Thể loại</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loaitin as $lt)
                        <tr class="odd gradeX" align="center">
                            <td>{{$lt->id}} </td>
                            <td>{{$lt->Ten}} </td>
                            <td>{{$lt->TenKhongDau}} </td>
                            <td>{{$lt->theloai->Ten}} </td>
                            <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/loaitin/xoa/{{$lt->id}}">Xóa</a></td>
                            <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="admin/loaitin/sua/{{$lt->id}}">Sửa</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection