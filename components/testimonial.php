  <div class="testimonial-section">
      <div class="container-fluid">
          <div class="row">
              <!-- Heading -->
              <div class="col-lg-4 d-flex align-items-center">
                  <div class="heading-content">
                      <h2>INSPIRING<br />TRUST</h2>
                      <h3>THROUGH EXPERIENCES</h3>
                  </div>
              </div>

              <!-- Marquee Left -->
              <div class="col-lg-4">
                  <div class="testimonial-wrapper">
                      <div class="testimonial-marquee" id="marqueeLeft"></div>
                  </div>
              </div>

              <!-- Marquee Right -->
              <div class="col-lg-4">
                  <div class="testimonial-wrapper">
                      <div class="testimonial-marquee reverse" id="marqueeRight"></div>
                  </div>
              </div>
          </div>
      </div>
  </div>





  <script>
      const testimonials = [{
              name: "Naveen Singh",
              title: "Client Review",
              message: "Brandingwaale Webtech Company provides very professional and reliable services. Their website design, SEO, and digital marketing work are excellent. Communication was clear and results were delivered on time. Highly recommended!",
          },
          {
              name: "Toshik Dhanurkar",
              title: "Client Review",
              message: "They do top class work. Special appreciation to Sandeep who understands the requirements completely. Very soft spoken and impressive team.",
          },
          {
              name: "Aman Deep",
              title: "Client Review",
              message: "Brandingwaale Webtech transformed our online presence. Their designs are modern and strategically crafted. Highly recommended!",
          },
          {
              name: "Deepanshu Giri",
              title: "Client Review",
              message: "Great experience! Brandingwaale Webtech delivered excellent website and SEO work. Very professional team.",
          },
          {
              name: "Sanjan Kumari",
              title: "Client Review",
              message: "We got our SEO and paid ads handled by Brandingwaale and within a few months we started seeing a solid increase in traffic and leads. They keep you updated every step of the way.",
          },
          {
              name: "Anish Kumar Pathak",
              title: "Client Review",
              message: "They handled our website development project very professionally. The team understood our requirements clearly and delivered a clean, responsive, and fast website.",
          },
          {
              name: "Abhii",
              title: "Client Review",
              message: "Amazing service! Clean design, good SEO results, and a very supportive team.",
          },
          {
              name: "RaBul Gamer",
              title: "Client Review",
              message: "Highly satisfied with their website and digital marketing services. Professional and trustworthy.",
          },
          {
              name: "Subhashree Roul",
              title: "Client Review",
              message: "Our Pune team needed a catalogue and collateral designed. Super quick turnaround and very neat designs. Loved working with them!",
          },
          {
              name: "Mano Harshith Podalakuru",
              title: "Client Review",
              message: "We had no idea digital marketing could impact our business so much until we saw the results from their campaigns.",
          },
          {
              name: "Mansi Singh",
              title: "Client Review",
              message: "Their meticulous approach to website development and social media management increased our online visibility and engagement. Truly grateful for their partnership.",
          },
          {
              name: "Sibu Narayan Dash",
              title: "Client Review",
              message: "Our Noida branch used their PR services for media coverage. Got featured in good portals and the branding improved a lot.",
          },
          {
              name: "Sovan Mishra",
              title: "Client Review",
              message: "We got a corporate video made for our manufacturing unit. Very professional output and great execution.",
          },
          {
              name: "Jayant Joshi",
              title: "Client Review",
              message: "Brandingwaale helped us with Meta ads and conversion tracking. Very helpful for scaling our D2C brand.",
          },
          {
              name: "Narendra Rawat",
              title: "Client Review",
              message: "We got our radio and cinema ads placed through them. Very helpful team and the rates were also better than others.",
          },
          {
              name: "Jamuna Pradhan",
              title: "Client Review",
              message: "They run our social media now and the content quality has improved a lot. Followers are engaging more.",
          },
          {
              name: "Gunnaj Siddiqui",
              title: "Client Review",
              message: "They’ve been managing our YouTube channel and video promotions. Growth has been steady and organic.",
          },
          {
              name: "Alok Choubey",
              title: "Client Review",
              message: "We needed a short animation video for our product. Brandingwaale delivered it on time and customers loved it.",
          },
          {
              name: "Anusha Parashar",
              title: "Client Review",
              message: "Needed help with SEM and Google Analytics setup. Brandingwaale handled it efficiently and provided useful insights.",
          },
          {
              name: "Saqib Hayat",
              title: "Client Review",
              message: "Brandingwaale Webtech delivers exceptional digital marketing solutions with transparent communication and excellent SEO and PPC expertise.",
          },
          {
              name: "Srajan Augustaya",
              title: "Client Review",
              message: "My e-commerce store sales increased significantly after they optimized my product pages and implemented conversion tracking.",
          },
          {
              name: "Shrut Jain",
              title: "Client Review",
              message: "The CRM system they provided has made managing customer interactions more organized and efficient.",
          },
          {
              name: "Aadithyaa",
              title: "Client Review",
              message: "Brandingwaale creates engaging content that resonates with the audience and increases followers and interaction.",
          },
          {
              name: "Kartik Nayak",
              title: "Client Review",
              message: "Took their help for a corporate film for our factory setup. The shoot and editing were managed very smoothly.",
          },
          {
              name: "Akshat Gautam",
              title: "Client Review",
              message: "We use their social media management services — consistent posting, great visuals, and solid engagement.",
          },
          {
              name: "Rupal Sharma",
              title: "Client Review",
              message: "Our website redesign brought our brand back to life and social media engagement increased significantly.",
          },
          {
              name: "Rushabh Bokariya",
              title: "Client Review",
              message: "Brandingwaale completely transformed my social media accounts. Now I have a steady stream of customers from Instagram.",
          },
          {
              name: "Rahul Raj Singh",
              title: "Client Review",
              message: "I got a lead management system built for my team. It made our sales tracking much easier.",
          },
          {
              name: "Disha Parihar",
              title: "Client Review",
              message: "Needed help with press releases and media buying. Brandingwaale handled everything smoothly.",
          },
          {
              name: "Sarita Chittora",
              title: "Client Review",
              message: "Great service and prompt delivery! Our press release and outdoor advertising campaigns got good reach.",
          },
          {
              name: "Manii Dubey",
              title: "Client Review",
              message: "Brandingwaale developed our ecommerce website for handmade products. It looks professional and is easy to manage.",
          },
          {
              name: "Sandra Saju",
              title: "Client Review",
              message: "Brandingwaale delivered a custom CRM solution that streamlined our sales process and improved communication.",
          },
          {
              name: "Aman Gupta",
              title: "Client Review",
              message: "They track social media activity and provide detailed reports. We’re impressed with their data-driven approach.",
          },
          {
              name: "Gitanjali Nayak",
              title: "Client Review",
              message: "We got help with our Wikipedia page and digital PR. It added a lot of credibility to our business.",
          },
          {
              name: "Anmol Chawla",
              title: "Client Review",
              message: "Brandingwaale provides detailed social media reports and excellent support. Sandeep has been amazing to work with.",
          },
          {
              name: "Sikha Bhagat",
              title: "Client Review",
              message: "Brandingwaale helped improve our brand's online reputation. Very trustworthy team.",
          },
          {
              name: "Chandan Singh Patni",
              title: "Client Review",
              message: "They created a beautiful website and amazing social media presence for my gym.",
          },
          {
              name: "Sanjana Kumari",
              title: "Client Review",
              message: "Their WhatsApp marketing campaign doubled my leads in just a week.",
          },
          {
              name: "Tejaswini Khairnar",
              title: "Client Review",
              message: "Outstanding content creation service. High quality content that engages our audience and drives results.",
          },
          {
              name: "Devika Bhadbhade",
              title: "Client Review",
              message: "Brandingwaale Webtech's mobile app solution exceeded our expectations and improved our business operations.",
          },
          {
              name: "Pratik Lad",
              title: "Client Review",
              message: "Professional team and very happy with their service.",
          },
          {
              name: "Vinay Singh",
              title: "Client Review",
              message: "Their targeted social media campaign helped my yoga studio reach the right audience in Faridabad.",
          },
          {
              name: "Mahima Bhaisare",
              title: "Client Review",
              message: "Brandingwaale’s SEO strategies greatly improved our online visibility.",
          },
      ];

      function createTestimonialCard(testimonial) {
          const firstLetter = testimonial.name.trim().charAt(0).toUpperCase();

          return `
    <div class="testimonial-card mb-4">
      <div class="profile-section">
        <div class="profile-img d-flex align-items-center justify-content-center">
          ${firstLetter}
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
  </script>