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

const swiper = new Swiper(".testimonial-swiper", {
  slidesPerView: 1,
  spaceBetween: 2,
  loop: false,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  autoplay: {
    delay: 5000,
    disableOnInteraction: false,
  },
  breakpoints: {
    640: {
      slidesPerView: 1,
      spaceBetween: 20,
    },
    768: {
      slidesPerView: 2,
      spaceBetween: 30,
    },
    1200: {
      slidesPerView: 3,
      spaceBetween: 40,
    },
  },
});

const testimonials = [
  {
    name: "Michael Pinkel",
    title: "Founder & CEO, P.S.I. Selling",
    message:
      "Completed the project successfully, productive discussions on creative direction.",
  },
  {
    name: "Aditi Ankolekar",
    title: "National Marketing Specialist, KPMG",
    message:
      "Saloni was a treat to work with. Very impressed with the presentation.",
  },
  {
    name: "April Lea",
    title: "CEO & Founder, The Neurodiversity Network",
    message:
      "Saloni has an exceptional eye for accessible design and always delivers quality work.",
  },
  {
    name: "Saloni",
    title: "CEO & Founder, Get Sponsorship",
    message:
      "Professional and communicates well. Was a great experience working together!",
  },
];

function createTestimonialCard(testimonial) {
  return `
      <div class="testimonial-card mb-4">
        <div class="profile-section">
          <div class="profile-img">
            <img src="img/michael-pinkel.png" alt="Profile Image" />
          </div>
          <div class="profile-info">
            <h4>${testimonial.name}</h4>
            <p>${testimonial.title}</p>
          </div>
        </div>
        <div class="testimonial-content">
          <p>${testimonial.message}</p>
        </div>
      </div>
    `;
}

const marqueeLeft = document.getElementById("marqueeLeft");
const marqueeRight = document.getElementById("marqueeRight");

let leftHTML = "";
let rightHTML = "";

// Duplicate content twice for seamless infinite scroll
for (let i = 0; i < 2; i++) {
  testimonials.forEach((testimonial) => {
    const card = createTestimonialCard(testimonial);
    leftHTML += card;
    rightHTML += card;
  });
}

marqueeLeft.innerHTML = leftHTML;
marqueeRight.innerHTML = rightHTML;

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

$(".logo-section1")
  .eq(0)
  .slick({
    dots: false,
    infinite: true,
    autoplay: true,
    autoplaySpeed: 0,
    speed: 3000,
    slidesToShow: 6,
    slidesToScroll: 1,
    centerMode: true,
    cssEase: "linear",
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 6,
        },
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 3,
        },
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 2,
        },
      },
    ],
  });

$(".logo-section1")
  .eq(1)
  .slick({
    rtl: true,
    dots: false,
    infinite: true,
    autoplay: true,
    autoplaySpeed: 0,
    speed: 3000,
    slidesToShow: 6,
    slidesToScroll: 1,
    centerMode: true,
    cssEase: "linear",
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 6,
        },
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 3,
        },
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 2,
        },
      },
    ],
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

// websites-swiper
