if (document.getElementById("throw-container") !== null) {
  document
    .getElementById("throw-container")
    .addEventListener("click", hideRoll);
}

const stats = document.querySelectorAll("#stats .stat");
stats.forEach((div) => {
  div.addEventListener("click", function () {
    const modifierValue = parseInt(div.getAttribute("data-value"));
    const checkName = div.getAttribute("id");
    rollCheck(modifierValue, checkName);
  });
});

function hideRoll() {
  document.getElementById("throw-container").style.display = "none";
}

function showRoll() {
  document.getElementById("throw-container").style.display = "flex";
  document.getElementById("throw").style.display = "flex";
}

function rollCheck(modifier, checkName) {
  const checkValue = Math.floor(Math.random() * 20) + 1 + modifier;
  showRoll();
  const throwTitle = document.getElementById("throw-title");
  const throwValue = document.getElementById("throw-value");

  throwTitle.innerHTML =
    checkName[0].toUpperCase() + checkName.slice(1) + " check";
  throwValue.innerHTML = checkValue;
}
