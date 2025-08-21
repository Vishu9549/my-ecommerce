import React from "react";
import TestimonialSlider from "../components/TestimonialSlider";
import ProductSection from "../components/ProductSection";
import HeroSection from "../components/HeroSection";

const Services = () => {
  return (
    <>
      <HeroSection
        title="Welcome to Our Services Section"
        subtitle="Find Your Comfort"
        description="Discover stylish and affordable furniture for every room in your home."
      />

      <div className="why-choose-section">
        <div className="container">
          <div className="row my-5">
            {[
              {
                img: "images/truck.svg",
                title: "Fast & Free Shipping",
              },
              {
                img: "images/bag.svg",
                title: "Easy to Shop",
              },
              {
                img: "images/support.svg",
                title: "24/7 Support",
              },
              {
                img: "images/return.svg",
                title: "Hassle Free Returns",
              },
              {
                img: "images/truck.svg",
                title: "Fast & Free Shipping",
              },
              {
                img: "images/bag.svg",
                title: "Easy to Shop",
              },
              {
                img: "images/support.svg",
                title: "24/7 Support",
              },
              {
                img: "images/return.svg",
                title: "Hassle Free Returns",
              },
            ].map((feature, index) => (
              <div className="col-6 col-md-6 col-lg-3 mb-4" key={index}>
                <div className="feature">
                  <div className="icon">
                    <img
                      src={`/images/${feature.img.split("/").pop()}`}
                      alt="Icon"
                      className="img-fluid"
                    />
                  </div>
                  <h3>{feature.title}</h3>
                  <p>
                    Donec vitae odio quis nisl dapibus malesuada. Nullam ac
                    aliquet velit. Aliquam vulputate.
                  </p>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>
      <ProductSection />
      <TestimonialSlider />
    </>
  );
};

export default Services;
