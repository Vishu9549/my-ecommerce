import React, { useEffect, useState } from "react";
import axios from "axios";
import "../styles/footer.scss";

import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faPaperPlane } from "@fortawesome/free-solid-svg-icons";
import {
  faFacebookF,
  faTwitter,
  faInstagram,
  faLinkedin,
} from "@fortawesome/free-brands-svg-icons";

const Footer = () => {
  const [pages, setPages] = useState([]);

  useEffect(() => {
    axios
      .get("http://127.0.0.1:8000/api/pages")
      .then((response) => {
        setPages(response.data);
      })
      .catch((error) => {
        console.error("Error fetching pages:", error);
      });
  }, []);

  return (
    <footer className="footer-section ">
      <div className="container relative">
        <div className="sofa-img">
          <img
            src="/images/sofa.png"
            alt="Sofa"
            className="img-fluid"
            style={{ marginTop: "120px" }}
          />
        </div>

        <div className="row">
          <div className="col-lg-8">
            <div className="subscription-form">
              <h3 className="d-flex align-items-center mb-4">
                <span className="me-2">
                  <img
                    src="/images/envelope-outline.svg"
                    alt="Envelope"
                    className="img-fluid "
                  />
                </span>
                <span>Subscribe to Newsletter</span>
              </h3>

              <form className="row gx-2 gy-2 align-items-center">
                <div className="col-md-4">
                  <input
                    type="text"
                    className="form-control form-control-lg"
                    placeholder="Enter your name"
                  />
                </div>
                <div className="col-md-4">
                  <input
                    type="email"
                    className="form-control form-control-lg"
                    placeholder="Enter your email"
                  />
                </div>
                <div className="col-md-4 gy-2">
                  <button
                    type="submit"
                    className="btn-success btn-lg w-100 d-flex justify-content-center align-items-center gy-2"
                    style={{ height: "50px" }}
                  >
                    <FontAwesomeIcon icon={faPaperPlane} className="me-2" />
                    Send
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div className="row g-5 mb-5 mt-5">
          <div className="col-lg-4">
            <div className="mb-4 footer-logo-wrap">
              <a href="#" className="footer-logo">
                Furni<span>.</span>
              </a>
            </div>
            <p className="mb-4">
              Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio
              quis nisl dapibus malesuada.
            </p>

            <ul className="list-unstyled custom-social d-flex">
              <li className="me-3">
                <a href="#">
                  <FontAwesomeIcon icon={faFacebookF} />
                </a>
              </li>
              <li className="me-3">
                <a href="#">
                  <FontAwesomeIcon icon={faTwitter} />
                </a>
              </li>
              <li className="me-3">
                <a href="#">
                  <FontAwesomeIcon icon={faInstagram} />
                </a>
              </li>
              <li>
                <a href="#">
                  <FontAwesomeIcon icon={faLinkedin} />
                </a>
              </li>
            </ul>
          </div>

          <div className="col-lg-8">
            <div className="row links-wrap">
              <div className="col-6 col-sm-6 col-md-3">
                <ul className="list-unstyled">
                  {pages.map((page) => (
                    <li key={page.id}>
                      <a href={`/page/${page.url_key}`}>{page.title}</a>
                    </li>
                  ))}
                  <li>
                    <a href="#">Contact us</a>
                  </li>
                </ul>
              </div>

              <div className="col-6 col-sm-6 col-md-3">
                <ul className="list-unstyled">
                  <li>
                    <a href="#">Support</a>
                  </li>
                  <li>
                    <a href="#">Knowledge base</a>
                  </li>
                  <li>
                    <a href="#">Live chat</a>
                  </li>
                </ul>
              </div>

              <div className="col-6 col-sm-6 col-md-3">
                <ul className="list-unstyled">
                  <li>
                    <a href="#">Jobs</a>
                  </li>
                  <li>
                    <a href="#">Our team</a>
                  </li>
                  <li>
                    <a href="#">Leadership</a>
                  </li>
                  <li>
                    <a href="#">Privacy Policy</a>
                  </li>
                </ul>
              </div>

              <div className="col-6 col-sm-6 col-md-3">
                <ul className="list-unstyled">
                  <li>
                    <a href="#">Nordic Chair</a>
                  </li>
                  <li>
                    <a href="#">Kruzo Aero</a>
                  </li>
                  <li>
                    <a href="#">Ergonomic Chair</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div className="border-top copyright">
          <div className="row pt-4">
            <div className="col-lg-6">
              <p className="mb-2 text-center text-lg-start">
                Copyright © {new Date().getFullYear()}. All Rights Reserved.
                &mdash; Designed with love by{" "}
                <a href="https://untree.co">Untree.co</a>
                Distributed By <a href="https://themewagon.com">ThemeWagon</a>
              </p>
            </div>
            <div className="col-lg-6 text-center text-lg-end">
              <ul className="list-unstyled d-inline-flex ms-auto">
                <li className="me-4">
                  <a href="#">Terms &amp; Conditions</a>
                </li>
                <li>
                  <a href="#">Privacy Policy</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
