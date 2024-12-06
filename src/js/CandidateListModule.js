document.querySelectorAll(".nav-link").forEach((link) => {
  link.addEventListener("click", function (event) {
    event.preventDefault(); // Prevent default link behavior

    // Get the category from the data attribute
    const category = this.getAttribute("data-category");

    // Update the URL with the selected category
    window.history.pushState({}, "", `?category=${category}`);

    // Fetch and display the candidates for the selected category
    fetchCandidates(category);
  });
});

function fetchCandidates(category) {
  // You can implement AJAX here to fetch and update the candidates dynamically
  // For now, this function is a placeholder
  console.log(`Fetching candidates for category: ${category}`);
}
