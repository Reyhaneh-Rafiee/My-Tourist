/********************************************* chat box ***********************************/ 
$(document).ready(function () {

  // باز شدن چت → فقط welcome
  $("#chat-circle").click(function () {
    $("#chat-circle").hide();
    $(".chat-box").show();
    $(".chat-box-welcome__header").show(); // welcome
    $("#chat-box__wraper").hide();         // هنوز نرو تو چت
  });

  // کلیک روی welcome یا input → رفتن داخل چت
  $(".chat-box-welcome__header, #chat-input__text").click(function () {
    $(".chat-box-welcome__header").hide();
    $("#chat-box__wraper").show();
  });

  // بستن چت
  $(".chat-box-toggle").click(function () {
    $("#chat-circle").show();
    $(".chat-box").hide();
    $(".chat-box-welcome__header").hide();
    $("#chat-box__wraper").hide();
  });

  // مسیر تصویر ربات بر اساس صفحه
  function getRobotImgPath() {
    if (window.location.pathname.endsWith("index.php") || window.location.pathname === "/") {
      return "images/icon33.png"; // صفحه اصلی
    } else {
      return "../images/icon33.png"; // بقیه صفحات
    }
  }

  // منطق پاسخ ربات
  function botAnswer(text) {
    text = text.toLowerCase();

    if (text.includes("سلام") || text.includes("hi") || text.includes("hello"))
      return "سلام 👋 به گردشگرمن خوش اومدی. آماده‌ای برای انتخاب تور؟";

    if (text.includes("مرسی") || text.includes("ممنون") || text.includes("تشکر") || text.includes("سپاس"))
      return "خواهش می‌کنم 😊 خوشحال میشم کمکت کنم. سوال دیگه‌ای داری؟";

    if (text.includes("خداحافظ") || text.includes("فعلاً") || text.includes("خدانگهدار") || text.includes("bye"))
      return "سفر خوبی برات آرزو می‌کنم ✈️🌍 هر وقت خواستی برگرد 😉";

    if (text.includes("تور"))
      return "برای دیدن و انتخاب تورهای داخلی، لطفاً از منوی 'تورها' استفاده کنید.";

    if (text.includes("رزرو"))
      return "برای رزرو تور، کافیه وارد صفحه تور بشی و فرم رزرو رو پر کنی.";

    if (text.includes("قیمت"))
      return "قیمت هر تور داخل صفحه خودش درج شده 💰";

if (text.includes("جاذبه"))
      return " برای آشنایی با جاذبه های بیشتر به همین صفحه مراجعه کنید :)";

    if (text.includes("پرداخت"))
      return "پرداخت کاملاً آنلاین و امن انجام میشه 💳";

    return "اگر سوالی درباره تورها، قیمت یا رزرو داری، بپرس 😊";
  }

  // ارسال پیام
  $(".chat-input__form").on("submit", function (e) {
    e.preventDefault();

    let msg = $(".chat-input__text").val().trim();
    if (!msg) return;

    $(".chat-logs").append(`
      <div class="chat-msg self">
        <div class="cm-msg-text">${msg}</div>
      </div>
    `);

    $(".chat-input__text").val("");

    setTimeout(function () {
      let answer = botAnswer(msg);
      let robotImg = getRobotImgPath();

      $(".chat-logs").append(`
        <div class="chat-msg bot">
          <span class="msg-avatar">
            <img class="chat-box-overlay_robot" src="${robotImg}">
          </span>
          <div class="cm-msg-text">${answer}</div>
        </div>
      `);

      $(".chat-logs").scrollTop($(".chat-logs")[0].scrollHeight);
    }, 500);
  });

});

/********************************************* FAQ page ***********************************/ 

/* باکس سوالات متداول که با کلیک روی هر سوال پاسخ ان باز شود */
const btns = document.querySelectorAll(".acc-btn");
  // fn
  function accordion() {
    // this = the btn | icon & bg changed
    this.classList.toggle("is-open");
  
    // the acc-content
    const content = this.nextElementSibling;
  
    // IF open, close | else open
    if (content.style.maxHeight) content.style.maxHeight = null;
    else content.style.maxHeight = content.scrollHeight + "px";
  }
  // event
  btns.forEach((el) => el.addEventListener("click", accordion));


 /*********************************back to top page button*********************************************/
$(document).ready(function(){
  $(window).scroll(function(){
    if ($(this).scrollTop() > 100) {
      $('.back-to-top').fadeIn();
    } else {
      $('.back-to-top').fadeOut();
    }
  });
  $('.back-to-top').click(function(){
    $("html, body").animate({ scrollTop: 0 }, 1000);
    return false;
  });
}); 



/*************************************** slider in index page ********************************************/
var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
    }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
}











    































