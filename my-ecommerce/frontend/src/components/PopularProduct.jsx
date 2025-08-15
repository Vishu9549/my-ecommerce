import React from 'react';
import '../assets/scss/style.scss'; // Adjust this path to where your SCSS is located

const PopularProduct = () => {
  const products = [
    {
      img: '/images/product-1.png',
      title: 'Nordic Chair',
      description: 'Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio',
    },
    {
      img: '/images/product-2.png',
      title: 'Kruzo Aero Chair',
      description: 'Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio',
    },
    {
      img: '/images/product-3.png',
      title: 'Ergonomic Chair',
      description: 'Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio',
    },
  ];

  return (
    <div className="popular-product bg-light ">
      <div className="container">
        <div className="row">
          {products.map((product, index) => (
            <div className="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0" key={index}>
              <div className="product-item-sm d-flex">
                <div className="thumbnail">
                  <img src={product.img} alt={product.title} className="img-fluid" />
                </div>
                <div className="pt-3">
                  <h3>{product.title}</h3>
                  <p>{product.description}</p>
                  <p><a href="#">Read More</a></p>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
};

export default PopularProduct;
