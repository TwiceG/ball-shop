import React, { useEffect, useState } from 'react';
import axios from 'axios';

const QRCodeGenerator = () => {
  const [qrCodeUrl, setQRCodeUrl] = useState('');

  const generateSecretKey = async () => {
    try {
      const response = await axios.get('/api/generate-2fa-secret', {
        withCredentials: true, // Include session cookies
      });
      setQRCodeUrl(response.data.qr_code_url);
    } catch (error) {
      console.error('Error generating 2FA secret:', error);
    }
  };

  useEffect(() => {
    generateSecretKey(); 
  }, []);

  return (
    <div>
      <h2>QR Code Generator</h2>
      <img src={qrCodeUrl} alt="2FA QR Code" />
    </div>
  );
};

export default QRCodeGenerator;
