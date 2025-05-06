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
                        <div class="number">245</div>
                        <div class="trend">+15 trong tháng này</div>
                    </div>
                    <div class="stat-card">
                        <h3>Lượt xem</h3>
                        <div class="number">15,245</div>
                        <div class="trend">+12% so với tháng trước</div>
                    </div>
                    <div class="stat-card">
                        <h3>Số lượng thành viên</h3>
                        <div class="number">1,256</div>
                        <div class="trend">+24 trong tuần này</div>
                    </div>
                    <div class="stat-card">
                        <h3>Bình luận mới</h3>
                        <div class="number">342</div>
                        <div class="trend down">-5% so với tuần trước</div>
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
                            <tr>
                                <td><img src="/api/placeholder/50/70" alt="Manga cover"></td>
                                <td>One Piece</td>
                                <td>Eiichiro Oda</td>
                                <td>12/04/2025</td>
                                <td>Đang cập nhật</td>
                            </tr>
                            <tr>
                                <td><img src="/api/placeholder/50/70" alt="Manga cover"></td>
                                <td>Naruto</td>
                                <td>Masashi Kishimoto</td>
                                <td>10/04/2025</td>
                                <td>Hoàn thành</td>
                            </tr>
                            <tr>
                                <td><img src="/api/placeholder/50/70" alt="Manga cover"></td>
                                <td>Bleach</td>
                                <td>Tite Kubo</td>
                                <td>08/04/2025</td>
                                <td>Hoàn thành</td>
                            </tr>
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