import React, { useEffect, useState } from 'react';
import axios from 'axios';

const WhyChooseUs = () => {
  const [data, setData] = useState(null);

  useEffect(() => {
    axios
      .get('http://127.0.0.1:8000/api/blocks/why_choose_us')
      .then((res) => {
        console.log('API response:', res.data);
        setData(res.data);
      })
      .catch((err) => console.error('API error:', err));
  }, []);

  if (!data) return <div>Loading...</div>;

  const imageUrl = data.image?.[0];
  const features = data.features || [];

  return (
    <section className="why-choose-us py-5 bg-light">
      <div className="container">
        <div className="row g-4 d-flex align-items-stretch">
          <div className="col-md-6 d-flex">
            <div className="w-100 h-100">
              {imageUrl ? (
                <img
                  src={imageUrl}
                  alt={data.title}
                  className="img-fluid rounded h-100"
                  style={{
                    width: '100%',
                    maxHeight: '360px',
                    objectFit: 'cover',
                  }}
                />
              ) : (
                <p>No image found</p>
              )}
            </div>
          </div>

          <div className="col-md-6 d-flex bg-light">
            <div className="w-100 h-100 d-flex flex-column justify-content-center p-3 bg-light rounded">
              <h2 className="mb-3">{data.heading || data.title}</h2>
              {data.description && (
                <p className="text-muted mb-3">{data.description}</p>
              )}

              {features.length > 0 ? (
                <ul className="list-unstyled">
                  {features.map((item, index) => (
                    <li key={index} className="mb-2">
                      ✅ {item}
                    </li>
                  ))}
                </ul>
              ) : (
                <p>No features found</p>
              )}
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default WhyChooseUs;
