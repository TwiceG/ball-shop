import axios from 'axios';
import React, { useEffect, useState } from 'react';
import Product from '../components/Product';
import '../styles/Products.css';

const Products = () => {
    const [products, setProducts] = useState([]);

    const getAllProducts = async () => {
        try {
            const response = await axios.get('/api/products');
            setProducts(response.data);
        } catch (error) {
            console.error('Error fetching products:', error);
        }
    }

    useEffect(() => {
        getAllProducts();
    }, [])

    return (
      <div className="product-grid">
      <h1>Shop whatever you like!!</h1>
      <p>
      Enjoy special discounts: Get 5%
        off when purchasing 3 or more items, and enjoy an even bigger 10% off
        when buying 5 or more products!
      </p>
      <div className="product-grid-container">
          {products.map((product) => (
              <div key={product.id} className="product-grid-item">
                  <Product product={product} />
              </div>
          ))}
      </div>
  </div>
    )
}

export default Products;
