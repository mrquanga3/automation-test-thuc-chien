/* eslint-disable no-undef */
const searchInput = $("#search-input");
const searchButton = $("#search-button");

searchInput.on("input", () => {
  displaysSearchResult(searchInput.val());
});

searchButton.on("click", () => {
  displaysSearchResult(searchInput.val());
});

searchInput.on("keydown", (event) => {
  if (event.key === "Enter") {
    displaysSearchResult(searchInput.val());
    event.preventDefault();
  }
});

function displaysSearchResult(searchInput) {
  const searchQuery = { search: searchInput.trim() };
  $.ajax({
    type: "GET",
    url: "/examples",
    data: searchQuery,
    success: function (result) {
      const sections = document.getElementById("examples-sections");
      sections.innerHTML = result;
    },
    error: function (xhr) {
      console.log(xhr);
      location.reload();
    }
  });
}
