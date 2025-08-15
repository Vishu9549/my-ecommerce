import React, { useEffect, useState } from "react";
import { Card, Form, Button } from "react-bootstrap";
import { useNavigate } from "react-router-dom";
import Login from "./Login";

export default function AccountPage() {
  const [user, setUser] = useState(null);
  const [activeSection, setActiveSection] = useState("welcome");
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [confirmPassword, setConfirmPassword] = useState("");

  // ✅ User load on mount
  useEffect(() => {
    const storedUser = localStorage.getItem("user");
    if (storedUser) {
      const parsedUser = JSON.parse(storedUser);
      setUser(parsedUser);
      setName(parsedUser.name);
      setEmail(parsedUser.email);
    }
  }, []);

  const handleLogout = () => {
    localStorage.clear();
    setUser(null);
    setActiveSection("welcome");
  };

  return (
    <div className="container-fluid">
      <div className="row">
        {/* Sidebar */}
        <div className="col-md-3 bg-success text-white p-4" style={{ minHeight: "100vh" }}>
          <h4 className="mb-4">{user ? `Welcome, ${user.name}` : "Welcome, New User"}</h4>
          <div className="list-group">
            <button className="list-group-item list-group-item-action" onClick={() => setActiveSection(user ? "profile" : "login")}>
              Profile
            </button>
            <button className="list-group-item list-group-item-action" onClick={() => setActiveSection("orders")}>
              My Orders
            </button>
            <button className="list-group-item list-group-item-action" onClick={() => setActiveSection("wishlist")}>
              Wishlist
            </button>
            <button className="list-group-item list-group-item-action text-danger" onClick={handleLogout}>
              Logout
            </button>
          </div>
        </div>

        {/* Right content */}
        <div className="col-md-9 p-4" style={{ minHeight: "100vh", overflowY: "auto" }}>
          {activeSection === "welcome" && (
            <Card className="p-4 shadow-sm">
              <h3>Welcome to Your Account</h3>
              <p>Select an option from the left menu.</p>
            </Card>
          )}

          {activeSection === "login" && (
            <div style={{ maxWidth: "500px", margin: "0 auto" }}>
              <Login
                onLoginSuccess={(loggedInUser) => {
                  setUser(loggedInUser);
                  setName(loggedInUser.name);
                  setEmail(loggedInUser.email);
                  setActiveSection("profile");
                }}
              />
            </div>
          )}

          {activeSection === "profile" && user && (
            <Card className="shadow-sm rounded-4 p-4" style={{ maxWidth: "500px", margin: "0 auto" }}>
              <Card.Body>
                <h3 className="text-center mb-4 fw-bold">Account Details</h3>
                <Form
                  onSubmit={async (e) => {
                    e.preventDefault();
                    try {
                      const res = await fetch("http://127.0.0.1:8000/api/user/update", {
                        method: "PUT",
                        headers: {
                          "Content-Type": "application/json",
                          Authorization: `Bearer ${localStorage.getItem("token")}`,
                        },
                        body: JSON.stringify({
                          name,
                          email,
                          password,
                          password_confirmation: confirmPassword,
                        }),
                      });
                      const data = await res.json();
                      if (res.ok) {
                        alert("Profile updated successfully!");
                        setUser(data.user);
                      } else {
                        alert(data.message || "Something went wrong");
                      }
                    } catch (err) {
                      console.error(err);
                    }
                  }}
                >
                  <Form.Group className="mb-3">
                    <Form.Label>Full Name</Form.Label>
                    <Form.Control type="text" value={name} onChange={(e) => setName(e.target.value)} required />
                  </Form.Group>
                  <Form.Group className="mb-3">
                    <Form.Label>Email</Form.Label>
                    <Form.Control type="email" value={email} onChange={(e) => setEmail(e.target.value)} required />
                  </Form.Group>
                  <Form.Group className="mb-3">
                    <Form.Label>New Password</Form.Label>
                    <Form.Control type="password" onChange={(e) => setPassword(e.target.value)} />
                  </Form.Group>
                  <Form.Group className="mb-3">
                    <Form.Label>Confirm Password</Form.Label>
                    <Form.Control type="password" onChange={(e) => setConfirmPassword(e.target.value)} />
                  </Form.Group>
                  <Button type="submit" className="w-100">
                    Update
                  </Button>
                </Form>
              </Card.Body>
            </Card>
          )}

          {activeSection === "orders" && <OrderList />}
          {activeSection === "wishlist" && (
            <Card className="p-4 shadow-sm">
              <h3 className="mb-4">My Wishlist</h3>
              <Wishlist />
            </Card>
          )}
        </div>
      </div>
    </div>
  );
}

