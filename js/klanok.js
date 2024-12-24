function showDescription(event) {
  event.preventDefault();
  const clickedElement = event.currentTarget; //közvetlen azt adja vissza, amihez az eventListener-t hozzá rendeltük
  const elementId = clickedElement.id;

  const infoDiv = document.getElementById(elementId + "-leiras");
  const main = document.getElementById("klanok-leiras");

  if (infoDiv !== null) {
    if (infoDiv.classList.contains("visible")) {
      infoDiv.classList.remove("visible");
    } else {
      document.querySelectorAll(".leiras").forEach((div) => {
        div.classList.remove("visible");
      });
      infoDiv.classList.add("visible");
    }
    let seen = false;
    document.querySelectorAll(".leiras").forEach((div) => {
      if (div.classList.contains("visible")) seen = true;
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
