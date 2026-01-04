<?php
require_once 'pages/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>گردشگر من</title>
<link rel="icon" href="images/icon33.png" type="image/ico"/>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap.rtl.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="css/style.css">
</head>

<!--------------------------- menu ------------------------------->
<body class="rtl index-page" >
        <nav class="navbar navbar-expand-lg fixed-top">
             <div class="container-fluid">
              <a  class="navbar-brand">
                <img src="images/icon33.png" alt="گردشگر من" width="80" height="70">
              </a>
              <a class="navbar-brand" >  گردشگر من </a>
              <span style="padding-left: 5px;"></span>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <?php if (isLoggedIn()): ?>
    <div class="user-menu" style="position:absolute; top:15px; left:20px;">
        <a href="Customer-orders.php" class="btn btn-outline-success btn-sm">
            👤 پروفایل کاربری
        </a>
        <a href="php/logout.php" class="btn btn-outline-danger btn-sm">
            خروج
        </a>
    </div>
<?php endif; ?>

                  <li class="nav-item ">
                    <a class="nav-link "  href="index.php">صفحه اصلی</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="pages/about-us.html">درباره ما</a>
                  </li>
                  <li class="nav-item ">
                    <a class="nav-link "  href="pages/tours.php">تورها </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="pages/jazebe.php">  جاذبه ها</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="pages/article.html"> مقالات </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="pages/contact.html"> تماس با ما</a>
                  </li>
                </ul>
                <span style="padding-left: 200px;"></span>               
              </div>
            </div>

          </nav>



   <!-- first section(landing)-->

   <section class="landing">
    <a href="pages/register-form.html" class="login-button">ثبت نام کاربر | ورود ادمین
      <span style="padding-left: 10px;">
        <i class="fa fa-lg fa-sign-in-alt"></i>
      </span></a>
    </button>
  <section class="caption text-center">
  <h1>   ایران را زیباتر ببین… با گردشگر من   </h1><br>
  <h3>  کشف جاذبه‌ها | رزرو تور | راهنمای سفر</h3><br>
  </section></section>


  
<!-- second section (About Iran) -->
<section class="AboutIran">
  <h2 class="AboutIran">درباره ایران</h2>
  
  <span dir="auto">
    <p class="paragraph">
      ایران، سرزمین چهار فصل و یکی از کهن‌ترین تمدن‌های جهان است؛ جایی که تاریخ، فرهنگ، طبیعت و مهمان‌نوازی گرم مردمش، تجربه‌ای متفاوت از سفر می‌سازد. 
      از جنگل‌های مه‌آلود و سرسبز شمال گرفته تا کویرهای طلایی و آسمان پرستاره مرکز کشور، از معماری باشکوه اصفهان و شیراز تا سواحل بکر جنوب، هر گوشه از این سرزمین روح مسافر را تازه می‌کند.
    </p>

    <p class="paragraph">
      در «گردشگر من» تلاش کرده‌ایم بهترین جاذبه‌ها، تجربه‌ها، راهنماها و تورهای گردشگری ایران را در اختیار شما قرار دهیم؛ 
      تا برنامه‌ریزی سفر برای شما آسان‌تر، جذاب‌تر و مطمئن‌تر باشد. 
      چه عاشق ماجراجویی باشید، چه به دنبال آرامش طبیعت یا دیدن آثار تاریخی، ایران همیشه مقصدی دارد که منتظر کشف شدن است.
    </p>
  </span>
</section>



<!-- Third section (services) -->
<section class="services-section" id="services-section">
  <div id="services">
    <div class="jumbotron">
      <div class="area text-center">
        <div class="col-12 text-center">

          <h4 class="title">خدمات گردشگر من</h4>
          <hr class="underline"><br>

        </div>

        <div class="row text-center">

          <!-- service 1 -->
          <div class="col-6">
            <div class="services">
              <i class="fa fa-map-marked-alt fa-3x"></i>
              <h5 class="title">معرفی جاذبه‌های گردشگری</h5>
              <p class="text">
                در «گردشگر من» می‌توانید بهترین جاذبه‌های گردشگری ایران  
                <br>از شهرهای تاریخی تا طبیعت بکر  
                <br>را همراه با توضیحات کامل، تصاویر باکیفیت  
                <br>و راهنمای سفر مشاهده کنید تا برنامه‌ریزی سفرتان دقیق‌تر شود
              </p>
            </div>
          </div>

          <!-- service 2 -->
          <div class="col-6">
            <div class="services">
              <i class="fa fa-suitcase-rolling fa-3x"></i>
              <h5 class="title">رزرو آنلاین تور</h5>
              <p class="text">
                امکان رزرو انواع تورهای داخلی شامل  
                <br>تورهای طبیعت‌گردی، فرهنگی، شهری و ماجراجویی  
                <br>به صورت آنلاین و با جزئیات کامل برنامه سفر
                <br>همراه با پشتیبانی و راهنمایی برای انتخاب بهترین تور
              </p>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>


