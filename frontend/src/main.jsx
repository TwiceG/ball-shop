import React from 'react'
import ReactDOM from 'react-dom/client'
import App from './App.jsx'
import './styles/index.css'
import CartItemsProvider from './context/CartItemsProvider.jsx'

ReactDOM.createRoot(document.getElementById('root')).render(
  <React.StrictMode>
    <CartItemsProvider>
      <App />
    </CartItemsProvider>
  </React.StrictMode>,
)
