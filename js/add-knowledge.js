document.addEventListener("DOMContentLoaded", () => {
  const addKnowledgeButton = document.getElementById("add-knowledge");
  const knowledgeContainer = document.querySelector("#knowledge");
  let knowledgeCount = parseInt(knowledgeContainer.dataset.knowledgeCount, 10); // PHP változó adat attribútumból

  const knowledgeOptions = knowledgeContainer.dataset.options
    .replace(/&lt;/g, "<")
    .replace(/&gt;/g, ">")
    .replace(/&quot;/g, '"')
    .replace(/&#39;/g, "'")
    .replace(/&amp;/g, "&");

  const lvlOptions = knowledgeContainer.dataset.lvlOptions
    .replace(/&lt;/g, "<")
    .replace(/&gt;/g, ">")
    .replace(/&quot;/g, '"')
    .replace(/&#39;/g, "'")
    .replace(/&amp;/g, "&");

  let knowledgeIDList = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

  // Ismeret hozzáadása
  addKnowledgeButton.addEventListener("click", (e) => {
    if (knowledgeCount < 10) {
      e.preventDefault(); // Ne töltsön újra az oldal
      const newKnowledgeDiv = document.createElement("div");
      const knowledgeID = knowledgeIDList.shift(); // Az első elemet veszi ki és adja hozzá
      newKnowledgeDiv.classList.add("knowledge_container");
      newKnowledgeDiv.innerHTML = `
        <select name="knowledge_${knowledgeID}" style="width: 80%; height: 3rem;">
          ${knowledgeOptions}
        </select>
        <select name="knowledge_lvl_${knowledgeID}" style="width: 3rem; height: 3rem;">
          ${lvlOptions}
        </select>
        <button type="button" class="remove-knowledge">X</button>
      `;
      knowledgeContainer.appendChild(newKnowledgeDiv);
      knowledgeCount++; // Növeld az ismeretek számát

      // Törlőgomb eseménykezelő hozzáadása
      const removeButton = newKnowledgeDiv.querySelector(".remove-knowledge");
      removeButton.addEventListener("click", () => {
        newKnowledgeDiv.remove(); // Az adott mező eltávolítása
        knowledgeIDList.push(knowledgeID); // Az eltávolított ID visszaadása a tömbbe
        knowledgeIDList.sort((a, b) => a - b); // Rendezés növekvő sorrendbe
        knowledgeCount--;
      });
    }
  });

  // Törlőgomb eseménykezelő meglévő elemekhez
  document.querySelectorAll(".remove-knowledge").forEach((button) => {
    button.addEventListener("click", (e) => {
      const knowledgeDiv = e.target.closest(".knowledge_container");
      const selectElement = knowledgeDiv.querySelector(
        "select[name^='knowledge_']"
      );
      const knowledgeID = parseInt(selectElement.name.split("_")[1], 10);
      knowledgeDiv.remove();
      knowledgeIDList.push(knowledgeID); // Az eltávolított ID visszaadása a tömbbe
      knowledgeIDList.sort((a, b) => a - b); // Rendezés növekvő sorrendbe
      knowledgeCount--;
    });
  });
});
