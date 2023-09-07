import React from 'react'
import TwoFactorVerificationForm from '../components/TwoFactorVerificationForm'

const TwoFactorAuth = () => {
  return (
    <div>
        <h2>Enter you code sent in your email</h2>
        <TwoFactorVerificationForm />
    </div>
  )
}

export default TwoFactorAuth