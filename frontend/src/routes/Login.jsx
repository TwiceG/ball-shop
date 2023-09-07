import React from 'react';
import LoginForm from '../components/LoginForm';
import WelcomeUser from '../components/WelcomeUser';


const Login = () => {

  return (
    <div>
      { localStorage.getItem('username') ? <WelcomeUser /> : <LoginForm />}
    </div>
  );
}

export default Login;
