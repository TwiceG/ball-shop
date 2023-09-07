import "../styles/Navbar.css";
import { Link } from 'react-router-dom';


export const Navbar = () => {

  return (
    <nav>
      <ul>
        <li><Link to="/">Home</Link></li>
        <li><Link to="/products">Balls</Link></li>
        {localStorage.getItem('username') ? (
          <>
            <li><h4>Welcome, {localStorage.getItem('username')}</h4></li>
            <li><Link to="/profile">Profile</Link></li>
            <li><Link to="/logout">Logout</Link></li>
            <div id="shopping-cart"><Link to={"/shopping-cart"}> <img src="../../shopping-cart.png" alt="shopping-cart" /> </Link></div>
          </>
          
        ) : (
          <>
            <li><Link to="/login">Login</Link></li>
            <li><Link to="/register">Register</Link></li>
          </> 
        )}
        
      </ul>
    </nav>
  );
};
