function showMenu(event) {
  event.preventDefault();
  const plus = document.getElementById("plus");
  const minus = document.getElementById("minus");
  var num = document.getElementById("num");

  if (event.target.id === "plus") {
    num.innerHTML = parseInt(num.innerHTML) + 1;
  } else if (event.target.id === "minus") {
    num.innerHTML = parseInt(num.innerHTML) - 1;
  }
}

document.getElementById("plus").addEventListener("click", showMenu);
document.getElementById("minus").addEventListener("click", showMenu);
