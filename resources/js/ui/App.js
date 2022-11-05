import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Navigate, Route, Routes } from 'react-router-dom';
import { UserProvider } from '../context/user';
import { APP_ROUTES, getAppRoute } from '../routes';
import Header from './components/Header';
import Footer from './components/Footer';
import Login from './pages/auth/Login';
import Home from './pages/Home';
import ListingPage from './pages/market/ListingPage';
import MarketPlace from './pages/market/MarketPlace';
import SellerPage from './pages/market/SellerPage';
import NotFound from './pages/NotFound';
import Favorites from './pages/user/Favorites';
import Signup from './pages/auth/Signup';
import VerifyEmail from './pages/auth/VerifyEmail';
import Alerts from './pages/user/Alerts';
import Account from './pages/user/Account';
import CreateAd from './pages/seller/CreateAd';
import SellerAds from './pages/seller/SellerAds';
import NewAlert from './pages/user/NewAlert';

function App() {
    return (
        <>
            {/* auth user provider */}
            <UserProvider>

                {/* ROUTES WITHOUT SHARED HEADER AND FOOTER */}
                <Routes>

                    <Route path={APP_ROUTES.LOG_IN} element={<Login />} />

                    <Route path={APP_ROUTES.SIGN_UP} element={<Signup />} />
                    <Route path={APP_ROUTES.VERIFY_EMAIL} element={<VerifyEmail />} />

                    {/* ALL WITH SHARED HEADER AND FOOTER */}
                    <Route path="*" element={
                        <>
                            <Header />

                            <Routes>
                                <Route path={APP_ROUTES.HOME} element={<Home />} />


                                {/* MARKETPLACE */}
                                <Route path={APP_ROUTES.MARKET_MAIN} element={<MarketPlace />} />
                                <Route path={APP_ROUTES.MARKET_CATEGORY} element={<MarketPlace />} />
                                <Route path={APP_ROUTES.MARKET_SELLER_PAGE} element={<SellerPage />} />
                                <Route path={APP_ROUTES.MARKET_SINGLE_CAR} element={<ListingPage />} />

                                {/* USER PAGES */}
                                <Route path={APP_ROUTES.FAVORITES} element={<Favorites />} />
                                <Route path={APP_ROUTES.ALERTS} element={<Alerts />} />
                                <Route path={APP_ROUTES.CREATE_ALERT} element={<NewAlert />} />
                                <Route path={APP_ROUTES.ACCOUNT} element={<Account />} />

                                 {/* SELLLER PAGES */}
                                <Route path={APP_ROUTES.CREATE_AD} element={<CreateAd />} />
                                <Route path={APP_ROUTES.VIEW_ADS} element={<SellerAds />} />

                                {/* 404 */}
                                <Route path="*" element={<NotFound />} />
                            </Routes>

                            <Footer />
                        </>

                    } />
                </Routes>

            </UserProvider>

        </>
    );
}

export default App;

if (document.getElementById('app')) {
    ReactDOM.render(
        <BrowserRouter basename="app">
            <App />
        </BrowserRouter>,
        document.getElementById('app')
    );
}
