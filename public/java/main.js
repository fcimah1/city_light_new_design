const mainMenu = document.getElementsByClassName("main-menu")[0];
const layer = document.getElementById("layer");
const btnToggle = document.getElementById("btn-toggle");
const closeUserMenuBtn = document.getElementById("close-btn");
const userOpenBtn = document.getElementById("user-open");
const userMenu = document.getElementById("user-account");

const btnCountryShow = document.getElementsByClassName("country")[0];
const countryMenu = document.getElementById("country-menu");

const topDiscountBar = document.getElementsByClassName("discount")[0];

const header = document.getElementsByTagName("header")[0];

const btnUserMenu = document.getElementById("btn-menu-user");

const cartButton = document.getElementById("cart");

const cartClose = document.getElementById("close-btn-cart");
const cartBack = document.getElementById("btn-cart-back");

const cartMenu = document.getElementById("user-cart");

cartClose.addEventListener("click", () => {
  cartMenu.classList.toggle("show");
  layer.classList.toggle("lay-show");
});
cartBack.addEventListener("click", () => {
  cartMenu.classList.toggle("show");
  layer.classList.toggle("lay-show");
});
cartButton.addEventListener("click", () => {
  cartMenu.classList.toggle("show");
  layer.classList.toggle("lay-show");
});

btnUserMenu.addEventListener("click", () => {
  userMenu.classList.toggle("show");
  mainMenu.classList.remove("show");
});

window.addEventListener("scroll", () => {
  if (+window.scrollY > 0) {
    topDiscountBar.classList.add("discount-hidden");
    // header.classList.add("sticky");
  } else {
    topDiscountBar.classList.remove("discount-hidden");
  }
});
btnCountryShow.addEventListener("click", () => {
  countryMenu.classList.toggle("open");
  btnCountryShow.firstElementChild.firstElementChild.classList.toggle(
    "rotate-up"
  );
});

btnToggle.addEventListener("click", () => {
  mainMenu.classList.toggle("show");
  layer.classList.toggle("lay-show");
});

layer.addEventListener("click", () => {
  layer.classList.toggle("lay-show");
  mainMenu.classList.remove("show");
  userMenu.classList.remove("show");
  cartMenu.classList.remove("show");
});

userOpenBtn.addEventListener("click", () => {
  console.log("hello");
  userMenu.classList.toggle("show");
  layer.classList.toggle("lay-show");
});

closeUserMenuBtn.addEventListener("click", () => {
  userMenu.classList.toggle("show");
  layer.classList.toggle("lay-show");
});

// initialize  the swiper

const swiper = new Swiper(".swiper-container", {
  loop: true, // Enables infinite looping
  autoplay: {
    delay: 1000, // 1-second delay between slides
    disableOnInteraction: false, // Continue autoplay after interaction
  },
  pagination: {
    el: ".swiper-pagination", // Pagination element
    clickable: true, // Allows users to click on pagination bullets
  },
});

// articles silder

const swiperArticles = new Swiper(".swiper-articles", {
  slidesPerView: 3, // Show 3 slides at a time
  spaceBetween: 20, // Space between slides (optional)
  loop: true, // Enable infinite looping
  autoplay: {
    delay: 3000, // Auto-slide every 3 seconds
    disableOnInteraction: false, // Keep autoplay after interaction
  },
  navigation: {
    nextEl: ".swiper-button-next", // Next button
    prevEl: ".swiper-button-prev", // Previous button
  },
  breakpoints: {
    992: {
      slidesPerView: 3,
    },
    600: {
      slidesPerView: 2, // Show 3 slides on tablets and larger
    },
    0: {
      slidesPerView: 1, // Show 1 slide on phones
    },
  },
});

const swiperNewArrival = new Swiper(".swiper-new-arrival", {
  slidesPerView: 3, // Show 3 items
  spaceBetween: 20, // Add space between slides
  loop: true, // Enable infinite looping
  autoplay: {
    delay: 3000, // Auto-slide every 3 seconds
    disableOnInteraction: false, // Keep autoplay after interaction
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    992: {
      slidesPerView: 3,
    },
    600: {
      slidesPerView: 2, // Show 3 slides on tablets and larger
    },
    0: {
      slidesPerView: 1, // Show 1 slide on phones
    },
  },
});

// const swiperNewArrival = new Swiper(".swiper-new-arrival", {
//   slidesPerView: 3, // Show 3 slides at a time
//   spaceBetween: 20, // Space between slides (optional)
//   loop: true, // Enable infinite looping
//   // autoplay: {
//   //   delay: 3000, // Auto-slide every 3 seconds
//   //   disableOnInteraction: false, // Keep autoplay after interaction
//   // },
//   navigation: {
//     nextEl: ".swiper-button-next", // Next button
//     prevEl: ".swiper-button-prev", // Previous button
//   },
//   breakpoints: {
//     992: {
//       slidesPerView: 3,
//     },
//     600: {
//       slidesPerView: 2, // Show 3 slides on tablets and larger
//     },
//     0: {
//       slidesPerView: 1, // Show 1 slide on phones
//     },
//   },
// });
