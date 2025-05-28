// Enhanced hover effects for desktop
document.addEventListener("DOMContentLoaded", function () {
  const dropdowns = document.querySelectorAll(".dropdown");

  dropdowns.forEach((dropdown) => {
    const menu = dropdown.querySelector(".dropdown-menu");
    let hoverTimeout;

    dropdown.addEventListener("mouseenter", function () {
      clearTimeout(hoverTimeout);
      menu.style.display = "block";
    });

    dropdown.addEventListener("mouseleave", function () {
      hoverTimeout = setTimeout(() => {
        menu.style.display = "none";
      }, 100);
    });
  });

  // Mobile dropdown toggle
  const dropdownToggles = document.querySelectorAll(".dropdown-toggle");
  dropdownToggles.forEach((toggle) => {
    toggle.addEventListener("click", function (e) {
      if (window.innerWidth <= 991) {
        e.preventDefault();
        const menu = this.nextElementSibling;
        menu.style.display = menu.style.display === "block" ? "none" : "block";
      }
    });
  });
});

// type

var text = "Looking for a partner that transforms your business into a brand?";
var index = 0;
var typingSpeed = 60;
var deletingSpeed = 30;
var pauseTime = 1500;
var isDeleting = false;
var target = document.getElementById("typewriter");

function typeLoop() {
  if (!isDeleting) {
    target.innerHTML = text.substring(0, index + 1);
    index++;
    if (index === text.length) {
      isDeleting = true;
      setTimeout(typeLoop, pauseTime); // pause before deleting
      return;
    }
  } else {
    target.innerHTML = text.substring(0, index - 1);
    index--;
    if (index === 0) {
      isDeleting = false;
    }
  }
  setTimeout(typeLoop, isDeleting ? deletingSpeed : typingSpeed);
}

window.onload = typeLoop;

const cards = document.querySelectorAll(".sticky-card-body");

const observer = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("animate");
      }
    });
  },
  {
    threshold: 0.3,
  }
);

cards.forEach((card) => {
  observer.observe(card);
});

// Parallax effect
const rows = document.querySelectorAll(".parallax-row");
let scrollPosition = 0;
let animationId = null;
let isPaused = false;

function animateRows() {
  if (!isPaused) {
    scrollPosition += 1.5;

    rows.forEach((row, index) => {
      const direction = index % 2 === 0 ? -1 : 1;
      const speed = direction * 0.5;
      const position = (scrollPosition * speed) % (row.offsetWidth / 2);
      row.style.transform = `translateX(${position}px)`;
    });
  }

  animationId = requestAnimationFrame(animateRows);
}

animationId = requestAnimationFrame(animateRows);

document.querySelectorAll(".client-card").forEach((card) => {
  card.addEventListener("mouseenter", () => {
    isPaused = true;
  });

  card.addEventListener("mouseleave", () => {
    isPaused = false;
  });
});

window.addEventListener("scroll", () => {
  const scrollY = window.scrollY;

  rows.forEach((row) => {
    const speed = parseFloat(row.getAttribute("data-speed"));
    row.style.transform = `translateX(${
      scrollPosition * (speed < 0 ? -0.5 : 0.5)
    }px) translateY(${scrollY * speed}px)`;
  });
});

var swiperThree = new Swiper(".app-home", {
  loop: true,
  pagination: false,
  autoplay: {
    delay: 3000,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  grabCursor: true,
});
var swiperFour = new Swiper(".websites-swiper", {
  loop: true,
  pagination: false,
  autoplay: {
    delay: 3000,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  grabCursor: true,
});

document.addEventListener("DOMContentLoaded", function () {
  // Get all process steps and cards
  const processSteps = document.querySelectorAll(".process-step");
  const processCards = document.querySelectorAll(".process-card");

  // Add click event listeners to process steps
  processSteps.forEach((step) => {
    step.addEventListener("click", function (e) {
      e.preventDefault();

      // Get the target card ID from the href attribute
      const targetId = this.getAttribute("href");
      const targetCard = document.querySelector(targetId);

      // Scroll to the target card with smooth behavior
      targetCard.scrollIntoView({ behavior: "smooth" });

      // Update active class
      processSteps.forEach((s) => s.classList.remove("active-step"));
      this.classList.add("active-step");
    });
  });

  // Implement scrollspy functionality
  window.addEventListener("scroll", function () {
    // Get current scroll position
    const scrollPosition = window.scrollY;

    // Check which card is currently in view
    processCards.forEach((card, index) => {
      const cardTop = card.offsetTop;
      const cardHeight = card.offsetHeight;

      // If the card is in the viewport
      if (
        scrollPosition >= cardTop - 200 &&
        scrollPosition < cardTop + cardHeight - 200
      ) {
        // Remove active class from all steps
        processSteps.forEach((step) => {
          step.classList.remove("active-step");
        });

        // Add active class to the corresponding step
        processSteps[index].classList.add("active-step");
      }
    });
  });

  // Trigger scroll event on page load to set initial active state
  window.dispatchEvent(new Event("scroll"));
});
