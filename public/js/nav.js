// Toggle Mobile Menu
const menuToggle = document.getElementById("menu-toggle");
const mobileMenu = document.getElementById("mobile-menu");
const menuClose = document.getElementById("menu-close");

menuToggle.addEventListener("click", () => {
  mobileMenu.classList.add("open"); // Add 'open' class to show mobile menu
});

menuClose.addEventListener("click", () => {
  mobileMenu.classList.remove("open"); // Remove 'open' class to hide mobile menu
});

// Close the mobile menu if the user clicks outside of it
document.addEventListener("click", (event) => {
  if (
    !mobileMenu.contains(event.target) &&
    !menuToggle.contains(event.target) // Check if the click is outside the menu toggle and menu itself
  ) {
    mobileMenu.classList.remove("open"); // Close mobile menu if clicked outside
  }
});

// Toggle Search Bar for Mobile
const searchToggle = document.getElementById("search-toggle");
const searchBar = document.getElementById("search-bar");

if (searchToggle) {
  searchToggle.addEventListener("click", (event) => {
    event.stopPropagation(); // Prevent the event from bubbling up to document
    searchBar.classList.toggle("active"); // Toggle the 'active' class to show/hide search bar
  });
}

// Close search bar if clicked outside
document.addEventListener("click", (event) => {
  if (
    !searchBar.contains(event.target) && // If the click is outside the search bar
    !searchToggle.contains(event.target) // If the click is outside the search toggle
  ) {
    searchBar.classList.remove("active"); // Hide search bar
  }
});
