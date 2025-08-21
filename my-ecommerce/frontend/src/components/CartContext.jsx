import axios from "axios";
import { createContext, useContext, useEffect, useState } from "react";

const CartContext = createContext();

export const CartProvider = ({ children }) => {
  const [cartItems, setCartItems] = useState([]);
  const [loading, setLoading] = useState(true);

  const fetchCartItems = async () => {
    try {
      const token = localStorage.getItem("token");

      const res = await axios.get("http://localhost:8000/api/cart", {
        headers: {
          Authorization: `Bearer ${token}`,
        },
        withCredentials: true,
      });
      setCartItems(res.data.items || []);
    } catch (err) {
      console.error("Error fetching cart items:", err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchCartItems();
  }, []);

  const addToCart = async () => {
    await fetchCartItems();
  };

  const removeFromCart = async (id) => {
    try {
      const token = localStorage.getItem("token");
      await axios.delete(`http://localhost:8000/api/cart/remove/${id}`, {
        headers: {
          Authorization: `Bearer ${token}`,
        },
        withCredentials: true,
      });
      await fetchCartItems();
    } catch (err) {
      console.error("Error removing from cart:", err);
    }
  };

  const getTotalQuantity = () => {
    if (!Array.isArray(cartItems)) return 0;
    return cartItems.reduce((sum, item) => sum + (item.qty || 0), 0);
  };

  const getTotalAmount = () => {
    return cartItems.reduce(
      (total, item) => total + parseFloat(item.row_total || 0),
      0
    );
  };

  const clearCart = () => {
    setCartItems([]);
  };

  return (
    <CartContext.Provider
      value={{
        cartItems,
        addToCart,
        removeFromCart,
        getTotalQuantity,
        getTotalAmount,
        clearCart,
        loading,
        fetchCartItems,
      }}
    >
      {children}
    </CartContext.Provider>
  );
};

export const useCart = () => useContext(CartContext);
