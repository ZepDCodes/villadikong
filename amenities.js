// Toggle room or pool cards with smooth animation + scroll
function toggleCards(type) {
  const cards = document.getElementById(type + "-cards");

  cards.classList.toggle("show");

  // If now expanded, scroll smoothly into view
  if (cards.classList.contains("show")) {
    setTimeout(() => {
      cards.scrollIntoView({ behavior: "smooth", block: "end" });
    }, 300); // wait for animation
  }
  
}

// Open modal with image + caption
function openModal(imgSrc, caption) {
  const modal = document.getElementById("amenityModal");
  document.getElementById("modalImg").src = imgSrc;
  document.getElementById("modalCaption").textContent = caption;
  modal.classList.add("show");
}

// Close modal
function closeModal() {
  document.getElementById("amenityModal").classList.remove("show");
}

// Close modal when clicking outside image
window.onclick = function(event) {
  const modal = document.getElementById("amenityModal");
  if (event.target === modal) {
    closeModal();
  }
};

// Close modal with ESC key
window.addEventListener("keydown", function(event) {
  if (event.key === "Escape") {
    closeModal();
  }
});
