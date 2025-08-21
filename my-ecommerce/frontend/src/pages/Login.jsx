// src/pages/LoginForm.js
import React, { useState } from "react";
import { Card, Form, Button } from "react-bootstrap";
import axios from "axios";
import { useCart } from "../components/CartContext";

export default function LoginForm({ onLoginSuccess }) {
  const { fetchCartItems } = useCart();
  const [isLogin, setIsLogin] = useState(true);
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    password: "",
    confirmPassword: "",
  });

  const handleChange = (e) =>
    setFormData({ ...formData, [e.target.name]: e.target.value });

  const handleSubmit = async (e) => {
    e.preventDefault();

    if (!isLogin && formData.password !== formData.confirmPassword) {
      alert("Passwords do not match!");
      return;
    }

    try {
      const url = isLogin
        ? "http://127.0.0.1:8000/api/login"
        : "http://127.0.0.1:8000/api/register";

      const payload = isLogin
        ? { email: formData.email, password: formData.password }
        : {
            name: formData.name,
            email: formData.email,
            password: formData.password,
          };

      const res = await axios.post(url, payload, { withCredentials: true });

      if (isLogin) {
        localStorage.setItem("user", JSON.stringify(res.data.user));
        localStorage.setItem("token", res.data.token);

        onLoginSuccess(res.data.user);

        fetchCartItems();
      } else {
        alert("Registration successful! Please log in.");
        setIsLogin(true);
      }
    } catch (err) {
      alert(err.response?.data?.message || "Something went wrong");
      console.error("Login/Register error:", err);
    }
  };

  return (
    <Card className="shadow-sm rounded-4 p-4">
      <Card.Body>
        <h3 className="text-center mb-4 fw-bold">
          {isLogin ? "Login" : "Create an Account"}
        </h3>

        <Form onSubmit={handleSubmit}>
          {!isLogin && (
            <Form.Group className="mb-3">
              <Form.Label>Full Name</Form.Label>
              <Form.Control
                type="text"
                name="name"
                value={formData.name}
                onChange={handleChange}
                required
              />
            </Form.Group>
          )}

          <Form.Group className="mb-3">
            <Form.Label>Email</Form.Label>
            <Form.Control
              type="email"
              name="email"
              value={formData.email}
              onChange={handleChange}
              required
            />
          </Form.Group>

          <Form.Group className="mb-3">
            <Form.Label>Password</Form.Label>
            <Form.Control
              type="password"
              name="password"
              value={formData.password}
              onChange={handleChange}
              required
            />
          </Form.Group>

          {!isLogin && (
            <Form.Group className="mb-3">
              <Form.Label>Confirm Password</Form.Label>
              <Form.Control
                type="password"
                name="confirmPassword"
                value={formData.confirmPassword}
                onChange={handleChange}
                required
              />
            </Form.Group>
          )}

          <Button type="submit" className="w-100">
            {isLogin ? "Login" : "Sign Up"}
          </Button>
        </Form>

        <p className="text-center mt-3 mb-0">
          {isLogin ? (
            <>
              Don't have an account?{" "}
              <Button
                variant="link"
                className="p-0"
                onClick={() => setIsLogin(false)}
              >
                Sign Up
              </Button>
            </>
          ) : (
            <>
              Already have an account?{" "}
              <Button
                variant="link"
                className="p-0"
                onClick={() => setIsLogin(true)}
              >
                Login
              </Button>
            </>
          )}
        </p>
      </Card.Body>
    </Card>
  );
}
