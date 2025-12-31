<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title >درباره ما  - گردشگر من</title>
    <link rel="icon" href="../images/icon33.png" type="image/ico"/>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

    <style>
        /* استایل‌های اصلاح شده */
        
        /* فاصله از منوی ثابت */
        .jazebe-container {
            margin-top: 100px;
            margin-bottom: 50px;
            min-height: calc(100vh - 300px); /* حداقل ارتفاع برای جلوگیری از همپوشانی با فوتر */
        }
        
        /* هدر صفحه */
        .page-header {
            text-align: center;
            margin-bottom: 40px;
            padding: 30px 20px;
            background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
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
        
        /* استایل کارت‌ها */
        .jazebe-card {
            border: 1px solid #eaeaea;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            margin-bottom: 25px;
            height: 450px; /* ارتفاع ثابت برای همه کارت‌ها */
            display: flex;
            flex-direction: column;
        }
        
        .jazebe-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.15);
            border-color: #4b6cb7;
        }
        
        /* کانتینر تصویر */
        .jazebe-img-container {
            height: 220px;
            overflow: hidden;
            flex-shrink: 0; /* جلوگیری از تغییر سایز */
        }
        
        .jazebe-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .jazebe-card:hover .jazebe-img {
            transform: scale(1.05);
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
        .jazebe-body {
            padding: 20px;
            flex-grow: 1; /* پر کردن فضای باقیمانده */
            display: flex;
            flex-direction: column;
        }
        
        .jazebe-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 12px;
            line-height: 1.4;
            height: 60px; /* ارتفاع ثابت برای عنوان */
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2; /* حداکثر 2 خط */
            -webkit-box-orient: vertical;
        }
        
        .jazebe-description {
            color: #555;
            line-height: 1.6;
            font-size: 0.95rem;
            flex-grow: 1; /* پر کردن فضای باقیمانده */
            overflow: hidden;
            position: relative;
        }
        
        /* برای محدود کردن متن با نقطه چین */
        .jazebe-description.truncate {
            display: -webkit-box;
            -webkit-line-clamp: 4; /* حداکثر 4 خط */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        /* دکمه مشاهده بیشتر */
        .read-more {
            color: #4b6cb7;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            transition: color 0.3s ease;
        }
        
        .read-more:hover {
            color: #182848;
            text-decoration: underline;
        }
        
        /* استایل برای وقتی جاذبه‌ای وجود ندارد */
        .no-jazebe {
            text-align: center;
            padding: 60px 20px;
            background: #f8f9fa;
            border-radius: 12px;
            margin: 40px 0;
            border: 2px dashed #dee2e6;
        }
        
        .no-jazebe i {
            font-size: 4rem;
            color: #adb5bd;
            margin-bottom: 20px;
        }
        
        .no-jazebe h3 {
            color: #495057;
            margin-bottom: 15px;
        }
        
        .no-jazebe p {
            color: #6c757d;
            max-width: 500px;
            margin: 0 auto;
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
            background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
            border: none;
            border-radius: 0 30px 30px 0;
        }
        
        /* فاصله بین ردیف‌ها */
        .row {
            margin-bottom: 10px;
        }
        
        /* برای صفحه‌بندی (اگر نیاز شد) */
        .pagination {
            justify-content: center;
            margin-top: 40px;
        }
        
        .pagination .page-link {
            color: #4b6cb7;
            border: 1px solid #dee2e6;
            margin: 0 3px;
            border-radius: 5px;
        }
        
        .pagination .page-item.active .page-link {
            background: #4b6cb7;
            border-color: #4b6cb7;
            color: white;
        }
    </style>
</head>

<!--------------------------- menu ------------------------------->
<body class="rtl" >
  <nav class="navbar navbar-expand-lg fixed-top">
      <div class="container-fluid">
        <a  class="navbar-brand">
          <img src="../images/icon33.png" alt="گردشگر من" width="80" height="70">
        </a>
        <a class="navbar-brand" >  گردشگر من </a>
        <span style="padding-left: 5px;"></span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item ">
              <a class="nav-link "  href="../index.html">صفحه اصلی</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../pages/about-us.html">درباره ما</a>
            </li>
            <li class="nav-item ">
              <a class="nav-link "  href="../pages/tours.php">تورها </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../pages/jazebe.php">  جاذبه ها</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../pages/article.html"> مقالات </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../pages/contact.html"> تماس با ما</a>
            </li>
          </ul>
          <span style="padding-left: 200px;"></span>
          
        </div>
      </div>
    </nav>

    <!-- محتوای اصلی صفحه جاذبه‌ها -->
    <div class="container jazebe-container">
        <!-- هدر صفحه -->
        <div class="page-header">
            <h1>جاذبه های گردشگری ایران</h1>
            <p>کشف زیبایی‌های بی‌نظیر ایران از آثار تاریخی تا طبیعت بکر</p>
        </div>

        <!-- بخش جستجو -->
        <div class="search-box">
            <div class="input-group">
                <input type="text" class="form-control" id="search-input" placeholder="جستجوی جاذبه‌ها...">
                <button class="btn btn-primary" id="search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <!-- نمایش جاذبه‌ها -->
        <div class="row" id="jazebe-list">
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
            
            // دریافت جاذبه‌ها از دیتابیس - مرتب سازی بر اساس ID
            $sql = "SELECT * FROM jazebe ORDER BY `j_id` DESC";
            $result = $conn->query($sql);
            
            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // دریافت داده‌ها
                    $title = isset($row['title']) ? htmlspecialchars($row['title']) : 'بدون عنوان';
                    $description = isset($row['description']) ? htmlspecialchars($row['description']) : '';
                    $image_path = isset($row['image_path']) ? $row['image_path'] : '';
                    $id = isset($row['j_id']) ? $row['j_id'] : 0;
                    
                    // محدود کردن توضیحات برای نمایش
                    $short_desc = strlen($description) > 200 ? 
                        substr($description, 0, 200) . "..." : 
                        $description;
                    
                    // نمایش کارت
                    echo '
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card jazebe-card">
                            <div class="jazebe-img-container">';
                    
                    if (!empty($image_path) && file_exists("../" . $image_path)) {
                        echo '<img src="../' . $image_path . '" class="jazebe-img" alt="' . $title . '" onerror="this.onerror=null; this.src=\'../images/default-jazebe.jpg\';">';
                    } else {
                        echo '<div class="no-image">
                                <i class="fas fa-landmark"></i>
                                <span>بدون تصویر</span>
                              </div>';
                    }
                    
                    echo '
                            </div>
                            <div class="jazebe-body">
                                <h3 class="jazebe-title" title="' . $title . '">' . $title . '</h3>
                                <div class="jazebe-description truncate" title="' . $description . '">' . $short_desc . '</div>';
                    
                    // اگر متن کامل‌تر از نسخه کوتاه شده است، دکمه مشاهده بیشتر نشان بده
                    if (strlen($description) > 200) {
                        echo '<a href="#" class="read-more" data-id="' . $id . '">مشاهده بیشتر</a>';
                    }
                    
                    echo '
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '
                <div class="col-12">
                    <div class="no-jazebe">
                        <i class="fas fa-binoculars"></i>
                        <h3>هنوز جاذبه‌ای اضافه نشده است</h3>
                        <p>به زودی جاذبه‌های زیبای ایران را اینجا خواهید دید.</p>
                        <a href="../panel-admin/add-new-jazebe.html" class="btn btn-primary mt-3">افزودن جاذبه جدید</a>
                    </div>
                </div>';
            }
            
            $conn->close();
            ?>
        </div>
        
        <!-- صفحه‌بندی (در آینده) -->
        <nav aria-label="Page navigation" id="pagination-container" style="display: none;">
            <ul class="pagination">
                <li class="page-item disabled">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>


    <!-------------------------------------- Chat box ---------------------------------------->

 <!--button chat-->
 <div id="chat-circle" class="btn btn-raised">
  <div id="chat-overlay"></div>
  <img class="chat-circle_robot" src="../images/chat.png" >
