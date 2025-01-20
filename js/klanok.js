function showDescription(event) {
  event.preventDefault();
  const clickedElement = event.currentTarget; //közvetlen azt adja vissza, amihez az eventListener-t hozzá rendeltük
  const elementId = clickedElement.id;

  const infoDiv = document.getElementById(elementId + "-leiras");
  const main = document.getElementById("klanok-leiras");

  if (infoDiv !== null) {
    if (infoDiv.style.display === "flex") {
      infoDiv.style.display = "none";
    } else {
      document.querySelectorAll(".leiras").forEach((div) => {
        div.style.display = "none";
      });
      infoDiv.scrollTop = 0;
      infoDiv.style.display = "flex";
    }
    let seen = false;
    document.querySelectorAll(".leiras").forEach((div) => {
      if (div.style.display !== "none") seen = true;
    });
    if (!seen) {
      main.style.display = "flex";
    } else {
      main.style.display = "none";
    }
  }
}

const classList = document.getElementById("class-list");
const clickableElements = classList.querySelectorAll(".click");

clickableElements.forEach((element) => {
  element.addEventListener("click", showDescription);
});

function showLinks() {
  if (window.innerWidth <= 425 || window.innerHeight <= 425) {
    const linkList = document.getElementById("szerep-lista-m");
    const linkToggle = document.getElementById("lista-toggle");
    const linContainer = document.getElementById("link-container");
    if (
      linContainer.style.display === "none" ||
      linContainer.style.display === ""
    ) {
      linkList.style.opacity = "0";
      linkToggle.style.display = "flex";
      linContainer.style.display = "flex";
    } else {
      linkList.style.opacity = "1";
      linkToggle.style.display = "none";
      linContainer.style.display = "none";
    }
  }
}

const linkList = document.getElementById("szerep-lista-m");
linkList.addEventListener("click", showLinks);
