import React from 'react';
import { Route, Routes } from 'react-router-dom';
import { APP_ROUTES } from '../../../routes';
import ListingPage from './ListingPage';
import MarketHome from './MarketHome';
import SellerPage from './SellerPage';

function MarketPlace() {

    return (
        <Routes>
            <Route exact path="" element={<MarketHome />} />

            <Route path={APP_ROUTES.MARKET_PLACE.SELLER_PAGE} element={<SellerPage />} />

            <Route path={APP_ROUTES.MARKET_PLACE.SINGLE_CAR} element={<ListingPage />} />
        </Routes>
    );
}

export default MarketPlace;
