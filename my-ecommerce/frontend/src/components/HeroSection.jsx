import React, { useEffect, useState } from "react";
import axios from "axios";

const HeroSection = () => {
  const [sliders, setSliders] = useState([]);
  const [currentIndex, setCurrentIndex] = useState(0);

  useEffect(() => {
    axios
      .get("http://127.0.0.1:8000/api/sliders")
      .then((response) => {
        const data = response.data.map((slider) => ({
          ...slider,
          image: slider.image?.startsWith("http")
            ? slider.image
            : `http://127.0.0.1:8000/${slider.image?.replace(/^\/+/, "")}`,
        }));
        setSliders(data);
      })
      .catch((error) => {
        console.error("Error fetching sliders:", error);
      });
  }, []);

  useEffect(() => {
    const interval = setInterval(() => {
      setCurrentIndex((prev) => (prev + 1 < sliders.length ? prev + 1 : 0));
    }, 10000);

    return () => clearInterval(interval);
  }, [sliders]);

  if (sliders.length === 0) {
    return <div>Loading...</div>;
  }

  const currentSlider = sliders[currentIndex];

  return (
    <div className="hero">
      <div className="container">
        <div className="row align-items-center">
          <div className="col-lg-6">
            <div className="intro-excerpt">
              <h1 className="mb-4">{currentSlider.title}</h1>
              <p className="mb-4">
                {currentSlider.subtitle ||
                  "Welcome to our store. Explore amazing collections!"}
              </p>
              <p>
                <a href="/shop" className="btn btn-secondary me-2">
                  Shop Now
                </a>
                <a href="#why-choose" className="btn btn-white-outline">
                  Explore
                </a>
              </p>
            </div>
          </div>

          <div className="col-lg-6 text-center">
            <div className="hero-img-wrap">
              <img
                src={currentSlider.image}
                alt={currentSlider.title}
                className="img-fluid"
                style={{ maxWidth: "100%", height: "auto" }}
                onError={(e) => {
                  e.target.src = "/images/default-hero.png";
                }}
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default HeroSection;
