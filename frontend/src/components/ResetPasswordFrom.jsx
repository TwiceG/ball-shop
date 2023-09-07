import React, { useState, useEffect } from 'react';
import { useParams } from 'react-router-dom';
import axios from 'axios';

const ResetPasswordForm = () => {
  const { token } = useParams();
  const [newPassword, setNewPassword] = useState('');
  const [passwordResetMessage, setPasswordResetMessage] = useState('');

  const handleResetPassword = async () => {
    try {
      const response = await axios.post('/api/reset-password', {
        token: token,
        newPassword: newPassword,
      });

      setPasswordResetMessage(response.data.message);
    } catch (error) {
      console.log(error);
      setPasswordResetMessage('Error resetting password. Please try again.');
    }
  };

  return (
    <div>
      <h2>Reset Password</h2>
      <input
        type="password"
        placeholder="Enter new password"
        value={newPassword}
        onChange={(e) => setNewPassword(e.target.value)}
      />
      <button onClick={handleResetPassword}>Reset Password</button>
      <p>{passwordResetMessage}</p>
    </div>
  );
};

export default ResetPasswordForm;
