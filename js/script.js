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











    































