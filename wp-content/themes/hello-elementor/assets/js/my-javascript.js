// select post hide in home all post
const selectPost = document.querySelector(".home-post-feature .wpr-grid-item");

const selectPostHomes = document.querySelectorAll(".home-all-post .wpr-grid-item");

if (selectPost && selectPostHomes) {
  const selectPostValues = selectPost.classList.value;
  selectPostHomes.forEach(function (selectPostHome) {
    if (selectPostHome.classList.value === selectPostValues) {
      selectPostHome.style.display = "none";
      selectPostHomes[3].classList.add("change-style-position");
    }
  });
}
// wrap text in content
let contentElements = document.querySelectorAll(".post-hire .wpr-grid-item .wpr-grid-item-inner .wpr-grid-item-excerpt p");
if (contentElements !== null) {
  contentElements.forEach(function (contentElement) {
    text = contentElement.innerHTML;
    textReplace1 = text.replaceAll(". ", ".<br/>");
    textReplace2 = textReplace1.replaceAll(":.", ":");
    contentElement.innerHTML = textReplace2;
  });
}

// category tuyển dụng
let contentElementsHire = document.querySelectorAll(".category-tuyen-dung .wpr-grid-item .wpr-grid-item-inner .wpr-grid-item-excerpt p");
if (contentElementsHire !== null) {
  contentElementsHire.forEach(function (contentElementHire) {
    text = contentElementHire.innerHTML;
    textReplaceHire = text.replaceAll(". ", ".<br/>");
    contentElementHire.innerHTML = textReplaceHire;
  });
}

var contentDetails = document.querySelector(".category-tuyen-dung .wpr-post-content");
if (contentDetails) {
  var contentDetailsText = contentDetails.innerHTML;
  var contentDetailsTextReplace = contentDetailsText.replace(":.", ":<br/>");
  contentDetails.innerHTML = contentDetailsTextReplace;
}


// wrap text in content medicine home page
let contentElementsHome = document.querySelectorAll(".home-medicine .wpr-grid-item .wpr-grid-item-inner .wpr-grid-item-excerpt p");
if (contentElementsHome !== null) {
  contentElementsHome.forEach(function (contentElementHome) {
    textHome = contentElementHome.innerHTML;
    textReplaceHome = textHome.replaceAll(". ", ".<br/>");
    contentElementHome.innerHTML = textReplaceHome;
  });
}

// wrap text in contents user product
let contentElementUserProduct = document.querySelector(".content-user");
if (contentElementUserProduct) {
  textUserProduct = contentElementUserProduct.innerHTML;
  textReplaceUserProduct = textUserProduct.replaceAll(". ", ".<br/>");
  contentElementUserProduct.innerHTML = textReplaceUserProduct;
}

// cây thư mục Category
let parentCats = document.querySelectorAll(".sidebar-post-category .elementor-widget-container > ul > li");
let parentCatLinks = document.querySelectorAll(".sidebar-post-category .elementor-widget-container > ul > li > a");

if (parentCats.length !== 0) {
  parentCats.forEach(function (parentCat) {
    parentCat.onclick = function () {
      let childCat = document.querySelector(".sidebar-post-category .cat-item .children");
      let checkShowChild = childCat.classList.contains("showCat");
      if (checkShowChild) {
        childCat.classList.remove("showCat");
      } else {
        childCat.classList.add("showCat");
      }
    };

    parentCatLinks.forEach(function (parentCatLink) {
      parentCatLink.addEventListener("click", function (event) {
        event.preventDefault();
      });
    });
  });
}

// header search
let headerSearchIcon = document.querySelector(".header-search-icon .elementor-icon-wrapper");
let headerSearch = document.querySelector(".header-search");

headerSearchIcon.onmouseover = function () {
  headerSearch.style.opacity = "1";
};
headerSearch.onmouseover = function () {
  headerSearch.style.opacity = "1";
};

headerSearch.onmouseout = function () {
  headerSearch.style.opacity = "0";
};
headerSearchIcon.onmouseout = function () {
  headerSearch.style.opacity = "0";
};

