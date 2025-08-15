import React, { useEffect, useState } from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import Navbar from './components/Navbar';
import Footer from './components/Footer';
import Cart from './components/Cart';
import Home from './pages/Home';
import Shop from './pages/Shop';
import About from './pages/About';
import Services from './pages/Services';
import Blog from './pages/Blog';
import Contact from './pages/Contact';
import Checkout from './components/Checkout';
import ThankYouPage from './components/ThankYouPage';
import ProductDetail from './pages/ProductDetail';
import { CartProvider } from './components/CartContext'; // 🔹 import CartContext
import axios from 'axios';
import Login from './pages/Login';
import AccountPage from './pages/AccountPage';

import OrderDetails from './pages/OrderDetails';






function App() {

 

  return (
    <CartProvider> {/* 🔹 Wrap with CartProvider */}
      <Router>
        <Navbar />
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/page/shop" element={<Shop />} />
          <Route path="/categories/:parentSlug/:childSlug" element={<Shop />} />
          <Route path="/page/about" element={<About />} />
          <Route path="/page/services" element={<Services />} />
          <Route path="/page/blog" element={<Blog />} />
          <Route path="/contact" element={<Contact />} />
          <Route path="/cart" element={<Cart />} />
          <Route path="/checkout" element={<Checkout />} />
          <Route path="/thankyou" element={<ThankYouPage />} />
          <Route path="/product/:slug" element={<ProductDetail />} />
          <Route path="/login"  element={<Login/>} />
          <Route path="/account" element={<AccountPage />} />
          <Route path="/order-details/:orderId" element={<OrderDetails />} />
        </Routes>
        <Footer />
      </Router>
    </CartProvider>
  );
}

export default App;
