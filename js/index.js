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
  const steps = document.querySelectorAll(".process-step");
  const leftHeading = document.getElementById("left-heading");
  const leftList = document.getElementById("left-list");

  // Data for left card content corresponding to each tab on the right
  const contentData = [
    {
      heading: "Development",
      items: [
        "Website Designing & Development",
        "Web Application Development",
        "Web Portals Development",
        "Customized CRM Development",
        "Customized Lead Management System",
        "Mobile Application Development",
        "E-commerce Development",
      ],
    },
    {
      heading: "Marketing",
      items: [
        "SMM | SEO | SEM | SMO",
        "Google My Business (GMB) Optimization",
        "WhatsApp Marketing & Automation",
        "WhatsApp API Integration",
        "WhatsApp Blue Tick Verification",
        "Personal Branding",
        "UGC Ads",
        "ATL, BTL, TTL Marketing",
      ],
    },
    {
      heading: "PR & Advertising",
      items: [
        "Design• Media Buying",
        "Outdoor Advertising",
        "Print Media Advertising",
        "Digital & Mobile Advertising",
        "Cinema Advertising",
        "Radio Advertising",
        "Wikipedia Page Creation",
        "Google Knowledge Panel Creation",
      ],
    },
    {
      heading: "Creative Design & Video",
      items: [
        "Logo Designing",
        "Graphic Designing",
        "Animation",
        "Video Editing",
        "Collateral Design",
        "Brochure/Catalogue Design",
        "Company Profile Design",
      ],
    },
  ];

  // Function to animate content change
  function animateContentChange(index) {
    const card = document.querySelector(".process-card");

    // Add animation classes to card container
    card.classList.add("card-animate-enter");

    // After a short delay, update the content
    setTimeout(() => {
      // Update heading
      leftHeading.textContent = contentData[index].heading;

      // Update list items
      leftList.innerHTML = "";
      contentData[index].items.forEach((item) => {
        const li = document.createElement("li");
        li.textContent = item;
        leftList.appendChild(li);
      });

      // Trigger animation active state on next frame
      requestAnimationFrame(() => {
        card.classList.add("card-animate-enter-active");
      });

      // Remove animation classes after animation completes (0.5s)
      setTimeout(() => {
        card.classList.remove("card-animate-enter");
        card.classList.remove("card-animate-enter-active");
      }, 500);
    }, 200);
  }

  steps.forEach((step) => {
    step.addEventListener("click", function () {
      // Remove active class from all
      steps.forEach((s) => s.classList.remove("active-step"));

      // Add active class to clicked tab
      this.classList.add("active-step");

      // Get index of clicked tab
      const index = parseInt(this.getAttribute("data-index"), 10);

      // Animate content update
      animateContentChange(index);
    });
  });

  // Initialize with first tab content
  animateContentChange(0);
});
