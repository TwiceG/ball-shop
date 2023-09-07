import React, { useState } from 'react';
import axios from 'axios';

const TwoFactorVerificationForm = () => {

  const [twoFactorToken, setTwoFactorToken] = useState('');
  const [verificationError, setVerificationError] = useState('');

  const handleVerifyToken = async (e) => {
    e.preventDefault();

    try {
      const response = await axios.post('/api/verify-2fa-token', {
        twoFactorToken: twoFactorToken,
      });

     
      window.location.href = '/login';
    } catch (error) {
      setVerificationError('Invalid two-factor authentication token');
    }
  };

  return (
    <div>
      <h2>Two-Factor Verification</h2>
      <form onSubmit={handleVerifyToken}>
        <input
          type="text"
          placeholder="Enter 2FA Token"
          value={twoFactorToken}
          onChange={(e) => setTwoFactorToken(e.target.value)}
        />
        <button type="submit">Verify</button>
        {verificationError && <p style={{ color: 'red' }}>{verificationError}</p>}
      </form>
    </div>
  );
};

export default TwoFactorVerificationForm;
