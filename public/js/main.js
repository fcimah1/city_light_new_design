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

const btnLangEn = document.getElementById("lang-en");
const btnLangAr = document.getElementById("lang-ar");

const btnLangActive = document.getElementById("lang-active");

let swiper;
let swiperArticles;
let swiperNewArrival;

btnLangEn.addEventListener("click", () => {
  if (document.documentElement.dir == "rtl") {
    document.documentElement.dir = "ltr";
    swiperArticles.destroy(true, true);
    swiperNewArrival[0].destroy(true, true);
    swiperNewArrival[1].destroy(true, true);
    initialzeSwiper();
    btnLangActive.firstElementChild.src = "images/en.png";
    btnLangActive.firstElementChild.nextElementSibling.textContent = "ENGLISH";
  }
});

btnLangAr.addEventListener("click", () => {
  if (document.documentElement.dir == "ltr") {
    document.documentElement.dir = "rtl";
    swiperArticles.destroy(true, true);
    swiperNewArrival[0].destroy(true, true);
    swiperNewArrival[1].destroy(true, true);
    initialzeSwiper();
    btnLangActive.firstElementChild.src = "images/Flag_of_Saudi_Arabia.svg-150x150.png";
    btnLangActive.firstElementChild.nextElementSibling.textContent = "السعوديه";
  }
});

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

// btnUserMenu.addEventListener("click", () => {
//   userMenu.classList.toggle("show");
//   mainMenu.classList.remove("show");
// });

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
function initialzeSwiper() {
  const isRTL = document.documentElement.dir === "rtl";
  swiper = new Swiper(".swiper-container", {
    loop: true, // Enables infinite looping
    autoplay: {
      delay: 1000, // 1-second delay between slides
      disableOnInteraction: false, // Continue autoplay after interaction
      reverseDirection: true,
    },
    pagination: {
      el: ".swiper-pagination", // Pagination element
      clickable: true, // Allows users to click on pagination bullets
    },
    rtl: isRTL,
  });

  // articles silder

  swiperArticles = new Swiper(".swiper-articles", {
    slidesPerView: 3, // Show 3 slides at a time
    spaceBetween: 20, // Space between slides (optional)
    loop: true, // Enable infinite looping
    rtl: isRTL,
    autoplay: {
      delay: 3000, // Auto-slide every 3 seconds
      disableOnInteraction: false, // Keep autoplay after interaction
      reverseDirection: true,
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

  swiperNewArrival = new Swiper(".swiper-new-arrival", {
    slidesPerView: 3, // Show 3 items
    spaceBetween: 20, // Add space between slides
    loop: true, // Enable infinite looping
    rtl: isRTL,
    autoplay: {
      delay: 3000, // Auto-slide every 3 seconds
      disableOnInteraction: false, // Keep autoplay after interaction
      reverseDirection: true,
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
}

initialzeSwiper();

// two button in popup

const btnDecrement = document.getElementById("popup-decrement");
const btnIncrement = document.getElementById("popup-increment");

const popup = document.getElementById("popup-quick");
const popupCount = document.getElementById("popup-count");


const allBtnsQuickLook = document.getElementsByClassName("quick-look");

const layerPopup = document.getElementById("layer-popup");

btnDecrement.addEventListener("click", () => {
  let count = parseInt(popupCount.textContent);
  if (count > 1) {
    count--;
    popupCount.textContent = count;
  }
});
btnIncrement.addEventListener("click", () => {
  let count = parseInt(popupCount.textContent);
  count++;
  popupCount.innerText = count;
});

[...allBtnsQuickLook].forEach((ele) => {
  ele.addEventListener("click", () => {
    popup.classList.add("popup-container-show");
    layerPopup.classList.add("lay-show");
  });
});

layerPopup.addEventListener("click", () => {
  popup.classList.remove("popup-container-show");
  layerPopup.classList.remove("lay-show");
});

const btnGridFour = document.getElementById("btn-grid-4");
const btnGridThree = document.getElementById("btn-grid-3");

const productShowInMainCat = document.getElementById("product-cat");

btnGridFour.addEventListener("click", () => {
  productShowInMainCat.classList.add("products-4");
});
btnGridThree.addEventListener("click", () => {
  productShowInMainCat.classList.remove("products-4");
});

// category slider price

const minValue = document.getElementById("min-value");
const maxValue = document.getElementById("max-value");

const rangeFill = document.getElementById("range-slider-id");

const rangeElements = document.querySelectorAll("input[type=range]");

function validateRange(e) {
  let minPrice = parseInt(rangeElements[0].value);
  let maxPrice = parseInt(rangeElements[1].value);

  minValue.textContent = `${minPrice} ر.س`;
  maxValue.textContent = `${maxPrice} ر.س`;

  //   calculate the percentage position  for min and mix values
  const minPercentage = ((minPrice - 10) / 490) * 100;
  const maxPercantage = ((maxPrice - 10) / 490) * 100;
  if (maxPrice - minPrice < 10) {
    if (e.target.className === "min-price") {
      rangeElements[0].value = maxPrice - 10;
      minValue.textContent = `${maxPrice - 10} ر.س`;
      rangeFill.style.width = "0";
    } else if (e.target.className === "max-price") {
      rangeElements[1].value = minPrice + 10;
      maxValue.textContent = `${minPrice + 10} ر.س`;
      rangeFill.style.width = "0";
    }
  } else {
    rangeFill.style.left = minPercentage + "%";
    rangeFill.style.width = maxPercantage - minPercentage + "%";
  }

  //   set the position and width of the fill color element to represent the selected range
}

rangeElements.forEach((ele) => {
  ele.addEventListener("input", validateRange);
});

validateRange();

// btn filter in small screens
const btnFilterShow = document.getElementById("btn-toggle-filter");
const filterMenu = document.getElementById("filter-menu");
const filterLayer = document.getElementById("layer-filter-product");
const closeBtn = document.getElementById("close-btn-filter");

btnFilterShow.addEventListener("click", () => {
  filterMenu.classList.add("popup-container-show");
  filterLayer.classList.add("lay-show");
});

filterLayer.addEventListener("click", () => {
  filterMenu.classList.remove("popup-container-show");
  filterLayer.classList.remove("lay-show");
});

closeBtn.addEventListener("click", () => {
  filterMenu.classList.remove("popup-container-show");
  filterLayer.classList.remove("lay-show");
});
