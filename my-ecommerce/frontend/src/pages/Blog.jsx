import React from "react";
import TestimonialSlider from "../components/TestimonialSlider";
import HeroSection from "../components/HeroSection";

const Blog = () => {
  return (
    <div>
      <HeroSection
        title="Welcome to Our Blog Section"
        subtitle="Find Your Comfort"
        description="Discover stylish and affordable furniture for every room in your home."
      />

      <div className="blog-section py-5">
        <div className="container">
          <div className="row">
            {[
              {
                title: "First Time Home Owner Ideas",
                author: "Kristin Watson",
                date: "Dec 19, 2021",
                image: "images/post-1.jpg",
              },
              {
                title: "How To Keep Your Furniture Clean",
                author: "Robert Fox",
                date: "Dec 15, 2021",
                image: "images/post-2.jpg",
              },
              {
                title: "Small Space Furniture Apartment Ideas",
                author: "Kristin Watson",
                date: "Dec 12, 2021",
                image: "images/post-3.jpg",
              },
              {
                title: "First Time Home Owner Ideas",
                author: "Kristin Watson",
                date: "Dec 19, 2021",
                image: "images/post-1.jpg",
              },
              {
                title: "How To Keep Your Furniture Clean",
                author: "Robert Fox",
                date: "Dec 15, 2021",
                image: "images/post-2.jpg",
              },
              {
                title: "Small Space Furniture Apartment Ideas",
                author: "Kristin Watson",
                date: "Dec 12, 2021",
                image: "images/post-3.jpg",
              },
              {
                title: "First Time Home Owner Ideas",
                author: "Kristin Watson",
                date: "Dec 19, 2021",
                image: "images/post-1.jpg",
              },
              {
                title: "How To Keep Your Furniture Clean",
                author: "Robert Fox",
                date: "Dec 15, 2021",
                image: "images/post-2.jpg",
              },
              {
                title: "Small Space Furniture Apartment Ideas",
                author: "Kristin Watson",
                date: "Dec 12, 2021",
                image: "images/post-3.jpg",
              },
            ].map((post, index) => (
              <div className="col-12 col-sm-6 col-md-4 mb-5" key={index}>
                <div className="post-entry">
                  <a href="#" className="post-thumbnail">
                    <img
                      src={`/images/${post.image.split("/").pop()}`}
                      alt={post.title}
                      className="img-fluid"
                    />
                  </a>
                  <div className="post-content-entry">
                    <h3>
                      <a href="#">{post.title}</a>
                    </h3>
                    <div className="meta">
                      <span>
                        by <a href="#">{post.author}</a>
                      </span>{" "}
                      <span>
                        on <a href="#">{post.date}</a>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>
      <TestimonialSlider />
    </div>
  );
};

export default Blog;