// ✅ Order List Component
function OrderList() {
  const navigate = useNavigate();
  const [orders, setOrders] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const token = localStorage.getItem("token");
    if (!token) {
      setError("Please login to view orders");
      setLoading(false);
      return;
    }

    fetch("http://127.0.0.1:8000/api/orders", {
      headers: { Authorization: `Bearer ${token}` },
    })
      .then((res) => res.json())
      .then((data) => {
        setOrders(data);
        setLoading(false);
      })
      .catch(() => {
        setError("Failed to load orders");
        setLoading(false);
      });
  }, []);

  if (loading) return <p>Loading orders...</p>;
  if (error) return <p className="text-danger">{error}</p>;

  return (
    <div>
      {orders.length === 0 ? (
        <p>No orders found.</p>
      ) : (
        orders.map((order) => (
          <div key={order.id} className="p-3 mb-2 border rounded">
            <p>
              <b>Order #{order.id}</b> - {order.status}
            </p>
            <p>Date: {new Date(order.created_at).toLocaleDateString()}</p>
            <button className="btn btn-primary btn-sm" onClick={() => navigate(`/order-details/${order.id}`)}>
              View Details
            </button>
          </div>
        ))
      )}
    </div>
  );
}

// ✅ Wishlist Component
function Wishlist() {
  const [wishlistItems, setWishlistItems] = useState([]);
  const [loading, setLoading] = useState(true);
  const navigate = useNavigate();

  useEffect(() => {
    const token = localStorage.getItem("token");
    if (!token) {
      setWishlistItems([]);
      setLoading(false);
      return;
    }

    fetch("http://127.0.0.1:8000/api/wishlist", {
      headers: { Authorization: `Bearer ${token}` },
    })
      .then((res) => res.json())
      .then((data) => {
        setWishlistItems(data);
        setLoading(false);
      })
      .catch(() => {
        setLoading(false);
      });
  }, []);

  if (loading) return <p>Loading wishlist...</p>;
  if (wishlistItems.length === 0) return <p>No items in your wishlist.</p>;

  async function removeFromWishlist(productId) {
    const token = localStorage.getItem("token");
    if (!token) return;

    await fetch(`http://127.0.0.1:8000/api/wishlist/remove/${productId}`, {
      method: "DELETE",
      headers: { Authorization: `Bearer ${token}` },
    });

    setWishlistItems((prev) => prev.filter((item) => item.product.id !== productId));
  }

  return (
    <div className="row">
      {wishlistItems.map((item) => (
        <div key={item.id} className="col-md-4 mb-4">
          <div className="card h-100 shadow-sm">
            <img
              src={
                item.product.image?.startsWith("http")
                  ? item.product.image
                  : `http://127.0.0.1:8000/uploads/product/${item.product.image}`
              }
              alt={item.product.name}
              className="img-fluid"
              style={{ objectFit: "cover", height: "200px", cursor: "pointer" }}
              onClick={() => navigate(`/product/${item.product.slug}`)}
              onError={(e) => {
                e.target.src = "/images/default-product.png";
              }}
            />
            <div className="card-body">
              <h5>{item.product.name}</h5>
              <p>₹{item.product.price}</p>
              <button className="btn btn-danger btn-sm" onClick={() => removeFromWishlist(item.product.id)}>
                Remove
              </button>
            </div>
          </div>
        </div>
      ))}
    </div>
  );
}
