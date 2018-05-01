@extends('admin.layout.app')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">User
                    <small>{{$user->name}} </small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-7" style="padding-bottom:120px">
                @include('admin.layout.messages')

                <form action="admin/user/sua/{{$user->id}}" method="POST">
                    <input type="hidden" name="_token" value="{{csrf_token()}}" >
                    <div class="form-group">
                        <label>Họ tên</label>
                        <input class="form-control" name="name" placeholder="Nhập tên người dùng" value="{{$user->name}}" />
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input readonly="readonly" type="email" class="form-control" name="email" placeholder="Nhập email" value="{{$user->email}}" />
                    </div>
                    <div class="form-group">
                        <input id="changePassword" type="checkbox" name="changePassword">
                        <label>Đổi password</label>
                        <input disabled type="password" class="form-control password" name="password" placeholder="Nhập mật khẩu" />
                    </div>
                    <div class="form-group">
                        <label>Nhập lại Password</label>
                        <input disabled type="password" class="form-control password" name="passwordAgain" placeholder="Nhập lại mật khẩu" />
                    </div>
                    <div class="form-group">
                        <label>Quyền người dùng</label>
                        <label for="" class="radio-inline">
                            <input 
                                @if($user->quyen == 0)
                                {{"checked"}}
                                @endif
                                type="radio" name="quyen" value="0">Thường
                        </label>
                        <label for="" class="radio-inline">
                            <input 
                                @if($user->quyen == 1)
                                {{"checked"}}
                                @endif
                                type="radio" name="quyen" value="1">Admin
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">Sửa</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                </form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('#changePassword').change(function(){
                if($(this).is(':checked')){
                    $('.password').removeAttr('disabled');
                }else{
                    $('.password').attr('disabled', '');
                }
            });
        });
    </script>
@endsection