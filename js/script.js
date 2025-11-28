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



/********************************************* search box *********************************************/
//با کلیک روی دکمه سرچ، سرچ باکس باز شود
const searchBtn = document.querySelector(".search-btn");
const searchBox = document.querySelector("input[type='search']");

searchBtn.addEventListener("click", function() {
  searchBox.focus();
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











    































