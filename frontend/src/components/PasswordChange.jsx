import React, { useState } from 'react'
import Input from './Input'
import axios from 'axios';


const PasswordChange = () => {
    const [oldPassword, setOldPassword] = useState('');
    const [newPassword, setNewPassword] = useState('');
    const [passwordError, setpasswordError] = useState('');
   

    const handlePasswordChange = async (e) => {
      e.preventDefault();
      try {
        const response = await axios.post('/api/change-password', {
          oldPassword: oldPassword,
          newPassword: newPassword
        });
    
        console.log(response.data.message);
      } catch (error) {
        if (error.response && error.response.status === 401) {
          setpasswordError(error.response.data.message);
        } else {
          console.error('An error occurred:', error);
        }
      }
    };

  return (
    <div>
         <div>
      <p>Do you want to change your password?</p>
      <form onSubmit={handlePasswordChange}>
      {passwordError && <p style={{ color: 'red' }}>{passwordError}</p>}
        <Input type='password' placeholder='Old password' item={oldPassword} setItem={setOldPassword}/>
        <Input 
          type='password' placeholder='New password' 
          minLength={6} 
          title="Password must be at least 6 characters long and contain at least one uppercase letter and one number" 
          pattern="^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{6,}$"
          item={newPassword} setItem={setNewPassword} /> 
          <button type='submit'>Change password</button>
      </form>
      </div>
        
    </div>
  )
}

export default PasswordChange