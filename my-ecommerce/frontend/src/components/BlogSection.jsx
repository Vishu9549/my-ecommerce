import React from "react";

const BlogSection = () => {
  const blogs = [
    {
      img: "images/post-1.jpg",
      title: "First Time Home Owner Ideas",
      author: "Kristin Watson",
      date: "Dec 19, 2021",
    },
    {
      img: "images/post-2.jpg",
      title: "How To Keep Your Furniture Clean",
      author: "Robert Fox",
      date: "Dec 15, 2021",
    },
    {
      img: "images/post-3.jpg",
      title: "Small Space Furniture Apartment Ideas",
      author: "Kristin Watson",
      date: "Dec 12, 2021",
    },
  ];

  return (
    <div className="blog-section py-12 bg-light">
      <div className="container">
        <div className="row mb-5 justify-between items-center">
          <div className="col-md-6">
            <h2 className="section-title">Recent Blog</h2>
          </div>
          <div className="col-md-6 text-start text-md-end">
            <a href="#" className="more">
              View All Posts
            </a>
          </div>
        </div>

        <div className="row">
          {blogs.map((blog, index) => (
            <div className="col-12 col-sm-6 col-md-4 mb-4" key={index}>
              <div className="post-entry">
                <a href="#" className="post-thumbnail">
                  <img src={blog.img} alt="Blog" className="img-fluid" />
                </a>
                <div className="post-content-entry text-black">
                  <h3>
                    <a className="text-black" href="#">
                      {blog.title}
                    </a>
                  </h3>
                  <div className="meta">
                    <span>
                      by <a href="#">{blog.author}</a>
                    </span>{" "}
                    <span>
                      on <a href="#">{blog.date}</a>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
};

export default BlogSection;
