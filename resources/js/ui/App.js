import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Route, Routes } from 'react-router-dom';
import { UserProvider } from '../context/user';
import { APP_ROUTES } from '../routes';
import Header from './Header';
import Home from './pages/Home';
import MarketPlace from './pages/market/MarketPlace';

function App() {
    return (
        // Makes user available throughout the app
        <UserProvider>

            <Header />

            <Routes>
                <Route path={APP_ROUTES.HOME} element={<Home />} />
                <Route path={APP_ROUTES.MARKET_PLACE.MAIN + "/*"} element={<MarketPlace />} />
            </Routes>

        </UserProvider>
    );
}

export default App;

if (document.getElementById('app')) {
    ReactDOM.render(
        <BrowserRouter>
            <App />
        </BrowserRouter>,
        document.getElementById('app')
    );
}
