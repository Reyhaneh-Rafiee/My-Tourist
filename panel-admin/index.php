<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>پنل مدیریت</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.bundle.min.js"></script>
    <script>
        // نمایش پیام موفقیت
        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            const msg = urlParams.get('msg');
            
            if (msg === 'tour_added') {
                showMessage('تور با موفقیت افزوده شد!', 'success');
            } else if (msg === 'jazebe_added') {
                showMessage('جاذبه با موفقیت افزوده شد!', 'success');
            } else if (msg === 'deleted') {
                showMessage('آیتم با موفقیت حذف شد!', 'warning');
            }
            
            // حذف پارامتر msg از URL
            if (msg) {
                history.replaceState({}, document.title, window.location.pathname);
            }
            
            function showMessage(text, type) {
                const alertClass = type === 'success' ? 'alert-success' : 'alert-warning';
                const message = `
                    <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                        ${text}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                `;
                $('.col-10').prepend(message);
                
                // حذف خودکار پیام بعد از 5 ثانیه
                setTimeout(() => {
                    $('.alert').alert('close');
                }, 5000);
            }
        });
    </script>
</head>
<body>
<nav class="nav top-bar">
    <h2 class="float-right">پنل مدیریت</h2>
</nav>

<div class="container-fluid">
    <div class="row admin-panel">
        <div class="col-2">
            <div class="list-item">
                <a href="index.php">پیشخوان</a>
                <a href="../My-Tourist/index.html">مشاهده سایت</a>
                <a href="add-new-tour.html">تور جدید</a>
                <a href="orders.html">سفارشات تور</a>
                <a href="add-new-jazebe.html">جاذبه جدید</a>
                <a href="../php/logout.php">خروج</a>
            </div>
        </div>
        <div class="col-10">
            <!-- لیست تورها -->
            <div class="card mb-3">
                <div class="card-header">
                    لیست تورها
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table float-right" style="direction: rtl">
                            <thead>
                                <tr>
                                    <th>ردیف</th>
                                    <th>تصویر</th>
                                    <th>عنوان</th>
                                    <th>قیمت</th>
                                    <th>توضیحات</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody id="tours-table">
                                <!-- داده‌ها با AJAX لود می‌شوند -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- لیست جاذبه‌ها -->
            <div class="card mb-3">
                <div class="card-header">
                    لیست جاذبه‌ها
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table float-right" style="direction: rtl">
                            <thead>
                                <tr>
                                    <th>ردیف</th>
                                    <th>تصویر</th>
                                    <th>عنوان</th>
                                    <th>توضیحات</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody id="jazebe-table">
                                <!-- داده‌ها با AJAX لود می‌شوند -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- آمار -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-white bg-primary">
                        <div class="card-body text-center">
                            <h4 id="tours-count">0</h4>
                            <p>تعداد تورها</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success">
                        <div class="card-body text-center">
                            <h4 id="jazebe-count">0</h4>
                            <p>تعداد جاذبه‌ها</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-warning">
                        <div class="card-body text-center">
                            <h4 id="orders-count">0</h4>
                            <p>تعداد سفارشات</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // لود تورها
    function loadTours() {
        $.ajax({
            url: '../php/get-tours.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                let html = '';
                data.forEach(function(tour, index) {
                    html += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${tour.image ? `<img src="../${tour.image}" width="100px" height="70px">` : 'بدون تصویر'}</td>
                            <td>${tour.title}</td>
                            <td>${formatNumber(tour.price)} تومان</td>
                            <td>${tour.description.substring(0, 50)}...</td>
                            <td>
                                <a href="../php/delete.php?type=tour&id=${tour.id}" class="btn btn-danger btn-sm" onclick="return confirm('آیا مطمئن هستید؟')">حذف</a>
                            </td>
                        </tr>
                    `;
                });
                $('#tours-table').html(html);
                $('#tours-count').text(data.length);
            }
        });
    }
    
    // لود جاذبه‌ها
    function loadJazebe() {
        $.ajax({
            url: '../php/get-jazebe.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                let html = '';
                data.forEach(function(jazebe, index) {
                    html += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${jazebe.image ? `<img src="../${jazebe.image}" width="100px" height="70px">` : 'بدون تصویر'}</td>
                            <td>${jazebe.title}</td>
                            <td>${jazebe.description.substring(0, 50)}...</td>
                            <td>
                                <a href="../php/delete.php?type=jazebe&id=${jazebe.id}" class="btn btn-danger btn-sm" onclick="return confirm('آیا مطمئن هستید؟')">حذف</a>
                            </td>
                        </tr>
                    `;
                });
                $('#jazebe-table').html(html);
                $('#jazebe-count').text(data.length);
            }
        });
    }
    
    // لود آمار سفارشات
    function loadOrdersCount() {
        $.ajax({
            url: '../php/get-orders-count.php',
            type: 'GET',
            success: function(count) {
                $('#orders-count').text(count);
            }
        });
    }
    
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    
    // بارگذاری اولیه داده‌ها
    loadTours();
    loadJazebe();
    loadOrdersCount();
});
</script>
</body>
</html>