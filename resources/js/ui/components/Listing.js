import React from 'react';
import { Link } from 'react-router-dom';
import { APP_ROUTES, getAppRoute } from '../../routes';

function Listing({ car }) {
    return (
        <div className="container">
            <img src={car.main_image.url} />
            <h4>{car.title}</h4>
            <Link to={
                getAppRoute(APP_ROUTES.MARKET_SINGLE_CAR, {slug: car.slug})
            }
            >View</Link>
        </div>
    );
}

export default Listing;
