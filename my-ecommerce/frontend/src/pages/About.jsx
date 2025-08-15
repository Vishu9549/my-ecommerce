import React from 'react';
import WhyChooseUs from '../components/WhyChooseUs';
import TestimonialSlider from '../components/TestimonialSlider';
import HeroSection from '../components/HeroSection';

const About = () => {
  return (
    <div>
      {/* Hero Section */}
     <HeroSection 
  title="Welcome to Our About Section" 
  subtitle="Find Your Comfort" 
  description="Discover stylish and affordable furniture for every room in your home." 
  
  
/>

      {/* Other Sections */}
      <WhyChooseUs/>

       
    <div className="untree_co-section">
      <div className="container">

        <div className="row mb-5">
          <div className="col-lg-5 mx-auto text-center">
            <h2 className="section-title">Our Team</h2>
          </div>
        </div>

        <div className="row">
          {/* Team Member 1 */}
          <div className="col-12 col-md-6 col-lg-3 mb-5 mb-md-0">
            <img src="/images/person_1.jpg" className="img-fluid mb-5" alt="Lawson Arnold" />
            <h3 className="mb-2">
              <a href="#"><span>Lawson</span> Arnold</a>
            </h3>
            <span className="d-block position mb-4">CEO, Founder, Atty.</span>
            <p>Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
            <p className="mb-0">
              <a href="#" className="more dark">Learn More <span className="icon-arrow_forward"></span></a>
            </p>
          </div>

          {/* Team Member 2 */}
          <div className="col-12 col-md-6 col-lg-3 mb-5 mb-md-0">
            <img src="/images/person_2.jpg" className="img-fluid mb-5" alt="Jeremy Walker" />
            <h3 className="mb-2">
              <a href="#"><span>Jeremy</span> Walker</a>
            </h3>
            <span className="d-block position mb-4">CEO, Founder, Atty.</span>
            <p>Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
            <p className="mb-0">
              <a href="#" className="more dark">Learn More <span className="icon-arrow_forward"></span></a>
            </p>
          </div>

          {/* Team Member 3 */}
          <div className="col-12 col-md-6 col-lg-3 mb-5 mb-md-0">
            <img src="/images/person_3.jpg" className="img-fluid mb-5" alt="Patrik White" />
            <h3 className="mb-2">
              <a href="#"><span>Patrik</span> White</a>
            </h3>
            <span className="d-block position mb-4">CEO, Founder, Atty.</span>
            <p>Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
            <p className="mb-0">
              <a href="#" className="more dark">Learn More <span className="icon-arrow_forward"></span></a>
            </p>
          </div>

          {/* Team Member 4 */}
          <div className="col-12 col-md-6 col-lg-3 mb-5 mb-md-0">
            <img src="/images/person_4.jpg" className="img-fluid mb-5" alt="Kathryn Ryan" />
            <h3 className="mb-2">
              <a href="#"><span>Kathryn</span> Ryan</a>
            </h3>
            <span className="d-block position mb-4">CEO, Founder, Atty.</span>
            <p>Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
            <p className="mb-0">
              <a href="#" className="more dark">Learn More <span className="icon-arrow_forward"></span></a>
            </p>
          </div>
        </div>

      </div>
    </div>








      <TestimonialSlider />
    </div>
  );
};

export default About;
