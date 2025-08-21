import React, { useEffect, useState } from "react";
import { useCart } from "../components/CartContext";
import axios from "axios";

const ProductSection = () => {
  const { addToCart } = useCart();
  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    axios
      .get("http://127.0.0.1:8000/api/products/featured")
      .then((res) => {
        setProducts(res.data);
        setLoading(false);
      })
      .catch((err) => {
        console.error("Error fetching featured products:", err);
        setLoading(false);
      });
  }, []);

  return (
    <section className="product-section py-5 bg-light">
      <div className="container">
        <div className="row g-4 align-items-stretch">
          <div className="col-lg-3 d-flex">
            <div className="bg-white p-4 shadow-sm rounded w-100 d-flex flex-column justify-content-between">
              <div>
                <h2 className="section-title mb-3 fw-bold">
                  Crafted with excellent material.
                </h2>
                <p className="text-muted mb-4">
                  Explore our premium selection of furniture crafted with care
                  and style.
                </p>
              </div>
              <a
                href="/shop"
                className="btn btn-dark px-4 py-2 rounded-pill mt-auto"
              >
                Explore
              </a>
            </div>
          </div>
          <div className="col-lg-9">
            <div className="row g-4">
              {loading ? (
                <p>Loading products...</p>
              ) : products.length === 0 ? (
                <p>No products found.</p>
              ) : (
                products.map((product) => (
                  <div key={product.id} className="col-md-6 col-lg-4">
                    <div className="product-item text-center p-3 border rounded shadow-sm h-100 d-flex flex-column">
                      <div style={{ height: "200px", overflow: "hidden" }}>
                        <img
                          src={
                            product.image?.startsWith("http")
                              ? product.image
                              : `http://127.0.0.1:8000/${product.image.replace(
                                  /^\/+/,
                                  ""
                                )}`
                          }
                          alt={product.product_name}
                          className="img-fluid mb-3"
                          style={{
                            objectFit: "cover",
                            height: "100%",
                            width: "100%",
                          }}
                          onError={(e) => {
                            e.target.src = "/images/default-product.png";
                          }}
                        />
                      </div>

                      <h5 className="product-title mb-1">
                        {product.product_name}
                      </h5>
                      <strong className="product-price d-block mb-3">
                        ₹{product.price}
                      </strong>

                      <div className="mt-auto">
                        <button
                          onClick={() =>
                            addToCart({
                              id: product.id,
                              name: product.product_name,
                              price: product.price,
                              image: product.image?.startsWith("http")
                                ? product.image
                                : `http://127.0.0.1:8000/storage/${product.image.replace(
                                    /^\/+/,
                                    ""
                                  )}`,
                            })
                          }
                          className="btn btn-outline-dark"
                          style={{
                            borderRadius: "50%",
                            width: "40px",
                            height: "40px",
                            padding: 0,
                            border: "1px solid black",
                          }}
                        >
                          <img
                            src="/images/cross.svg"
                            alt="Add to cart"
                            style={{
                              width: "20px",
                              height: "20px",
                              filter: "brightness(0)",
                            }}
                          />
                        </button>
                      </div>
                    </div>
                  </div>
                ))
              )}
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default ProductSection;
