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
