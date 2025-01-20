function showProfileMenu() {
  const profileMenu = document.getElementById("profile-menu");
  const profileMenuContainer = document.getElementById(
    "profile-menu-container"
  );

  profileMenu.style.display = "flex";
  profileMenuContainer.style.display = "flex";
}

function closeProfileMenu() {
  const profileMenuContainer = document.getElementById(
    "profile-menu-container"
  );
  profileMenuContainer.style.display = "none";
}
if (document.querySelector("div[id='desktop-profile-menu']") !== null) {
  document
    .querySelector("div[id='desktop-profile-menu']")
    .addEventListener("click", showProfileMenu);
}

if (document.getElementById("profile-menu-container") !== null) {
  document
    .getElementById("profile-menu-container")
    .addEventListener("click", closeProfileMenu);
}

function showMobileMenu(event) {
  const mobileMenu = document.getElementById("mobile-menu-container");

  if (mobileMenu.classList.contains("visible")) {
    mobileMenu.classList.remove("visible");
  } else {
    mobileMenu.classList.add("visible");
  }
}
document
  .querySelector('div[id="mobile-menu"]')
  .addEventListener("click", showMobileMenu);
