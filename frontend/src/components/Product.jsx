import React, { useEffect, useState } from 'react';
import '../styles/Card.css';
import axios from 'axios';
import Input from './Input';
import { useCartItems } from '../context/CartItemsProvider';


const FIVE_PERCENT_DISCOUNT = 0.95;
const TEN_PERCENT_DISCOUNT = 0.9;



const Product = ({ product }) => {
  const isShoppingCartPage = window.location.pathname === '/shopping-cart';
  const [quantity, setQuantity] = useState(isShoppingCartPage ? product.quantity : 1);
  const [price, setPrice] = useState(product.price);
  const isLoggedIn = localStorage.getItem('username');

  const { cartItems,  updateCartItems } = useCartItems();


  const updateCart = () => {
    // Find the item with the same product ID in cartItems
    const existingItem = cartItems.find(item => item.product && item.product.id === product.id);

    if (existingItem) {
      // If the item exists, update its quantity and price
      const updatedItem = { ...existingItem, quantity: quantity, price: price };
      const updatedCartItems = cartItems.map(item =>
        item.product.id === product.id ? updatedItem : item
      );
      updateCartItems(updatedCartItems);
    } else {
      // If the item doesn't exist, add it to cartItems
      const newItem = { id: product.id, quantity: quantity, price: price };
      updateCartItems([...cartItems, newItem]);
    }
  }

  const handleAddToCart = async () => {
    const response = await axios.post('/api/add-to-cart', {
      product_id: product.id,
      quantity: quantity,
      price: price
    });

    console.log(response.data.message + product.id);
  };

  const handleDiscount = (quantity) => {
    if (quantity >= 3 && quantity <= 5) {
      return FIVE_PERCENT_DISCOUNT;
    } else if (quantity > 5) {
      return TEN_PERCENT_DISCOUNT;
    }
    return 1; // No discount
  };

  useEffect(() => {
    const discount = handleDiscount(quantity);
    setPrice((product.price * quantity * discount).toFixed(2));
    if(cartItems) {
      updateCart();
    }
  }, [quantity]);


  return (
    <div className="product-card">
      <img
        src={'../../' + (product.image || 'ball2.png')}
        alt={product.name}
        className="product-image"
      />
      <h3>{product.name}</h3>
      <p>{product.description}</p>
      <p>${price}</p>
      <div className="quantity-container">
        <label>Quantity:</label>
        <Input item={quantity} type="number" setItem={setQuantity} min="0" />
      </div>
      {!isShoppingCartPage && isLoggedIn &&(
        <button onClick={handleAddToCart}>Add to Cart</button>
      )}
    </div>
  );
};

export default Product;
