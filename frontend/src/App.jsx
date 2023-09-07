
import { BrowserRouter } from 'react-router-dom';
import Approuter from './routes/Approuter';
import { Navbar } from './components/Navbar';

function App() {

  return (
    
    <div className='App'>
      <BrowserRouter>
          <Navbar />
          <Approuter />
      </BrowserRouter>
    </div>
  
  )
}

export default App
