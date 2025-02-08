if (document.getElementById("throw-container") !== null) {
  document
    .getElementById("throw-container")
    .addEventListener("click", hideRoll);
}

const stats = document.querySelectorAll("#stats .stat");
stats.forEach((div) => {
  div.addEventListener("click", function () {
    const modifierValue = parseInt(div.getAttribute("data-value-mod"));
    const checkName = div.getAttribute("id");
    rollCheck(modifierValue, checkName);
  });
});

function hideRoll() {
  document.getElementById("throw-container").style.display = "none";
}

function showRoll(title, value) {
  document.getElementById("throw-container").style.display = "flex";
  document.getElementById("throw").style.display = "flex";

  const throwTitle = document.getElementById("throw-title");
  const throwValue = document.getElementById("throw-value");
  throwTitle.innerHTML = title;
  throwValue.innerHTML = value;
}

function rollCheck(modifier, checkName) {
  let checkValue = Math.floor(Math.random() * 20) + 1;
  if (checkValue <= 1) {
    checkValue = 1;
  } else {
    checkValue += modifier;
  }
  let title = checkName[0].toUpperCase() + checkName.slice(1) + " check";
  showRoll(title, checkValue);
}

const weapons = document.querySelectorAll("span.weapon");
weapons.forEach((span) => {
  const diceDesc = span.getAttribute("data-dice-desc");
  if (diceDesc !== "-") {
    span.style.cursor = "pointer";
    span.addEventListener("click", function () {
      const wepType = span.getAttribute("data-weapon-type");
      let rollNum = 0;
      let dice = "";
      let diceNumCheck = true;
      for (let i = 0; i < diceDesc.length; i++) {
        if (diceNumCheck && diceDesc[i] === "d") diceNumCheck = false;
        else if (diceNumCheck) rollNum = parseInt(diceDesc[i]);
        else dice += diceDesc[i];
      }
      dice = parseInt(dice);
      attackRoll(rollNum, dice, wepType);
    });
  }
});

function attackRoll(rollNum, dice, type) {
  let roll = 0;

  for (let i = 0; i < rollNum; i++) {
    roll += Math.floor(Math.random() * dice) + 1;
  }
  let mod;
  if (type === "melee") {
    mod = parseInt(
      document.getElementById("strength").getAttribute("data-value-mod")
    );
  } else if (type === "ranged") {
    mod = parseInt(
      document.getElementById("dexterity").getAttribute("data-value-mod")
    );
  } else {
    mod = 0;
  }
  roll += mod;
  showRoll("Támadás check", roll);
}

function defendRoll() {}
