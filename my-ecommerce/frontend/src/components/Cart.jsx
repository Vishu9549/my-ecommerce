import React, { useState, useEffect } from "react";
import { useCart } from "../components/CartContext";
import { useNavigate } from "react-router-dom";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faPaperPlane } from "@fortawesome/free-solid-svg-icons";
import axios from "axios";

const Cart = () => {
  const navigate = useNavigate();
  const {
    cartItems,
    removeFromCart,
    getTotalQuantity,
    getTotalAmount,
    loading,
  } = useCart();

  const token = localStorage.getItem("token");

  const [couponCode, setCouponCode] = useState("");
  const [discount, setDiscount] = useState(0);
  const [message, setMessage] = useState("");
  const [error, setError] = useState("");
  const [subtotal, setSubtotal] = useState(0);

  useEffect(() => {
    setSubtotal(getTotalAmount());
  }, [cartItems, getTotalAmount]);

  const applyCoupon = async () => {
    if (!couponCode.trim()) {
      setError("Please enter a coupon code.");
      setMessage("");
      return;
    }

    try {
      const response = await axios.post(
        "http://localhost:8000/api/coupon/apply",
        { coupon_code: couponCode },
        {
          withCredentials: true,
          headers: {
            Authorization: `Bearer ${token}`,
          },
        }
      );

      const data = response.data;

      setDiscount(parseFloat(data.discount) || 0);
      setSubtotal(parseFloat(data.subtotal) || getTotalAmount());
      setMessage(data.message || "Coupon applied successfully");
      setError("");
    } catch (error) {
      console.error("Apply coupon error:", error.response?.data);
      setError(error.response?.data?.message || "Failed to apply coupon");
      setMessage("");
      setDiscount(0);
    }
  };

  if (loading) return <div className="text-center">Loading...</div>;

  if (cartItems.length === 0)
    return <div className="text-center mt-5">🛒 Your cart is empty</div>;

  const totalAfterDiscount = Math.max(subtotal - discount, 0);

  return (
    <div
      style={{
        maxWidth: "900px",
        margin: "40px auto",
        padding: "30px",
        border: "1px solid #eee",
        borderRadius: "10px",
        boxShadow: "0 4px 12px rgba(0,0,0,0.05)",
        backgroundColor: "#fff",
      }}
    >
      <h2 style={{ marginBottom: "25px", textAlign: "center" }}>
        🛒 Your Shopping Cart
      </h2>

      <ul style={{ listStyle: "none", padding: 0 }}>
        {cartItems.map((item) => (
          <li
            key={item.product_id}
            style={{
              display: "flex",
              alignItems: "center",
              justifyContent: "space-between",
              marginBottom: "20px",
              borderBottom: "1px solid #ddd",
              paddingBottom: "15px",
            }}
          >
            <div style={{ display: "flex", alignItems: "center" }}>
              <img
                src={`http://127.0.0.1:8000/uploads/product/${item.product?.image}`}
                alt={item.name}
                width="80"
                height="80"
                style={{
                  objectFit: "cover",
                  borderRadius: "8px",
                  marginRight: "15px",
                }}
              />
              <div>
                <div style={{ fontWeight: "bold", fontSize: "16px" }}>
                  {item.name}
                </div>
                <div>
                  {item.qty} × ₹{item.price} ={" "}
                  <strong>₹{item.row_total}</strong>
                </div>
              </div>
            </div>
            <button
              onClick={() => removeFromCart(item.id)}
              style={{
                background: "#ff4d4f",
                color: "#fff",
                border: "none",
                borderRadius: "5px",
                padding: "8px 12px",
                cursor: "pointer",
              }}
            >
              Remove
            </button>
          </li>
        ))}
      </ul>

      {/* Coupon Input */}
      <div style={{ marginTop: "30px", textAlign: "center" }}>
        <input
          type="text"
          value={couponCode}
          onChange={(e) => setCouponCode(e.target.value)}
          placeholder="Enter coupon code"
          style={{
            padding: "10px",
            border: "1px solid #ccc",
            borderRadius: "5px",
            width: "60%",
            marginRight: "10px",
          }}
        />
        <button
          onClick={applyCoupon}
          style={{
            padding: "10px 20px",
            background: "#28a745",
            color: "#fff",
            border: "none",
            borderRadius: "5px",
            cursor: "pointer",
          }}
        >
          Apply
        </button>
        {message && (
          <div style={{ marginTop: "10px", color: "green" }}>{message}</div>
        )}
        {error && (
          <div style={{ marginTop: "10px", color: "red" }}>{error}</div>
        )}
      </div>

      <div
        style={{
          marginTop: "30px",
          borderTop: "1px solid #ccc",
          paddingTop: "20px",
          display: "flex",
          justifyContent: "space-between",
          alignItems: "center",
        }}
      >
        <div>
          <div>
            <strong>Total Quantity:</strong> {getTotalQuantity()}
          </div>
          <div>
            <strong>Subtotal:</strong> ₹{subtotal.toFixed(2)}
          </div>
        </div>

        <button
          type="button"
          onClick={() => navigate("/checkout")}
          className="btn-success btn-lg w-50 d-flex justify-content-center align-items-center gy-2"
          style={{ height: "50px" }}
        >
          <FontAwesomeIcon icon={faPaperPlane} className="me-2" />
          CheckOut
        </button>
      </div>
    </div>
  );
};

export default Cart;
