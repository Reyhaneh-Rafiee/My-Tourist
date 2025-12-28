<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تورهای گردشگری ایران | گردشگر من</title>
    <link rel="icon" href="../images/icon33.png" type="image/ico"/>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* استایل‌های تورها */
        .tours-container {
            margin-top: 100px;
            margin-bottom: 50px;
            min-height: calc(100vh - 300px);
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 40px;
            padding: 30px 20px;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            border-radius: 15px;
            color: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .page-header h1 {
            font-size: 2.2rem;
            margin-bottom: 15px;
            font-weight: bold;
        }
        
        .page-header p {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.6;
        }
        
        /* استایل برای جستجو */
        .search-box {
            max-width: 600px;
            margin: 30px auto 40px;
        }
        
        .search-box .input-group {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 30px;
            overflow: hidden;
        }
        
        .search-box .form-control {
            border: none;
            padding: 12px 20px;
            font-size: 1rem;
        }
        
        .search-box .btn {
            padding: 12px 25px;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            border: none;
            border-radius: 0 30px 30px 0;
        }
        
        /* کارت تور */
        .tour-card {
            border: 1px solid #eaeaea;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            margin-bottom: 25px;
            height: 500px;
            display: flex;
            flex-direction: column;
        }
        
        .tour-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.15);
            border-color: #11998e;
        }
        
        /* کانتینر تصویر */
        .tour-img-container {
            height: 220px;
            overflow: hidden;
            flex-shrink: 0;
            position: relative;
        }
        
        .tour-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .tour-card:hover .tour-img {
            transform: scale(1.05);
        }
        
        /* برچسب قیمت */
        .price-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 1.1rem;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        }
        
        /* حالت بدون تصویر */
        .no-image {
            height: 220px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #6c757d;
        }
        
        .no-image i {
            font-size: 3rem;
            margin-bottom: 10px;
            opacity: 0.7;
        }
        
        /* بدنه کارت */
        .tour-body {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .tour-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 12px;
            line-height: 1.4;
            height: 60px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        
        .tour-description {
            color: #555;
            line-height: 1.6;
            font-size: 0.95rem;
            flex-grow: 1;
            overflow: hidden;
            position: relative;
        }
        
        .tour-description.truncate {
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        /* دکمه رزرو */
        .reserve-btn {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            margin-top: 15px;
            width: 100%;
            text-align: center;
            text-decoration: none;
            display: block;
        }
        
        .reserve-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(17, 153, 142, 0.3);
            color: white;
        }
        
        /* استایل برای وقتی توری وجود ندارد */
        .no-tours {
            text-align: center;
            padding: 60px 20px;
            background: #f8f9fa;
            border-radius: 12px;
            margin: 40px 0;
            border: 2px dashed #dee2e6;
        }
        
        .no-tours i {
            font-size: 4rem;
            color: #adb5bd;
            margin-bottom: 20px;
        }
        
        .no-tours h3 {
            color: #495057;
            margin-bottom: 15px;
        }
        
        .no-tours p {
            color: #6c757d;
            max-width: 500px;
            margin: 0 auto;
        }
        
        /* فیلترها */
        .filters {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        
        .filter-group {
            margin-bottom: 15px;
        }
        
        .filter-group label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 5px;
            display: block;
        }
        
        /* فوتر */
        footer {
            margin-top: 80px !important;
            padding-top: 40px;
            background: #2c3e50;
            color: white;
        }
    </style>
</head>

<body class="rtl">
    <!--------------------------- menu ------------------------------->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand">
                <img src="../images/icon33.png" alt="گردشگر من" width="80" height="70">
            </a>
            <a class="navbar-brand">گردشگر من</a>
            <span style="padding-left: 5px;"></span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.html">صفحه اصلی</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about-us.html">درباره ما</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="tours.php">تورها</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="jazebe.php">جاذبه ها</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="article.html">مقالات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">تماس با ما</a>
                    </li>
                </ul>
                <span style="padding-left: 200px;"></span>
                
                    </div>
                </form>
            </div>
        </div>
    </nav>

    <!-- محتوای اصلی صفحه تورها -->
    <div class="container tours-container">
        <!-- هدر صفحه -->
        <div class="page-header">
            <h1>تورهای گردشگری ایران</h1>
            <p>با بهترین تورهای داخلی ایران، سفری به یادماندنی را تجربه کنید</p>
        </div>
        
        <!-- بخش جستجو -->
        <div class="search-box">
            <div class="input-group">
                <input type="text" class="form-control" id="search-input" placeholder="جستجوی تورها...">
                <button class="btn btn-primary" id="search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <!-- نمایش تورها -->
        <div class="row" id="tours-list">
            <?php
            // اتصال به پایگاه داده
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "my_tourist_db";
            
            $conn = new mysqli($servername, $username, $password, $dbname);
            
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            // تنظیم کدگذاری UTF-8
            $conn->set_charset("utf8");
            
            // دریافت تورها از دیتابیس
            $sql = "SELECT * FROM tours ORDER BY `t_id` DESC";
            $result = $conn->query($sql);
            
            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // دریافت داده‌ها
                    $title = isset($row['title']) ? htmlspecialchars($row['title']) : 'بدون عنوان';
                    $description = isset($row['description']) ? htmlspecialchars($row['description']) : '';
                    $price = isset($row['price']) ? number_format($row['price']) : '0';
                    $image_path = isset($row['image_path']) ? $row['image_path'] : '';
                    $id = isset($row['t_id']) ? $row['t_id'] : 0;
                    
                    // محدود کردن توضیحات برای نمایش
                    $short_desc = strlen($description) > 200 ? 
                        substr($description, 0, 200) . "..." : 
                        $description;
                    
                    // نمایش کارت
                    echo '
                    <div class="col-lg-4 col-md-6 mb-4 tour-item">
                        <div class="card tour-card">
                            <div class="tour-img-container">';
                    
                    if (!empty($image_path) && file_exists("../" . $image_path)) {
                        echo '<img src="../' . $image_path . '" class="tour-img" alt="' . $title . '" onerror="this.onerror=null; this.src=\'../images/default-tour.jpg\';">';
                    } else {
                        echo '<div class="no-image">
                                <i class="fas fa-suitcase-rolling"></i>
                                <span>بدون تصویر</span>
                              </div>';
                    }
                    
                    echo '<div class="price-badge">' . $price . ' تومان</div>';
                    
                    echo '
                            </div>
                            <div class="tour-body">
                                <h3 class="tour-title" title="' . $title . '">' . $title . '</h3>
                                <div class="tour-description truncate" title="' . $description . '">' . $short_desc . '</div>
                                <a href="reserve-tour.php?id=' . $id . '" class="reserve-btn">
                                    <i class="fas fa-calendar-check"></i> رزرو این تور
                                </a>';
                    
                    echo '
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '
                <div class="col-12">
                    <div class="no-tours">
                        <i class="fas fa-suitcase-rolling"></i>
                        <h3>هنوز توری اضافه نشده است</h3>
                        <p>به زودی تورهای ویژه ایران را اینجا خواهید دید.</p>
                        <a href="../panel-admin/add-new-tour.html" class="btn btn-primary mt-3">افزودن تور جدید</a>
                    </div>
                </div>';
            }
            
            $conn->close();
            ?>
        </div>
    </div>

    <!----------------------------------footer--------------------------------->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <ul class="list-inline">
                        <img src="../images/socialmedia.png" height="200px" width="200px">
                        <p class="follow-us">ما را در شبکه های اجتماعی دنبال کنید</p>
                        <hr class="follow-us-line">
                        <li class="list-inline-item"><a class="social-icon"><i class="fab fa-whatsapp fa-lg"></i></a></li>
                        <li class="list-inline-item"><a class="social-icon"><i class="fab fa-telegram fa-lg"></i></a></li>
                        <li class="list-inline-item"><a class="social-icon"><i class="fab fa-instagram fa-lg"></i></a></li>
                        <li class="list-inline-item"><a class="social-icon email-icon"><i class="far fa-envelope fa-lg"></i></a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-3">
                    <h5>خدمات مشتریان</h5>
                    <ul class="list-unstyled">
                        <li><a href="FAQ.html">سوالات متداول</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-3">
                    <h5>لینک‌های مهم</h5>
                    <ul class="list-unstyled">
                        <li><a href="../index.html#services-section">خدمات ما</a></li>
                        <li><a href="about-us.html">درباره ما</a></li>
                        <li><a href="contact.html">تماس با ما</a></li>
                    </ul>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12 text-center">
                    <p>&copy;1404، تمامی حقوق برای گردشگرمن محفوظ می باشد.</p>
                </div>
            </div>
        </div>
    </footer>

    <!--------------------------------back to top page button------------------------>
    <a class="btn btn-primary btn-lg back-to-top" role="button">
        <i class="fas fa-chevron-up"></i>
    </a>

    <!-- مودال برای نمایش جزئیات تور -->
    <div class="modal fade" id="tourModal" tabindex="-1" aria-labelledby="tourModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tourModalLabel">جزئیات تور</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalTourContent">
                    <!-- محتوای مودال -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                    <a id="modalReserveLink" href="#">
                     <button type="button" class="btn btn-primary">رزرو تور</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/script.js"></script>
    
    <script>
    $(document).ready(function() {
        // جستجوی تورها
        $('#search-btn').click(searchTours);
        $('#search-input').keypress(function(e) {
            if (e.which == 13) searchTours();
        });
        
        function searchTours() {
            var searchTerm = $('#search-input').val().trim().toLowerCase();
            if (searchTerm) {
                $('.tour-item').each(function() {
                    var title = $(this).find('.tour-title').text().toLowerCase();
                    var desc = $(this).find('.tour-description').text().toLowerCase();
                    var price = $(this).find('.price-badge').text().toLowerCase();
                    
                    if (title.includes(searchTerm) || desc.includes(searchTerm) || price.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
                
                // اگر هیچ نتیجه‌ای یافت نشد
                if ($('.tour-item:visible').length === 0) {
                    // حذف هشدارهای قبلی
                    $('.search-alert').remove();
                    
                    $('#tours-list').prepend(`
                        <div class="col-12 search-alert">
                            <div class="alert alert-warning text-center">
                                <i class="fas fa-search"></i>
                                هیچ توری با عبارت "${$('#search-input').val()}" یافت نشد.
                                <button type="button" class="btn btn-sm btn-outline-warning ms-3" onclick="$('.tour-item').show(); $('.search-alert').remove();">
                                    نمایش همه تورها
                                </button>
                            </div>
                        </div>
                    `);
                } else {
                    $('.search-alert').remove();
                }
            } else {
                $('.tour-item').show();
                $('.search-alert').remove();
            }
        }
        
        // نمایش جزئیات تور در مودال
        $(document).on('click', '.tour-description', function() {
            var card = $(this).closest('.tour-card');
            var title = card.find('.tour-title').text();
            var description = $(this).attr('title');
            var price = card.find('.price-badge').text();
            
            $('#tourModalLabel').text(title);
            $('#modalTourContent').html(`
                <div class="row">
                    <div class="col-md-6">
                        <img src="${card.find('.tour-img').attr('src')}" class="img-fluid rounded" alt="${title}">
                    </div>
                    <div class="col-md-6">
                        <h4>${title}</h4>
                        <div class="price-tag mb-3">
                            <strong>قیمت:</strong> ${price}
                        </div>
                        <p>${description}</p>
                    </div>
                </div>
            `);
            var tourId = card.find('.reserve-btn').attr('href');
            $('#modalReserveLink').attr('href', tourId);

            var modal = new bootstrap.Modal(document.getElementById('tourModal'));
            modal.show();
        });
        
        // تصاویر شکسته شده
        $('img').on('error', function() {
            $(this).attr('src', '../images/default-tour.jpg');
            $(this).closest('.tour-img-container').addClass('no-image');
        });
        
        // تنظیم ارتفاع یکسان برای کارت‌ها
        function setEqualHeight() {
            var maxHeight = 0;
            $('.tour-card').each(function() {
                var height = $(this).outerHeight();
                if (height > maxHeight) {
                    maxHeight = height;
                }
            });
            
            // فقط اگر تفاوت ارتفاع زیاد باشد تنظیم کنیم
            $('.tour-card').each(function() {
                if ($(this).outerHeight() < maxHeight - 20) {
                    $(this).css('height', maxHeight + 'px');
                }
            });
        }
        
        // بعد از بارگذاری تصاویر ارتفاع را تنظیم کن
        setTimeout(setEqualHeight, 500);
        $(window).on('resize', setEqualHeight);
    });
    </script>
</body>
</html>