function showMenu(event) {
  const mobileMenu = document.getElementById("mobile-menu-container");

  if (mobileMenu.classList.contains("visible")) {
    mobileMenu.classList.remove("visible");
  } else {
    mobileMenu.classList.add("visible");
  }
}
document
  .querySelector('div[id="mobile-menu"]')
  .addEventListener("click", showMenu);