</div>
<!--chat-box-->
<div class="chat-box">
  <div class="chat-box-body">
      <!--welcome message-->
      <div class="chat-box-welcome__header">
          <div class="chat-box__header-text">
              <span class="chat-box-toggle"><i class="fa fa-window-close" ></i></span>
          </div>
          <div id="chat-box-welcome__ava">
              <img class="chat-box-welcome_robot" src="../images/chat.png">
          </div>
          <br>
          <div class="chat-box-welcome__welcome-text">
            <span dir="auto"><p>
              به گردشگر من خوش آمدید .
              <br>
              برای راهنمایی در رزرو تورهای داخلی، قیمت‌ها و برنامه سفر، در خدمت شما هستیم.
              </p>
              </span>
          </div>
      </div>
      <!--chat-box after welcome page-->
      <div id="chat-box__wraper">
          <div class="chat-box-header">
              <span class="chat-box-toggle"><i class="fa fa-window-close"  ></i></span>
          </div>
          <div class="chat-box-overlay">
          </div>
          <div class="chat-logs">
              <div id="cm-msg-0" class="chat-msg bot">
                  <span class="msg-avatar">
             <img class="chat-box-overlay_robot" src="../images/icon33.png">          
             </span>
             <span dir="auto">
                  <div class="cm-msg-text">
                    سلام 👋  
                    به «گردشگر من» خوش اومدی 🌍  
                    اگه درباره تورهای داخلی، رزرو، قیمت‌ها یا زمان‌بندی سفر سوالی داری، من کنارت هستم 😊
                    
                  </span></div>
              </div>
      </div>
  </div>
  <div class="chat-input-box" id="chatLog">
    <span dir="auto">
      <form class="chat-input__form">
         <input type="text" class="chat-input__text" id="chat-input__text" placeholder="پیام را ارسال کنید..." /></span> 
          <button type="submit" class="chat-submit" id="chat-submit">
            <i class="material-icons">ارسال</i>
        </button>
      </form>
  </div>
