document.addEventListener("DOMContentLoaded", () => {
    const addKnowledgeButton = document.getElementById("add-knowledge");
    const knowledgeContainer = document.querySelector("#character-info label#knowledge");
    let knowledgeCount = knowledgeContainer.dataset.knowledgeCount; // PHP változó adat attribútumból
  
    // Ismeret hozzáadása
    addKnowledgeButton.addEventListener("click", (e) => {
      e.preventDefault(); // Ne töltsön újra az oldal
      const newKnowledgeDiv = document.createElement("div");
      newKnowledgeDiv.classList.add("knowledge_container");
      newKnowledgeDiv.innerHTML = `
        <select name="knowledge_${knowledgeCount}" style="width: auto;">
          ${knowledgeContainer.dataset.options} <!-- Dinamikus opciók -->
        </select>
        <button type="button" class="remove-knowledge" style="margin-left: 1rem;">Törlés</button>
      `;
      knowledgeContainer.appendChild(newKnowledgeDiv);
      knowledgeCount++; // Növeld az ismeretek számát
  
      // Törlőgomb eseménykezelő hozzáadása
      const removeButton = newKnowledgeDiv.querySelector(".remove-knowledge");
      removeButton.addEventListener("click", () => {
        newKnowledgeDiv.remove(); // Az adott mező eltávolítása
      });
    });
  
    // Törlőgomb eseménykezelő meglévő elemekhez
    document.querySelectorAll(".remove-knowledge").forEach((button) => {
      button.addEventListener("click", (e) => {
        e.target.closest(".knowledge_container").remove();
      });
    });
  });
  