import React, { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import { useCart } from "../components/CartContext";
import axios from "axios";
import { FaBoxOpen } from "react-icons/fa";

export default function Navbar() {
  const { getTotalQuantity } = useCart();
  const totalQuantity = getTotalQuantity();

  const [categories, setCategories] = useState([]);
  const [user, setUser] = useState(null);

  useEffect(() => {
    axios
      .get("http://127.0.0.1:8000/api/categories")
      .then((response) => {
        setCategories(response.data);
      })
      .catch((error) => {
        console.error("Error fetching categories:", error);
      });

    const storedUser = localStorage.getItem("user");
    if (storedUser) {
      setUser(JSON.parse(storedUser));
    }
  }, []);

  return (
    <nav className="custom-navbar navbar navbar-expand-md navbar-dark bg-dark">
      <div className="container">
        <Link className="navbar-brand" to="/">
          Furni<span>.</span>
        </Link>

        <button
          className="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarsFurni"
        >
          <span className="navbar-toggler-icon"></span>
        </button>

        <div className="collapse navbar-collapse" id="navbarsFurni">
          <ul className="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
            <li className="nav-item">
              <Link className="nav-link" to="/">
                Home
              </Link>
            </li>

            {categories.map((category) => (
              <li key={category.id} className="nav-item dropdown">
                <Link
                  className="nav-link dropdown-toggle"
                  to="#"
                  id={`navbarDropdown-${category.id}`}
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  {category.name}
                </Link>
                {category.children && category.children.length > 0 && (
                  <ul
                    className="dropdown-menu bg-dark"
                    aria-labelledby={`navbarDropdown-${category.id}`}
                  >
                    {category.children.map((child) => (
                      <li key={child.id}>
                        <Link
                          className="dropdown-item"
                          to={`/categories/${category.slug}/${child.slug}`}
                        >
                          {child.name}
                        </Link>
                      </li>
                    ))}
                  </ul>
                )}
              </li>
            ))}

            <li className="nav-item">
              <Link className="nav-link" to="/contact">
                Contact us
              </Link>
            </li>
          </ul>

          <ul className="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5 align-items-center">
            <li className="text-center me-3">
              <Link className="nav-link p-0" to="/account">
                <img
                  src="/images/user.svg"
                  alt="user"
                  style={{ width: "24px" }}
                />
                <div
                  className="text-white"
                  style={{ fontSize: "0.8rem", marginTop: "2px" }}
                >
                  {user ? user.name : "New User"}
                </div>
              </Link>
            </li>

            <li className="position-relative me-3">
              <Link className="nav-link" to="/cart">
                <img src="/images/cart.svg" alt="cart" />
                {totalQuantity > 0 && (
                  <span
                    className="cart-badge position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                    style={{ fontSize: "0.65rem", padding: "4px 6px" }}
                  >
                    {totalQuantity}
                  </span>
                )}
              </Link>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  );
}