<!-- fourth section (About Iran History / Travel Background) -->
<section class="history">
  <h2 class="history">نگاهی کوتاه به تاریخ و فرهنگ ایران</h2>

  <p class="paragraph"><span dir="auto">
    ایران یکی از کهن‌ترین سرزمین‌های جهان است؛ سرزمینی که هزاران سال قدمت، تمدنی غنی و فرهنگی بی‌نظیر را در خود جای داده است. از دوران ایلامی‌ها و هخامنشیان تا صفویه و قاجار، هر دوره تاریخی نقشی مهم در شکل‌گیری هویت امروز ایران داشته است.
  </span></p>

  <p class="paragraph"><span dir="auto">
    وجود آثار تاریخی مانند تخت‌جمشید، پاسارگاد، بیستون، نقش رستم، مسجد جامع اصفهان، بازار تبریز و صدها بنای ارزشمند دیگر، ایران را به یکی از مهم‌ترین مقصدهای گردشگری فرهنگی در جهان تبدیل کرده است. هر شهر و روستا، داستانی است از هنر، معماری، آیین‌ها و سبک‌های زندگی متفاوت.
  </span></p>

  <p class="paragraph"><span dir="auto">
    علاوه بر تاریخ شگفت‌انگیز، ایران با داشتن اقلیم چهارفصل، مقصدی بی‌نظیر برای علاقه‌مندان به طبیعت و ماجراجویی است. کویرهای طلایی، جنگل‌های مرطوب شمال، کوهستان‌های پر برف، سواحل گرم جنوب، دریاچه‌ها، آبشارها و دشت‌های سرسبز—همگی بخشی از جذابیت‌های طبیعی این سرزمین پهناور هستند.
  </span></p>

  <p class="paragraph"><span dir="auto">
    فرهنگ مهربان و مهمان‌نواز مردم ایران، غذاهای متنوع و اصیل، صنایع‌دستی ارزشمند، و سبک زندگی گرم و صمیمی، سفر به ایران را به تجربه‌ای متفاوت و ماندگار تبدیل می‌کند. در «گردشگر من» تلاش می‌کنیم تا این زیبایی‌ها را با بهترین کیفیت به شما معرفی کنیم و همواره همراهتان در کشف ایران باشیم.
  </span></p>
</section>



