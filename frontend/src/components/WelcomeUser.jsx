
const WelcomeUser = () => {

  return (
    <div>
        <h1>Welcome, {localStorage.getItem('username')}!</h1>
    </div>
  )
}

export default WelcomeUser