import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Route, Routes } from 'react-router-dom';
import { CarDataProvider } from '../context/car_data';
import { UserProvider } from '../context/user';
import { APP_ROUTES } from '../routes';
import Footer from './Footer';
import Header from './Header';
import Home from './pages/Home';
import ListingPage from './pages/market/ListingPage';
import MarketPlace from './pages/market/MarketPlace';
import SellerPage from './pages/market/SellerPage';
import NotFound from './pages/NotFound';

function App() {
    return (
        // Makes user available throughout the app
        <UserProvider>
        <CarDataProvider>

            <Header />

            <Routes>
                <Route path={APP_ROUTES.HOME} element={<Home />} />

                {/* MARKETPLACE */}
                <Route path={APP_ROUTES.MARKET_MAIN} element={<MarketPlace />} />
                <Route path={APP_ROUTES.MARKET_CATEGORY} element={<MarketPlace />} />
                <Route path={APP_ROUTES.MARKET_SELLER_PAGE} element={<SellerPage />} />
                <Route path={APP_ROUTES.MARKET_SINGLE_CAR} element={<ListingPage />} />

                {/* 404 */}
                <Route path="*" element={<NotFound />} />
            </Routes>

            <Footer />

        </CarDataProvider>
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
