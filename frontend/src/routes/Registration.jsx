import React from 'react'
import RegisterForm from '../components/RegisterForm'

const Registration = () => {
  return (
    <div>
        <h1>Registration</h1>
        <h2>Please Register to our page to buy some Balls!</h2>
        <h5>You must fill the the columns marked with '*' !</h5>
        <RegisterForm />
    </div>
  )
}

export default Registration