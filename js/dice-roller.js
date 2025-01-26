if (document.getElementById("dice-roller-btn") !== null) {
  document
    .getElementById("dice-roller-btn")
    .addEventListener("click", showDiceRoller);
}

function showDiceRoller() {
  const diceRollerContainer = document.getElementById("dice-roller");

  if (
    diceRollerContainer.style.display === "none" ||
    diceRollerContainer.style.display === ""
  ) {
    diceRollerContainer.style.display = "flex";
  } else {
    diceRollerContainer.style.display = "none";
  }
}

const diceButtons = document.querySelectorAll("#dice-btn-c button");

diceButtons.forEach((button) => {
  button.addEventListener("click", function () {
    const diceValue = parseInt(button.getAttribute("data-value"));
    rollDice(diceValue);
  });
});

if (document.getElementById("empty-rolls") !== null) {
  document.getElementById("empty-rolls").addEventListener("click", function () {
    emptyRolls();
  });
}

function emptyRolls() {
  currentRolls = [];
  rolls = [];
  document.getElementById("current-roll").innerHTML = "X";
  document.getElementById("rolls").innerHTML = "X | X | X";
}

var rolls = [];

var prevValue = 0;

function rollDice(value) {
  if (rolls.length < 8) {
    let currentRolls = [];
    prevValue = value;
    var double = document.getElementById("double").checked ? 2 : 1;
    for (let i = 0; i < double; i++) {
      currentRolls.push(Math.floor(Math.random() * value) + 1);
    }

    if (double === 2) {
      rolls.push(currentRolls[0] + currentRolls[1]);
    } else {
      rolls.push(currentRolls);
    }
    document.getElementById("current-roll").innerHTML =
      currentRolls.join(" + ");
    document.getElementById("rolls").innerHTML = rolls.join(" | ");
  } else {
    emptyRolls();
    rollDice(prevValue);
  }
}
