import React from 'react';
import ReactDOM from 'react-dom';
import { Link } from 'react-router-dom';
import { APP_ROUTES } from '../routes';
function Header() {
    return (
        <>
            <div className="navbar navbar-default">
                <div className="container">
                    <Link to={APP_ROUTES.HOME}>AutoManual</Link>
                    <Link to={APP_ROUTES.MARKET_PLACE.MAIN}>Buy Cars</Link>
                </div>
            </div>
        </>
    );
}

export default Header;
