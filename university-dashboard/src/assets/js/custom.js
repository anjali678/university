// assets/js/custom.js

document.addEventListener('DOMContentLoaded', function() {
  // Handle custom dropdown toggle
  const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

  dropdownToggles.forEach((dropdown) => {
    dropdown.addEventListener('click', function (event) {
      const dropdownMenu = this.nextElementSibling; // Get the corresponding dropdown menu

      // Toggle the 'show' class to display or hide the dropdown
      dropdownMenu.classList.toggle('show');

      // Optionally, handle aria-expanded state
      const isExpanded = dropdownMenu.classList.contains('show');
      this.setAttribute('aria-expanded', isExpanded);
    });
  });

  // Close dropdowns when clicking outside
  document.addEventListener('click', function(event) {
    dropdownToggles.forEach((dropdown) => {
      const dropdownMenu = dropdown.nextElementSibling;
      if (!dropdown.contains(event.target) && !dropdownMenu.contains(event.target)) {
        dropdownMenu.classList.remove('show');
        dropdown.setAttribute('aria-expanded', 'false');
      }
    });
  });
});
