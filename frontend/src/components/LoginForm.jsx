import React, { useState } from 'react';
import axios from 'axios';
import Input from './Input';
import { Link } from 'react-router-dom';


const LoginForm = () => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [loginError, setLoginError] = useState(null);

  const handleLogin = async (e) => {
        e.preventDefault();
        try {
            const response = await axios.post('/api/login', {
        email: email,
        password: password,
      });
      console.log('Login successful', response.data.message);

      localStorage.setItem('username', response.data.user.name);
      console.log(localStorage.getItem('username'));

      setEmail('');
      setPassword('');
      setLoginError(null);
      window.location.href = '/login';
      // window.location.href = '/two-factor-verification';

    } catch (error) {
            console.error('Login error:', error);
            setLoginError('Incorrect email or password');
        }
    };

  return (
    <div>
        <form onSubmit={handleLogin}>
          <h1>Login</h1>
          <h2>Feel free to login to start buying!</h2>

          {loginError && <p style={{ color: 'red' }}>{loginError}</p>}

          <Input type='email' placeholder='Email' item={email} setItem={setEmail} />
          <Input type='password' placeholder='Password' item={password} setItem={setPassword} />

          <button type='submit'>Login</button>
        </form>
        <Link to={'/password-recovery'} >Forgot your password?</Link>
    </div>
  );
};

export default LoginForm;
