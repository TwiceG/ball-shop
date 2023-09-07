import React, { useEffect } from 'react';
import axios from 'axios';


const Logout = () => {


  useEffect(() => {
    const logoutUser = async () => { 
      try {
        await axios.post('/api/logout');
        localStorage.clear();

        setTimeout(() => {
            window.location.href = '/';
          }, 1500); 

      } catch (error) {
        console.error('Logout error:', error);
      }
    };

    logoutUser();
  }, []);

  return (
    <div>
      <h1>Thank you for visiting our website.</h1>
    </div>
  );
};

export default Logout;
