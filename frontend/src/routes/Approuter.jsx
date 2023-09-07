import React from "react";
import { Routes, Route } from "react-router-dom";
import Home from "./Home";
import QRcode from "../components/QRCodeGenerator";
import Login from "./Login";
import Registration from "./Registration";
import Logout from "./Logout";
import Products from "./Products";
import Profile from "./Profile";
import Cart from "./Cart";
import Checkout from "./Checkout";
import PasswordRecovery from "./PasswordRecovery";
import ResetPassword from "./ResetPassword";
import TwoFactorAuth from "./TwoFactorAuth";



function Approuter() {
    return (  
            <Routes>
                <Route path="/" element={ <Home /> } />
                <Route path="/profile" element={ <Profile /> } />
                <Route path="/products" element={ <Products/> } />
                <Route path="/shopping-cart" element= { <Cart /> } />
                <Route path="/checkout" element={ <Checkout /> } />
                <Route path="/login" element={ <Login /> } />
                <Route path="/logout" element={ <Logout /> } />
                <Route path="/register" element={ <Registration /> } />
                <Route path="password-recovery" element={ <PasswordRecovery /> } />
                <Route path="/QRcode" element={ <QRcode /> } />
                <Route path="/password-reset/:token" element={<ResetPassword />} />
                <Route path="/two-factor-verification" element={ <TwoFactorAuth /> } />
             </Routes>
    );
}

export default Approuter;