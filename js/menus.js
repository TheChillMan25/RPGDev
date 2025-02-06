//-----------------Desktop------------------//
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
if (document.getElementById("desktop-profile-menu") !== null) {
  document
    .querySelector("div[id='desktop-profile-menu']")
    .addEventListener("click", showProfileMenu);
}

if (document.getElementById("profile-menu-container") !== null) {
  document
    .getElementById("profile-menu-container")
    .addEventListener("click", closeProfileMenu);
}

//------------------Mobil----------------//
if (document.getElementById("m-menu") !== null) {
  document.getElementById("m-menu").addEventListener("click", showMobileMenu);
}
if (document.getElementById("m-link-c") !== null) {
  document
    .getElementById("m-link-c")
    .addEventListener("click", closeMobileMenu);
}

function showMobileMenu() {
  const container = document.getElementById("m-link-c");
  const menu = document.getElementById("m-link-m");

  container.style.display = "flex";
  menu.style.display = "flex";
}

function closeMobileMenu() {
  const container = document.getElementById("m-link-c");
  container.style.display = "none";
}

//------------Mobil profil---------------------//

if (document.getElementById("mcv-btn") !== null) {
  document.getElementById("mcv-btn").addEventListener("click", showMCharacters);
}

if (document.getElementById("mpv-btn") !== null) {
  document.getElementById("mpv-btn").addEventListener("click", showMProfile);
}

function showMCharacters() {
  const mCharacters = document.getElementById("character-container");
  const mProfile = document.getElementById("profile-container");

  if (
    mCharacters.style.display === "none" ||
    mCharacters.style.display === ""
  ) {
    mCharacters.style.display = "flex";
    mProfile.style.display = "none";
  } else {
    return;
  }
}

function showMProfile() {
  const mCharacters = document.getElementById("character-container");
  const mProfile = document.getElementById("profile-container");

  if (mProfile.style.display === "none" || mProfile.style.display === "") {
    mCharacters.style.display = "none";
    mProfile.style.display = "flex";
  } else {
    return;
  }
}