<!-- slider -->
<div class="slideshow-container">

  <!-- Slide 1: جاذبه‌های تاریخی -->
  <div class="mySlides">
    <h4 class="title">
      <span class="title-word title-word-1">جاذبه‌های</span>
      <span class="title-word title-word-2">تاریخی</span>
      <span class="title-word title-word-3">ایران</span>
    </h4>
    <br><br><br>

    <div class="tour-icons">
      <div>
        <img src="images/perspolis.jpg" alt="تخت جمشید" width="150" height="140">
        <br>
        <div class="tour-name">تخت‌جمشید</div>
      </div>

      <div>
        <img src="images/naqshe-jahan.jpg" alt="نقش جهان" width="150" height="140">
        <br>
        <div class="tour-name">میدان نقش جهان</div>
      </div>

      <div>
        <img src="images/bisotun.jpg" alt="بیستون" width="150" height="140">
        <br>
        <div class="tour-name">بیستون</div>
      </div>

      <div>
        <img src="images/bam.jpg" alt="ارگ بم" width="150" height="140">
        <br>
        <div class="tour-name">ارگ بم</div>
      </div>

      <div>
        <img src="images/pasargad.jpg" alt="پاسارگاد" width="150" height="140">
        <br>
        <div class="tour-name">پاسارگاد</div>
      </div>
    </div>
  </div>

  <!-- Slide 2: جاذبه‌های طبیعی -->
  <div class="mySlides">
    <h4 class="title">
      <span class="title-word title-word-1">جاذبه‌های</span>
      <span class="title-word title-word-2">طبیعی</span>
      <span class="title-word title-word-3">ایران</span>
    </h4>
    <br><br><br>

    <div class="tour-icons">
      <div>
        <img src="images/damavand.jpg" alt="دماوند" width="150" height="140">
        <br>
        <div class="tour-name">دماوند</div>
      </div>

      <div>
        <img src="images/hirkani.jpg" alt="جنگل" width="150" height="140">
        <br>
        <div class="tour-name">جنگل‌های هیرکانی</div>
      </div>

      <div>
        <img src="images/maranjab.jpg" alt="کویر" width="150" height="140">
        <br>
        <div class="tour-name">کویر مرنجاب</div>
      </div>

      <div>
        <img src="images/cheshme.jpg" alt="چشمه" width="150" height="140">
        <br>
        <div class="tour-name">چشمه‌های آب گرم</div>
      </div>

      <div>
        <img src="images/sahel.jpg" alt="سواحل ایران" width="150" height="140">
        <br>
        <div class="tour-name">سواحل ایران</div>
      </div>
    </div>
  </div>

  <!-- Slide 3: شهرهای گردشگری -->
  <div class="mySlides">
    <h4 class="title">
      <span class="title-word title-word-1">شهرهای</span>
      <span class="title-word title-word-2">محبوب</span>
      <span class="title-word title-word-3">گردشگری</span>
    </h4>
    <br><br><br>

    <div class="tour-icons">
      <div>
        <img src="images/isfahan.jpg" alt="اصفهان" width="150" height="140">
        <br>
        <div class="tour-name">اصفهان</div>
      </div>

      <div>
        <img src="images/shiraz.jpg" alt="شیراز" width="150" height="140">
        <br>
        <div class="tour-name">شیراز</div>
      </div>

      <div>
        <img src="images/yazd.jpg" alt="یزد" width="150" height="140">
        <br>
        <div class="tour-name">یزد</div>
      </div>

      <div>
        <img src="images/tabriz.jpg" alt="تبریز" width="150" height="140">
        <br>
        <div class="tour-name">تبریز</div>
      </div>

      <div>
        <img src="images/mashhad.jpg" alt="مشهد" width="150" height="140">
        <br>
        <div class="tour-name">مشهد</div>
      </div>
    </div>
  </div>

  <!-- دکمه‌های قبلی و بعدی -->
  <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
  <a class="next" onclick="plusSlides(1)">&#10095;</a>
</div>

<!-- دایره‌های نشانگر -->
<div class="dot-container">
  <span class="dot" onclick="currentSlide(1)"></span>
  <span class="dot" onclick="currentSlide(2)"></span>
  <span class="dot" onclick="currentSlide(3)"></span>
</div>




<!-- the fifth section (short info about your tourism site) -->
<section class="section5 text-center" style="padding: 80px 20px; background-color: #f9f9f9;">
  <h2>با ما، دنیای گردشگری را کشف کنید</h2>
  <br>
  <p style="max-width: 700px; margin: auto; font-size: 18px; line-height: 1.6;">
    سایت «گردشگر من» شما را به زیباترین مقاصد گردشگری ایران می‌برد.  
    با معرفی جاذبه‌ها، تورها و راهنمای سفر، می‌توانید برنامه‌ریزی سفر خود را آسان‌تر کنید و از تجربه‌ای فراموش‌نشدنی لذت ببرید.
  </p>
  <br><br>
</section>

<!-------------------------------------- Chat box ---------------------------------------->

 <!--button chat-->
 <div id="chat-circle" class="btn btn-raised">
  <div id="chat-overlay"></div>
  <img class="chat-circle_robot" src="images/chat.png" >
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
              <img class="chat-box-welcome_robot" src="images/chat.png">
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
             <img class="chat-box-overlay_robot" src="images/icon33.png">          
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
          <img src="images/socialmedia.png" height="200px" width="200px">
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
        <li><a href="pages/FAQ.html"> سوالات متداول</a></li>
      </ul>
      </div>
      <div class="col-md-3 mb-3 ">
        <h5 >لینک‌های مهم</h5>
        <ul class="list-unstyled">
          <li><a href="#services-section">خدمات ما </a></li>
          <li><a href="pages/about-us.html"> درباره ما </a></li>
          <li><a href="pages/contact.html"> تماس با ما </a></li>
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
  <i class="fas fa-chevron-up"></i></a>






<script src="js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/script.js"></script>

</body>
</html>
