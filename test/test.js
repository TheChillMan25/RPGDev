//A leírások megjelenítésére szolgáló funkció

function showDescription(event) {
  event.preventDefault(); //Link alapértelmezett műküdésének megakadályozása
  const targetDivId = this.dataset.target;
  const targetDiv = document.getElementById(targetDivId);

  //maximális magasságot állítok be a leírásokra, se le nem lóg túl a képernyőn, se a navbar alá nem csúszik be
  const navbar = document.getElementsByClassName("navbar")[0];
  const newHeight = 100 - (navbar.offsetHeight / window.innerHeight) * 100;

  //Ellenőrzés a leírások láthatóságára
  if (targetDiv.classList.contains("visible")) {
    //Ha ugyan arra a leírásra kattintunk, akkor elrejtjük
    targetDiv.classList.remove("visible");
  } else {
    //Különben minden mást is elrejtünk, majd utólag megjelenítjük azt, ami kell
    document.querySelectorAll(".info").forEach((div) => {
      div.classList.remove("visible");
    });
    //Megjelenítjük azt ami kell
    targetDiv.classList.add("visible");
    if (window.innerWidth >= 768) {
      targetDiv.style.height = newHeight + "vh";
    }
  }
}

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
