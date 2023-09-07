import React, { useEffect, useState } from 'react'
import ShoppingCart from '../components/ShoppingCart'
import axios from 'axios'
import { Link } from "react-router-dom";
import { useCartItems } from '../context/CartItemsProvider';


const Cart = () => {
    const [products, setProducts] = useState([]);
    const { cartItems } = useCartItems();

    const getProducts = async () => {
      const response = await axios.get('/api/shopping-cart');
      return response.data;
    };
  
    useEffect(() => {
        const fetchProducts = async () => {
            const productsData = await getProducts();
            setProducts(productsData.cartItems);
          };
          fetchProducts();
    }, []);

    const handleUpdateCart = async() => {
        if (cartItems) {
            const response = await axios.post('/api/update-cart', {
                products: cartItems,
            })
            console.log(response.data.message);
        }else {
            console.log('Already up to date.');
        }
        window.location.href = "/products";
    } 


  return (
    <div>
        <h1>Shopping Cart</h1>
        <ShoppingCart products={products} />
        <button onClick={handleUpdateCart}>Update Cart</button>
        <div>
          <Link to={'/checkout'}><button>Buy</button></Link>
        </div>
    </div>
  )
}

export default Cart