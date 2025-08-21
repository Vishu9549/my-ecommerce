import React, { useEffect, useState } from "react";
import {
  Container,
  Row,
  Col,
  Table,
  Image,
  Spinner,
  Alert,
} from "react-bootstrap";
import { useParams } from "react-router-dom";
import { Link } from "react-router-dom";

const OrderDetails = () => {
  const { orderId } = useParams();
  const [orderItems, setOrderItems] = useState([]);
  const [orderInfo, setOrderInfo] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const token = localStorage.getItem("token");
    if (!token) {
      setError("You must be logged in to view this order");
      setLoading(false);
      return;
    }

    console.log("Order ID from URL:", orderId);

    const fetchOrderDetails = async () => {
      try {
        const res = await fetch(
          `http://127.0.0.1:8000/api/orderitems?order_id=${orderId}`,
          {
            headers: {
              Authorization: `Bearer ${token}`,
              "Content-Type": "application/json",
            },
          }
        );

        const data = await res.json();

        if (!res.ok) {
          throw new Error(data.message || "Failed to fetch order details");
        }

        if (data.length > 0) {
          setOrderItems(data);
          setOrderInfo(data[0].order);
        } else {
          setError("No order items found");
        }
      } catch (err) {
        setError(err.message);
      } finally {
        setLoading(false);
      }
    };

    fetchOrderDetails();
  }, [orderId]);

  if (loading)
    return <Spinner animation="border" className="d-block mx-auto mt-5" />;
  if (error) return <Alert variant="danger">{error}</Alert>;
  if (!orderInfo) return <Alert variant="warning">Order not found</Alert>;

  const downloadInvoice = () => {
    const token = localStorage.getItem("token");
    if (!token) {
      alert("Please login to download invoice");
      return;
    }

    fetch(`http://127.0.0.1:8000/api/orders/${orderId}/invoice`, {
      method: "GET",
      headers: {
        Accept: "application/pdf",
        Authorization: `Bearer ${token}`,
      },
    })
      .then((res) => {
        if (!res.ok) throw new Error("Failed to download invoice");
        return res.blob();
      })
      .then((blob) => {
        const url = window.URL.createObjectURL(new Blob([blob]));
        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", `invoice-${orderId}.pdf`);
        document.body.appendChild(link);
        link.click();
        link.remove();
      })
      .catch((err) => {
        console.error(err);
        alert(err.message);
      });
  };

  return (
    <Container className="mt-5">
      <Row>
        <Col>
          <h3 className="mb-3">Order #{orderInfo.order_increment_id}</h3>
          <p>
            <b>Name:</b> {orderInfo.name}
          </p>
          <p>
            <b>Email:</b> {orderInfo.email}
          </p>
          <p>
            <b>Date:</b> {new Date(orderInfo.created_at).toLocaleDateString()}
          </p>
          <p>
            <b>Status:</b> {orderInfo.status || "Pending"}
          </p>

          <h5 className="mt-4">Items Ordered</h5>
          <Table striped bordered hover responsive>
            <thead>
              <tr>
                <th>Image</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
                <th>Options</th>
              </tr>
            </thead>
            <tbody>
              {orderItems.map((item) => {
                const options = item.custom_option
                  ? JSON.parse(item.custom_option)
                  : [];
                return (
                  <tr key={item.id}>
                    <td>
                      <Link to={`/product/${item.product.slug}`}>
                        <Image
                          src={`http://127.0.0.1:8000/uploads/product/${item.product.image}`}
                          rounded
                          style={{ width: "60px", cursor: "pointer" }}
                          onError={(e) => (e.target.src = "/fallback.png")}
                        />
                      </Link>
                    </td>

                    <td>{item.product.name}</td>
                    <td>{item.qty}</td>
                    <td>₹{parseFloat(item.price).toFixed(2)}</td>
                    <td>₹{(parseFloat(item.price) * item.qty).toFixed(2)}</td>
                    <td>
                      {options.map((opt, index) => (
                        <div key={index}>
                          <b>{opt.attribute}:</b> {opt.value}
                        </div>
                      ))}
                    </td>
                  </tr>
                );
              })}
            </tbody>
          </Table>

          <h5 className="text-end mt-3">
            Subtotal: ₹{parseFloat(orderInfo.subtotal).toFixed(2)}
          </h5>
          {orderInfo.coupon && (
            <h5 className="text-end">
              Coupon ({orderInfo.coupon}): -₹
              {parseFloat(orderInfo.coupon_discount).toFixed(2)}
            </h5>
          )}
          <h5 className="text-end">
            Shipping: ₹{parseFloat(orderInfo.shipping_cost).toFixed(2)}
          </h5>
          <h4 className="text-end">
            Total: ₹{parseFloat(orderInfo.total).toFixed(2)}
          </h4>

          <div className="text-end mt-3">
            <button className="btn btn-primary" onClick={downloadInvoice}>
              Download Invoice
            </button>
          </div>
        </Col>
      </Row>
    </Container>
  );
};

export default OrderDetails;
