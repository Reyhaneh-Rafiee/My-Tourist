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
                <input type="text" class="form-control" id="search-input" placeholder="...جستجوی جاذبه‌ها">
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
                            <div class="alert alert-warning text-center" style="direction: rtl; text-align: right;">
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