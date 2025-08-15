import React, { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import { useCart } from "../components/CartContext";
import "../assets/scss/style.scss";

const Checkout = () => {
  const navigate = useNavigate();
  const { cartItems, clearCart } = useCart();
  const [subtotal, setSubtotal] = useState(0);
  const [discount, setDiscount] = useState(0);
  const [total, setTotal] = useState(0);

  const token = localStorage.getItem("token");

  const [formData, setFormData] = useState({
    fname: "",
    lname: "",
    email: "",
    phone: "",
    address: "",
    address2: "",
    city: "",
    country: "",
    state: "",
    zip: "",
    notes: "",
    shipping_method: "Standard",
    payment_method: "COD",
    shipping: {
      fname: "",
      lname: "",
      email: "",
      phone: "",
      address: "",
      address2: "",
      city: "",
      country: "",
      state: "",
      zip: "",
    },
  });

  useEffect(() => {
    const fetchQuoteFromBackend = async () => {
      try {
        const res = await fetch("http://localhost:8000/api/quotes", {
          method: "GET",
          credentials: "include",
          headers: { "Content-Type": "application/json" ,
                   "Authorization": `Bearer ${token}`
        },
        });
        const data = await res.json();

        if (data && data.quote) {
          setSubtotal(parseFloat(data.quote.subtotal));
          setDiscount(parseFloat(data.quote.coupon_discount || 0));
          setTotal(parseFloat(data.quote.total));
        }
      } catch (error) {
        console.error("Error fetching backend quote:", error);
      }
    };

    fetchQuoteFromBackend();
  }, []);

  const handleChange = (e) => {
    const { name, value } = e.target;
    if (name.startsWith("shipping_")) {
      const key = name.replace("shipping_", "");
      setFormData((prev) => ({
        ...prev,
        shipping: {
          ...prev.shipping,
          [key]: value,
        },
      }));
    } else {
      setFormData((prev) => ({
        ...prev,
        [name]: value,
      }));
    }
  };

  const handlePlaceOrder = async () => {
    try {
      // 1️⃣ Update quote with billing info
      const quoteResponse = await fetch("http://localhost:8000/api/quotes", {
        method: "POST",
        credentials: "include",
        headers: { "Content-Type": "application/json" ,
                   "Authorization": `Bearer ${token}`
        },
        body: JSON.stringify({
          name: `${formData.fname} ${formData.lname}`,
          email: formData.email,
          phone: formData.phone,
          address: formData.address,
          address_2: formData.address2,
          city: formData.city,
          state: formData.state,
          country: formData.country,
          pincode: formData.zip,
          subtotal,
          total,
          notes: formData.notes,
        }),
      });

      const quoteData = await quoteResponse.json();
      if (!quoteResponse.ok) {
        alert("Quote update failed");
        return;
      }

      // 2️⃣ Place Order with payment, shipping method & shipping address
      const orderRes = await fetch("http://localhost:8000/api/place-order", {
        method: "POST",
        credentials: "include",
        headers: { "Content-Type": "application/json",
                    "Authorization": `Bearer ${token}`
         },
        body: JSON.stringify({
          payment_method: formData.payment_method,
          shipping_method: formData.shipping_method,

          shipping_name: `${formData.shipping.fname} ${formData.shipping.lname}`,
          shipping_email: formData.shipping.email,
          shipping_phone: formData.shipping.phone,
          shipping_address: formData.shipping.address,
          shipping_address_2: formData.shipping.address2,
          shipping_city: formData.shipping.city,
          shipping_state: formData.shipping.state,
          shipping_country: formData.shipping.country,
          shipping_pincode: formData.shipping.zip,
        }),
      });

      const orderData = await orderRes.json();

      if (orderRes.ok && orderData.success === true) {
        clearCart();
        navigate("/thankyou");
      } else {
        alert(orderData?.message || orderData?.error || "Order failed");
      }
    } catch (error) {
      console.error("Order failed:", error);
      alert("Order failed. Please try again.");
    }
  };

  return (
    <div className="container my-5">
      <h2 className="mb-4 text-center">Checkout</h2>
      <div className="row">
        {/* Billing Info */}
        <div className="col-md-6">
          <div className="card p-4 shadow-sm mb-4">
            <h4 className="mb-3">Billing Information</h4>
            <div className="row">
              {[
                ["First Name", "fname"],
                ["Last Name", "lname"],
                ["Email", "email"],
                ["Phone", "phone"],
                ["Address", "address"],
                ["Address 2", "address2"],
                ["City", "city"],
                ["Country", "country"],
                ["State", "state"],
                ["Zip", "zip"],
              ].map(([label, name], i) => (
                <div
                  key={i}
                  className={`col-md-${["state", "zip"].includes(name) ? 6 : 12} mb-3`}
                >
                  <label>{label}</label>
                  <input
                    type={name === "email" ? "email" : "text"}
                    name={name}
                    className="form-control"
                    value={formData[name]}
                    onChange={handleChange}
                  />
                </div>
              ))}
            </div>
          </div>
        </div>

        {/* Shipping Info */}
        <div className="col-md-6">
          <div className="card p-4 shadow-sm mb-4">
            <h4 className="mb-3">Shipping Information</h4>
            <div className="row">
              {[
                ["First Name", "fname"],
                ["Last Name", "lname"],
                ["Email", "email"],
                ["Phone", "phone"],
                ["Address", "address"],
                ["Address 2", "address2"],
                ["City", "city"],
                ["Country", "country"],
                ["State", "state"],
                ["Zip", "zip"],
              ].map(([label, name], i) => (
                <div
                  key={i}
                  className={`col-md-${["state", "zip"].includes(name) ? 6 : 12} mb-3`}
                >
                  <label>{label}</label>
                  <input
                    type={name === "email" ? "email" : "text"}
                    name={"shipping_" + name}
                    className="form-control"
                    value={formData.shipping[name]}
                    onChange={handleChange}
                  />
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>

      {/* Payment, Shipping Method, Notes */}
      <div className="row">
        <div className="col-md-6">
          <div className="card p-4 shadow-sm mb-4">
            <h4 className="mb-3">Shipping & Payment</h4>
            <div className="mb-3">
              <label>Shipping Method</label>
              <select
                name="shipping_method"
                className="form-control"
                value={formData.shipping_method}
                onChange={handleChange}
              >
                <option value="Standard">Standard</option>
                <option value="Express">Express</option>
              </select>
            </div>
            <div className="mb-3">
              <label>Payment Method</label>
              <select
                name="payment_method"
                className="form-control"
                value={formData.payment_method}
                onChange={handleChange}
              >
                <option value="COD">Cash on Delivery</option>
                <option value="Online">Online Payment</option>
              </select>
            </div>
            <div className="mb-3">
              <label>Order Notes</label>
              <textarea
                className="form-control"
                name="notes"
                rows="3"
                value={formData.notes}
                onChange={handleChange}
              ></textarea>
            </div>
          </div>
        </div>

        {/* Order Summary */}
        <div className="col-md-6">
          <div className="card p-4 shadow-sm mb-4">
            <h4 className="mb-3">Order Summary</h4>
            {cartItems.length > 0 ? (
              cartItems.map((item, index) => (
                <div key={index} className="mb-2">
                  <strong>{item.name}</strong> × {item.qty}
                  <div className="text-muted">
                    ₹ {(item.price * item.qty).toFixed(2)}
                  </div>
                </div>
              ))
            ) : (
              <p>Your cart is empty.</p>
            )}
            <hr />
            <div className="d-flex justify-content-between mb-2">
              <span>Subtotal</span>
              <span>₹ {subtotal.toFixed(2)}</span>
            </div>
            <div className="d-flex justify-content-between mb-2">
              <span>Discount</span>
              <span>− ₹ {discount.toFixed(2)}</span>
            </div>
            <div className="d-flex justify-content-between fw-bold">
              <span>Total</span>
              <span>₹ {total.toFixed(2)}</span>
            </div>
            <button
              className="btn btn-primary w-100 mt-4"
              onClick={handlePlaceOrder}
              disabled={cartItems.length === 0}
            >
              Place Order
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Checkout;
