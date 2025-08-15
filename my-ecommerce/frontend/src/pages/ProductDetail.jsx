import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { useParams, Link, useNavigate } from 'react-router-dom';
import { useCart } from '../components/CartContext';

const ProductDetail = () => {
  const { slug } = useParams();
  const [product, setProduct] = useState(null);
  const [selectedOptions, setSelectedOptions] = useState({});
  const { addToCart } = useCart();
  const navigate = useNavigate();

  const token = localStorage.getItem("token");

  useEffect(() => {
    axios
      .get(`http://127.0.0.1:8000/api/product/${slug}`,{
         headers: {
        Authorization: `Bearer ${token}`
      },
      })
      
      .then((response) => setProduct(response.data))
      .catch((error) => console.error('Error fetching product:', error));
  }, [slug]);

  const handleOptionChange = (attributeName, value) => {
    setSelectedOptions((prev) => ({
      ...prev,
      [attributeName]: value,
    }));
  };

  const handleAddToCart = async () => {
  try {
    const token = localStorage.getItem("token");
    const formattedOptions = Object.entries(selectedOptions).map(
      ([attribute, value]) => ({
        attribute,
        value,
      })
    );

    const payload = {
      product_id: product.id,
      name: product.name,
      sku: product.sku,
      price: product.special_price ?? product.price,
      qty: 1,
      row_total: (product.special_price ?? product.price) * 1,
      custom_option: formattedOptions, // ✅ Send as array of objects
    };

    const response = await axios.post(
      'http://localhost:8000/api/cart/add',
       payload,
      {
        headers: {
          Authorization: `Bearer ${token}`,
        },
        withCredentials: true,
      }
    );

    addToCart({ ...product, qty: 1 });
    alert('Product added to cart!');
  } catch (error) {
    console.error('Error adding to cart:', error.response?.data || error.message);
    alert('Failed to add to cart');
  }
};

  if (!product) return <div className="text-center mt-5">Loading...</div>;

  const imageUrl = product.image?.startsWith('http')
    ? product.image
    : `http://127.0.0.1:8000/uploads/product/${product.image}`;

  return (
    <div className="container py-5">
      <div className="row mb-5 shadow bg-white rounded p-4">
        {/* Left: Image */}
        <div className="col-md-6 d-flex justify-content-center align-items-center">
          <img
            src={imageUrl}
            alt={product.name}
            className="img-fluid rounded"
            style={{ maxHeight: '450px', objectFit: 'contain' }}
          />
        </div>

        {/* Right: Product Info */}
        <div className="col-md-6">
          <h2 className="fw-bold">{product.name}</h2>
          <p className="text-muted">SKU: {product.sku}</p>

          <h4 className="text-danger">
            ₹ {product.special_price ?? product.price}
          </h4>
          {product.special_price && (
            <small className="text-muted text-decoration-line-through">
              ₹ {product.price}
            </small>
          )}

          <div className="mt-3">
            <strong>Stock Status:</strong>{' '}
            {product.stock_status === 'in_stock' ? '✅ In Stock' : '❌ Out of Stock'}
          </div>

          <div className="mt-3">
            <strong>Short Description:</strong>
            <p>{product.short_description}</p>
          </div>

          <div className="mt-3">
            <strong>Weight:</strong> {product.weight ?? 'N/A'} kg
          </div>

          {/* Attributes */}
          {product.attributes?.length > 0 && (
            <div className="mt-4">
              <strong>Choose Options:</strong>
              {product.attributes.map((attr, index) => (
                <div className="mb-2" key={index}>
                  <label className="form-label">{attr.name}</label>
                  <select
                    className="form-select"
                    onChange={(e) => handleOptionChange(attr.name, e.target.value)}
                    defaultValue=""
                  >
                    <option value="" disabled>
                      Select {attr.name}
                    </option>
                    {attr.values.map((val, i) => (
                      <option key={i} value={val}>
                        {val}
                      </option>
                    ))}
                  </select>
                </div>
              ))}
            </div>
          )}

          <button
            onClick={handleAddToCart}
            className="btn btn-danger mt-4 w-100"
          >
            Add to Cart
          </button>
        </div>
      </div>

      {/* Related Products */}
      {product.related_products?.length > 0 && (
        <div className="related-products mt-5">
          <h4 className="mb-4">Related Products</h4>
          <div className="row">
            {product.related_products.map((related, index) => {
              const relatedImage = related.image?.startsWith('http')
                ? related.image
                : `http://127.0.0.1:8000/uploads/product/${related.image}`;
              return (
                <div key={index} className="col-sm-6 col-md-4 col-lg-3 mb-4">
                  <div className="card h-100 shadow-sm">
                    <img
                      src={relatedImage}
                      alt={related.name}
                      className="card-img-top"
                      style={{ height: '200px', objectFit: 'cover' }}
                    />
                    <div className="card-body d-flex flex-column">
                      <h5 className="card-title">{related.name}</h5>
                      <p className="text-danger mb-1">
                        ₹ {related.special_price ?? related.price}
                      </p>
                      {related.special_price && (
                        <small className="text-muted text-decoration-line-through">
                          ₹ {related.price}
                        </small>
                      )}
                      <Link
                        to={`/product/${related.slug}`}
                        className="btn btn-outline-primary btn-sm mt-auto"
                      >
                        View Details
                      </Link>
                    </div>
                  </div>
                </div>
              );
            })}
          </div>
        </div>
      )}
    </div>
  );
};

export default ProductDetail;