</div>
</div>

    <!----------------------------------footer--------------------------------->
<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <ul class="list-inline">
          <img src="../images/socialmedia.png" height="200px" width="200px">
          <p class="follow-us"> .ما را در شبکه های اجتماعی دنبال کنید</p>
          <hr class="follow-us-line">
          <li class="list-inline-item"><a  class="social-icon"><i class="fab  fa-whatsapp fa-lg"></i></a></li>
          <li class="list-inline-item"><a  class="social-icon"><i class="fab  fa-telegram fa-lg"></i></a></li>
          <li class="list-inline-item"><a  class="social-icon"><i class="fab fa-instagram fa-lg"></i></a></li>
          <li class="list-inline-item"><a  class="social-icon email-icon"><i class="far fa-envelope fa-lg"></i></a></li>
        </ul>
      </div>
      <div class="col-md-3 mb-3 ">
        <h5>  خدمات مشتریان</h5>
        <ul class="list-unstyled">
        <li><a href="../pages/FAQ.html"> سوالات متداول</a></li>
      </ul>
      </div>
      <div class="col-md-3 mb-3 ">
        <h5 >لینک‌های مهم</h5>
        <ul class="list-unstyled">
          <li><a href="../index.html#services-section">خدمات ما </a></li>
          <li><a href="../pages/about-us.html"> درباره ما </a></li>
          <li><a href="../pages/contact.html"> تماس با ما </a></li>
        </ul>
      </div>
    </div>
    <div class="row mt-5">
      <div class="col-md-12 text-center">
        <p ><span dir="auto">&copy;1404،تمامی حقوق برای گردشگرمن محفوظ می باشد. </p></span>
      </div>
    </div>
  </div>
</footer>

    <!--------------------------------back to top page button------------------------>
    <a class="btn btn-primary btn-lg back-to-top" role="button">
        <i class="fas fa-chevron-up"></i>
    </a>

    <!-- مودال برای نمایش متن کامل -->
    <div class="modal fade" id="descriptionModal" tabindex="-1" aria-labelledby="descriptionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="descriptionModalLabel">توضیحات کامل</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalDescriptionContent">
                    <!-- محتوای مودال اینجا لود می‌شود -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/script.js"></script>
    
    <script>
    $(document).ready(function() {
        // جستجوی جاذبه‌ها
        $('#search-btn').click(searchJazebe);
        $('#search-input').keypress(function(e) {
            if (e.which == 13) searchJazebe();
        });
        
        function searchJazebe() {
            var searchTerm = $('#search-input').val().trim().toLowerCase();
            if (searchTerm) {
                $('.jazebe-card').each(function() {
                    var title = $(this).find('.jazebe-title').text().toLowerCase();
                    var desc = $(this).find('.jazebe-description').text().toLowerCase();
                    
                    if (title.includes(searchTerm) || desc.includes(searchTerm)) {
                        $(this).parent().show();
                    } else {
                        $(this).parent().hide();
                    }
                });
                
                // اگر هیچ نتیجه‌ای یافت نشد
                if ($('.jazebe-card:visible').length === 0) {
                    $('#jazebe-list').append(`
                        <div class="col-12">
                            <div class="alert alert-warning text-center">
                                <i class="fas fa-search"></i>
                                هیچ جاذبه‌ای با عبارت "${$('#search-input').val()}" یافت نشد.
                            </div>
                        </div>
                    `);
                }
            } else {
                $('.jazebe-card').parent().show();
                $('.alert-warning').remove();
            }
        }
        
        // نمایش متن کامل در مودال
        $(document).on('click', '.read-more', function(e) {
            e.preventDefault();
            var card = $(this).closest('.jazebe-card');
            var title = card.find('.jazebe-title').text();
            var description = card.find('.jazebe-description').attr('title');
            
            $('#descriptionModalLabel').text(title);
            $('#modalDescriptionContent').html('<p>' + description + '</p>');
            
            var modal = new bootstrap.Modal(document.getElementById('descriptionModal'));
            modal.show();
        });
        
        // تصاویر شکسته شده
        $('img').on('error', function() {
            $(this).attr('src', '../images/default-jazebe.jpg');
            $(this).closest('.jazebe-img-container').addClass('no-image');
        });
        
        // تنظیم ارتفاع یکسان برای کارت‌ها
        function setEqualHeight() {
            var maxHeight = 0;
            $('.jazebe-card').each(function() {
                var height = $(this).outerHeight();
                if (height > maxHeight) {
                    maxHeight = height;
                }
            });
            
            // فقط اگر تفاوت ارتفاع زیاد باشد تنظیم کنیم
            $('.jazebe-card').each(function() {
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