// handle header search when input is empty
const inputHeaderSearch = document.getElementById("is-search-input-1178");
const btnHeaderSearch = document.querySelector(".header-search .is-search-submit");
if (inputHeaderSearch.value === "") {
  btnHeaderSearch.disabled = true;
  btnHeaderSearch.style.opacity = "0.7";
}
inputHeaderSearch.oninput = function () {
  if (inputHeaderSearch.value === "") {
    btnHeaderSearch.disabled = true;
    btnHeaderSearch.style.opacity = "0.7";
  } else {
    btnHeaderSearch.disabled = false;
    btnHeaderSearch.style.opacity = "1";
  }
};

// button back top top
// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function () {
  scrollFunction();
};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    document.getElementById("back-to-top").style.display = "block";
  } else {
    document.getElementById("back-to-top").style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}

// comment form
var getNameComment = document.querySelector(".wpr-comment-form-author label");
if (getNameComment != null) {
  getNameComment.innerHTML = "Họ tên *";
}
var getContentComment = document.querySelector(".wpr-comment-form-text label");
if (getContentComment != null) {
  getContentComment.innerHTML = "Nội dung *";
}

// get breadcumb
var getBreadcumb = document.querySelectorAll(".woocommerce-breadcrumb a");

// get tab Dược liệu
var getTabMedicine = document.querySelector(".menu-item-29 .wpr-menu-item");
var getTabMedicineMobile = document.querySelector(".menu-item-29 .wpr-mobile-menu-item");
var getTitleRelated = document.querySelector(".related > h2");

if (getBreadcumb[0] != null) {
  if (getBreadcumb[1].innerHTML == "Dược liệu") {
    getTabMedicine.classList.add("wpr-active-menu-item");
    getTabMedicineMobile.classList.add("wpr-active-menu-item");
    if (getTitleRelated != null) {
      getTitleRelated.innerHTML = "Dược liệu tương tự";
    }

  }
}
// get tab Sản phẩm
// get tab Sản phẩm
var getTabProduct = document.querySelector(".menu-item-32 .wpr-menu-item");
var getTabProductMobile = document.querySelector(".menu-item-32 .wpr-mobile-menu-item");
if (getBreadcumb[0] != null) {
  if (getBreadcumb[1].innerHTML == "Sản phẩm") {
    var getTabDescription = document.querySelector(".description_tab a");
    if (getTabDescription) {
      getTabDescription.innerHTML = "Cách dùng";
    }
    if (getTabProduct) {
      getTabProduct.classList.add("wpr-active-menu-item");
    }
    if (getTabProductMobile) {
       getTabProductMobile.classList.add("wpr-active-menu-item");
    }

  }
}

// get tab Tin tức
var getBreadcumbPage = document.querySelectorAll(".get-breadcumb-content span span a");

var getTabNews = document.querySelector(".menu-item-33 .wpr-menu-item");
var getTabNewsMobile = document.querySelector(".menu-item-33 .wpr-mobile-menu-item");

if (getBreadcumbPage[0] != null) {
  if (getBreadcumbPage[1].innerHTML == "Tin tức") {
    getTabNews.classList.add("wpr-active-menu-item");
    getTabNewsMobile.classList.add("wpr-active-menu-item");
  }
}

// get tab Tuyển dụng
var getTabHire = document.querySelector(".menu-item-3971 .wpr-menu-item");
var getTabHireMobile = document.querySelector(".menu-item-3971 .wpr-mobile-menu-item");
if (getBreadcumbPage[0] != null) {
  if (getBreadcumbPage[1].innerHTML == "Tuyển dụng") {
    getTabHire.classList.add("wpr-active-menu-item");
    getTabHireMobile.classList.add("wpr-active-menu-item");
  }
}

// handle seach dược liệu
const inputMedicine = document.getElementById("is-search-input-1199");
const btnMedicineSearch = document.querySelector(".search-medicine .is-search-submit");
if (inputMedicine.value === "") {
  btnMedicineSearch.disabled = true;
  btnMedicineSearch.style.opacity = "0.7";
}
inputMedicine.oninput = function () {
  if (inputMedicine.value === "") {
    btnMedicineSearch.disabled = true;
    btnMedicineSearch.style.opacity = "0.7";
  } else {
    btnMedicineSearch.disabled = false;
    btnMedicineSearch.style.opacity = "1";
  }
};
