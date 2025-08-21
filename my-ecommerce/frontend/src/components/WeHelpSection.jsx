import React, { useEffect, useState } from "react";
import axios from "axios";
import "../assets/scss/style.scss";

const WeHelpSection = () => {
  const [helpData, setHelpData] = useState(null);

  useEffect(() => {
    axios
      .get("http://127.0.0.1:8000/api/blocks/we_help_you")
      .then((response) => {
        if (response.data) {
          setHelpData(response.data);
        }
      })
      .catch((error) => {
        console.error("Error fetching help section:", error);
      });
  }, []);

  if (!helpData) return null;

  const features = helpData.features || [];

  return (
    <section className="we-help-section py-5 bg-light text-dark">
      <div className="container">
        <div className="row align-items-center g-4">
          {/* Left: Images */}
          <div className="col-lg-6">
            <div className="row g-3">
              <div className="col-6">
                <img
                  src={helpData.image[0]}
                  alt="Grid 1"
                  className="img-fluid rounded shadow"
                  style={{ height: "360px", objectFit: "cover", width: "100%" }}
                />
              </div>
              <div className="col-6 d-flex flex-column gap-3">
                <img
                  src={helpData.image[1]}
                  alt="Grid 2"
                  className="img-fluid rounded shadow"
                  style={{ height: "174px", objectFit: "cover", width: "100%" }}
                />
                <img
                  src={helpData.image[2]}
                  alt="Grid 3"
                  className="img-fluid rounded shadow"
                  style={{ height: "174px", objectFit: "cover", width: "100%" }}
                />
              </div>
            </div>
          </div>

          {/* Right: Text */}
          <div className="col-lg-6 d-flex align-items-center">
            <div className="w-100">
              <h2 className="fw-bold fs-3 mb-3">{helpData.title}</h2>
              <p className="fs-6 mb-3">{helpData.heading}</p>

              <ul className="list-unstyled mb-4">
                {features.map((feature, index) => (
                  <li key={index}>✅ {feature}</li>
                ))}
              </ul>

              <a
                href={helpData.button_link || "#"}
                className="btn btn-dark px-4 py-2 rounded-pill d-inline-flex align-items-center gap-2"
              >
                {helpData.button_text || "Explore"}
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="18"
                  height="18"
                  fill="currentColor"
                  className="bi bi-arrow-right"
                  viewBox="0 0 16 16"
                >
                  <path
                    fillRule="evenodd"
                    d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5
                     0 1 1 .708-.708l4 4a.5.5 0 0 1 0
                     .708l-4 4a.5.5 0 0 1-.708-.708L13.293
                     8.5H1.5A.5.5 0 0 1 1 8z"
                  />
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default WeHelpSection;
