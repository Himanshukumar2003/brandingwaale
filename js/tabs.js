const tabs = document.querySelectorAll(".product-tab");
const contents = document.querySelectorAll(".product-content");

tabs.forEach((tab) => {
  tab.addEventListener("click", () => {
    // Remove active class from all tabs
    tabs.forEach((t) => t.classList.remove("active"));
    // Add active class to clicked tab
    tab.classList.add("active");

    // Hide all product contents
    contents.forEach((content) => content.classList.remove("active"));
    // Show the content related to clicked tab
    const activeContent = document.getElementById(tab.getAttribute("data-tab"));
    if (activeContent) activeContent.classList.add("active");
  });
});
