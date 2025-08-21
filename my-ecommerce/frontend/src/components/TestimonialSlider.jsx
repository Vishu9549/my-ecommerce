import React from "react";
import { Swiper, SwiperSlide } from "swiper/react";
import { Navigation } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import "../assets/scss/style.scss";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import {
  faChevronLeft,
  faChevronRight,
} from "@fortawesome/free-solid-svg-icons";

const testimonials = [
  {
    text: "Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio quis nisl dapibus malesuada...",
    image: "/images/person-1.png",
    name: "Maria Jones",
    position: "CEO, Co-Founder, XYZ Inc.",
  },
  {
    text: "Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio quis nisl dapibus malesuada...",
    image: "/images/person-1.png",
    name: "Maria Jones",
    position: "CEO, Co-Founder, XYZ Inc.",
  },
  {
    text: "Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio quis nisl dapibus malesuada...",
    image: "/images/person-1.png",
    name: "Maria Jones",
    position: "CEO, Co-Founder, XYZ Inc.",
  },
];

const TestimonialSlider = () => {
  return (
    <div className="testimonial-section bg-light">
      <div className="container">
        <div className="row">
          <div className="col-lg-7 mx-auto text-center">
            <h2 className="section-title">Testimonials</h2>
          </div>
        </div>

        <div className="row justify-content-center">
          <div className="col-lg-12">
            <div className="testimonial-slider-wrap text-center">
              <div id="testimonial-nav">
                <span className="prev" data-controls="prev">
                  <FontAwesomeIcon icon={faChevronLeft} />
                </span>
                <span className="next" data-controls="next">
                  <FontAwesomeIcon icon={faChevronRight} />
                </span>
              </div>

              <Swiper
                modules={[Navigation]}
                navigation={{
                  nextEl: ".next",
                  prevEl: ".prev",
                }}
                loop={true}
                slidesPerView={1}
                spaceBetween={30}
                className="testimonial-slider"
              >
                {testimonials.map((testimonial, index) => (
                  <SwiperSlide key={index}>
                    <div className="item">
                      <div className="row justify-content-center">
                        <div className="col-lg-8 mx-auto">
                          <div className="testimonial-block text-center">
                            <blockquote className="mb-5">
                              <p>&ldquo;{testimonial.text}&rdquo;</p>
                            </blockquote>
                            <div className="author-info">
                              <div className="author-pic">
                                <img
                                  src={testimonial.image}
                                  alt={testimonial.name}
                                  className="img-fluid"
                                />
                              </div>
                              <h3 className="font-weight-bold">
                                {testimonial.name}
                              </h3>
                              <span className="position d-block mb-3">
                                {testimonial.position}
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </SwiperSlide>
                ))}
              </Swiper>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default TestimonialSlider;
