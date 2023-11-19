<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Quản lý
    </div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#movie" aria-expanded="true"
            aria-controls="movie">

            <i class="fa-solid fa-film"></i>

            <span>Quản lý sách</span>
        </a>
        <div id="movie" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('genre.index') }}">Thể loại </a>
                <!-- link -->
                <a class="collapse-item" href="{{ route('book.index') }}">Danh sách sach</a>
            </div>
        </div>
    </li>
   
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#magiamgia"
            aria-expanded="false" aria-controls="magiamgia">

            <i class="fa-solid fa-ticket"></i>
            <span>Quản lý mã giảm giá</span>
        </a>
        <div id="magiamgia" class="collapse" aria-labelledby="headingVoucher" data-parent="#accordionSidebar" style="">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('voucher.index') }}">Danh sách mã giảm giá</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="false" aria-controls="collapseUtilities">

            <i class="fa-solid fa-blog"></i>

            <span>Quản lý bài viết</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingPost" data-parent="#accordionSidebar" style="">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('post-type.index') }}">Danh mục bài viết</a>
                <a class="collapse-item" href="{{ route('post.index') }}">Bài viết</a>
                <a class="collapse-item" href="{{ route('comment.index') }}">Bình luận bài viết</a>
                <a class="collapse-item" href="{{ route('reply.index') }}"> Trả lời bình luận </a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#room" aria-expanded="true" aria-controls="room">
            <i class="fas fa-fw fa-folder"></i>
            <span>Quản lý hóa đơn</span>
        </a>
        <div id="room" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('order.index')}}">Hóa đơn</a>
           
            </div>
        </div>
    </li>
    <!-- logo -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#logo-slider" aria-expanded="true" aria-controls="logo-slider">

            <i class="fa-solid fa-sliders"></i>
            <span>Logo & Slider</span>

        </a>
        <div id="logo-slider" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('logo.edit', 1) }}">Logo</a>
                <a class="collapse-item" href="{{ route('slider.index') }}">Slider</a>

            </div>
        </div>
    </li>

    <!-- end logo -->

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoabc" aria-expanded="true" aria-controls="collapseTwoabc">
            <i class="fa-solid fa-user"></i>

            <span>Quản lý người dùng</span>
        </a>
        <div id="collapseTwoabc" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('user.index') }}">Danh sách người dùng</a>
                <a class="collapse-item" href="{{ route('role.list') }}">Quản lý vai trò</a>
                <a class="collapse-item" href="{{ route('permission.list') }}">Quản lý quyền</a>
                <!-- link -->
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Cài đặt hệ thống
    </div>



</ul>