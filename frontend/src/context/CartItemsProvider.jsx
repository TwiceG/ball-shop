import React, { createContext, useContext, useState } from 'react';

const CartItemsContext = createContext();

export function useCartItems() {
  return useContext(CartItemsContext);
}

export default function CartItemsProvider({ children }) {
  const [cartItems, setCartItems] = useState([]);

  const updateCartItems = (updatedItems) => {
    setCartItems(updatedItems);
  };

  return (
    <CartItemsContext.Provider value={{ cartItems, updateCartItems }}>
      {children}
    </CartItemsContext.Provider>
  );
}
