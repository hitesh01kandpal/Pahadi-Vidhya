
function pass_toggle() {
  var x = document.getElementsByClassName("pass_toggle");
  if (x[0].type === "password") {
    x[0].type = "text";
    x[1].type = "text";
  } else {
    x[0].type = "password";
    x[1].type = "password";
  }
}

function showSlides() {
  var i;
  var slides = document.getElementsByClassName("mySlides");

  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > slides.length) {
    slideIndex = 1;
  }

  slides[slideIndex - 1].style.display = "block";

  setTimeout(showSlides, 4000); // Change image every 2 seconds
}
