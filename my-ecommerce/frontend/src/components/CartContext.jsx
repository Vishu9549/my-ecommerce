import axios from "axios";
import { createContext, useContext, useEffect, useState } from "react";

// Context create
const CartContext = createContext();

export const CartProvider = ({ children }) => {
  const [cartItems, setCartItems] = useState([]);
  const [loading, setLoading] = useState(true);

  // ✅ 1. Laravel se cart items laane wali function
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

  // ✅ 2. React load hote hi Laravel session bana do
  useEffect(() => {
  fetchCartItems(); // This internally calls /api/cart
}, []);

  // ✅ 3. AddToCart call ke baad data refresh
  const addToCart = async () => {
    await fetchCartItems(); // After backend POST
  };

  // ✅ 4. Remove from cart by ID
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

  // ✅ 5. Total Quantity
  const getTotalQuantity = () => {
    if (!Array.isArray(cartItems)) return 0;
    return cartItems.reduce((sum, item) => sum + (item.qty || 0), 0);
  };

  // ✅ 6. Total Amount
  const getTotalAmount = () => {
    return cartItems.reduce((total, item) => total + parseFloat(item.row_total || 0), 0);
  };


  const clearCart = () => {
  setCartItems([]); // Frontend cart state empty
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

// Custom hook
export const useCart = () => useContext(CartContext);
