//A leírások megjelenítésére szolgáló funkció

function showDescription(event) {
  event.preventDefault(); //Link alapértelmezett műküdésének megakadályozása
  const targetDivId = this.dataset.target;
  const targetDiv = document.getElementById(targetDivId);
  const infoContainer = document.getElementById("info-container");

  //Különben minden mást is elrejtünk, majd utólag megjelenítjük azt, ami kell
  document.querySelectorAll(".info").forEach((div) => {
    div.classList.remove("visible");
  });
  //Megjelenítjük azt ami kell
  infoContainer.style.display = "flex";
  targetDiv.classList.add("visible");
}

function closeDescription() {
  const infoContainer = document.getElementById("info-container");
  infoContainer.style.display = "none";
}

document
  .getElementById("info-container")
  .addEventListener("click", closeDescription);

document.querySelectorAll('map[name="pelda-map"] area').forEach((area) => {
  area.addEventListener("click", showDescription);
});

//A térkép "dinamikus" méretezésére szolgáló funkció
function resizeMap() {
  const image = document.getElementById("test-map-img");
  const originalWidth = 1920;
  const originalHeight = 1080;
  const widthRatio = image.clientWidth / originalWidth;
  const heightRatio = image.clientHeight / originalHeight;

  document.querySelectorAll('map[name="pelda-map"] area').forEach((area) => {
    const originalCoords = area.dataset.coords.split(",").map(Number);
    const resizedCoords = originalCoords.map((coord, index) =>
      index % 2 === 0 ? coord * widthRatio : coord * heightRatio
    );
    area.coords = resizedCoords.join(",");
  });
}

//Eredeti koordináták mentése
document.querySelectorAll('map[name="pelda-map"] area').forEach((area) => {
  area.dataset.coords = area.coords;
});

//Koordináták átméretezése ablak méretváltoztatáskor
window.addEventListener("resize", resizeMap);
window.addEventListener("load", resizeMap);
