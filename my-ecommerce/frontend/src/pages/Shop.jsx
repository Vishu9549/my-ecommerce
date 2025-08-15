import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { useParams, useNavigate } from 'react-router-dom';
import { FaHeart } from 'react-icons/fa';

const Shop = () => {
  const [products, setProducts] = useState([]);
  const { slug } = useParams();
  const [loading, setLoading] = useState(false);
  const navigate = useNavigate();
  const [wishlist, setWishlist] = useState([]);


  const handleViewDetails = (product) => {
  navigate(`/product/${product.slug || product.id}`);
};

  // 🔹 Fetch Products
  useEffect(() => {
    const fetchProducts = async () => {
      try {
        let res;
        if (slug) {
          res = await axios.get(`http://127.0.0.1:8000/api/category/${slug}`);
        } else {
          res = await axios.get('http://127.0.0.1:8000/api/products');
        }
        setProducts(res.data);
      } catch (error) {
        console.error('Error fetching products:', error);
      }
    };

    fetchProducts();
  }, [slug]);

  // 🔹 Fetch Wishlist items for logged in user
  useEffect(() => {
    const fetchWishlist = async () => {
      try {
        const token = localStorage.getItem('token');
        if (!token) return;

        const res = await axios.get('http://127.0.0.1:8000/api/wishlist', {
          headers: { Authorization: `Bearer ${token}` },
        });

        // store product ids in wishlist state
        setWishlist(res.data.map(item => item.product_id));
      } catch (error) {
        console.error('Error fetching wishlist:', error);
      }
    };

    fetchWishlist();
  }, []);

  // 🔹 Toggle Wishlist
  const toggleWishlist = async (productId) => {
    try {
      const token = localStorage.getItem('token');
      if (!token) {
        alert("Please login to manage wishlist.");
        return;
      }

      if (wishlist.includes(productId)) {
        // ✅ Remove from wishlist
        await axios.delete(
          `http://127.0.0.1:8000/api/wishlist/remove/${productId}`,
          { headers: { Authorization: `Bearer ${token}` } }
        );
        setWishlist(prev => prev.filter(id => id !== productId));
      } else {
        // ✅ Add to wishlist
        await axios.post(
          `http://127.0.0.1:8000/api/wishlist/add`,
          { product_id: productId },
          { headers: { Authorization: `Bearer ${token}` } }
        );
        setWishlist(prev => [...prev, productId]);
      }
    } catch (error) {
      console.error('Error updating wishlist:', error);
    }
  };

  return (
    <div className="container py-5">
      <h2 className="mb-4 text-center">{slug ? `${slug} Products` : 'All Products'}</h2>

      <div className="row">
        {products.length === 0 ? (
          <div className="col-12 text-center">No products found.</div>
        ) : (
          products.map((product) => (
            <div key={product.id} className="col-md-4 mb-4">
              <div className="card h-100 shadow-sm position-relative">
                
                {/* Wishlist button */}
                <button
                  className="position-absolute d-flex align-items-center justify-content-center shadow"
                  style={{
                    top: '10px',
                    right: '10px',
                    borderRadius: '50%',
                    width: '40px',
                    height: '40px',
                    backgroundColor: '#f9fdfaff',
                    border: 'none',
                    cursor: 'pointer'
                  }}
                  onClick={() => toggleWishlist(product.id)}
                >
                  <FaHeart
                    color={wishlist.includes(product.id) ? 'red' : 'green'} // toggle color
                    size={18}
                  />
                </button>

                <img
                  src={
                    product.image?.startsWith('http')
                      ? product.image
                      : `http://127.0.0.1:8000/uploads/product/${product.image}`
                  }
                  alt={product.name}
                  className="img-fluid mb-4"
                  style={{ objectFit: 'cover', height: '250px', width: '100%' }}
                  onError={(e) => { e.target.src = '/images/default-product.png'; }}
                />

                <div className="card-body d-flex flex-column justify-content-between">
                  <h5 className="card-title">{product.name}</h5>
                  <p className="card-text">₹{product.price}</p>
                  <button
                    className="btn btn-outline-primary mt-auto"
                    onClick={() => handleViewDetails(product)}
                    disabled={loading}
                  >
                    View Details
                  </button>
                </div>
              </div>
            </div>
          ))
        )}
      </div>
    </div>
  );
};

export default Shop;
