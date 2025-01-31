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

if (document.getElementById("add-character")) {
  document
    .getElementById("add-character")
    .addEventListener("click", startCharacterCreation);
}

if (document.getElementById("character-creation-intro") !== null) {
  document
    .getElementById("character-creation-intro")
    .addEventListener("click", closeCharacterCreation);
}

function startCharacterCreation() {
  const container = document.getElementById("intro-container");
  const mainContainer = document.getElementById("character-creation-intro");

  mainContainer.style.display = "flex";
  container.style.display = "flex";
}

function closeCharacterCreation() {
  const mainContainer = document.getElementById("character-creation-intro");
  mainContainer.style.display = "none";
}
