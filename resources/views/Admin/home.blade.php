<!DOCTYPE html>
<html lang="en">
    <head>
        @include('admin.layouts.head')
    </head>
<body>
    <div class="container">
        <!-- Sidebar -->
        @include('admin.layouts.sidebar')

        <!-- Main Content -->
        <div class="main-content">
            @include('admin.layouts.header')
            <!-- Dashboard -->
            <div class="page-content active" id="dashboard">
                <h2>Dashboard</h2>
                <div class="dashboard">
                    <div class="stat-card">
                        <h3>Tổng số Manga</h3>
                        <div class="number">{{$manga_count}}</div>
                    </div>
                    <div class="stat-card">
                        <h3>Lượt xem</h3>
                        <div class="number">{{ $views }}</div>
                        <!-- <div class="trend">+12% so với tháng trước</div> -->
                    </div>
                    <div class="stat-card">
                        <h3>Số lượng thành viên</h3>
                        <div class="number">{{$user_count}}</div>
                    </div>
                    <div class="stat-card">
                        <h3>Bình luận</h3>
                        <div class="number">{{$comment_count}}</div>
                    </div>
                </div>

                <div class="content-section">
                    <div class="section-header">
                        <h3>Manga mới thêm gần đây</h3>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Ảnh bìa</th>
                                <th>Tên Manga</th>
                                <th>Tác giả</th>
                                <th>Ngày thêm</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($updatedMangas as $updatedManga)
                            <tr>
                                <td><img src="{{$updatedManga -> cover_image}}" alt="Manga cover"></td>
                                <td>{{$updatedManga -> title}}</td>
                                <td>{{$updatedManga -> author}}</td>
                                <td>{{$updatedManga -> created_at}}</td>
                                <td>{{$updatedManga -> status}}</td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
<footer>
    @include('admin.layouts.footer')
</footer>
</html>