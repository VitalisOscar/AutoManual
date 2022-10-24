import React from 'react';
import { Link } from 'react-router-dom';
import { APP_ROUTES } from '../../routes';

function NotFound() {
    return (
        <div className="container">
            <div className="row mb-4">
                <div className="col-12 col-md-10 col-lg-9 col-xl-7 mx-auto">
                    <div className="lead text-center mx-auto">
                        <div className="d-inline-block p-3 text-center text-danger mx-auto">
                            <img src="/img/icons/404.png" alt="404" style={{ height: '150px' }} />
                        </div>
                        <br/>
                        <h1 className="text-center mb-4 text13">Page Not Found</h1>

                        <div className="text-left">
                            <div>
                                Looks like you found yourself on a url that does not exist. This may be due to a broken or invalid link or visiting a link to a resource that no longer exists. Here are some things you can try:
                            </div>

                            <ul>
                                <li className="mb-1">Use internal links to navigate around</li>
                                <li className="mb-1">
                                    <div>
                                        <span>Start from the </span>
                                        <Link to={APP_ROUTES.HOME}>Home Page</Link>
                                    </div>
                                </li>
                                <li className="mb-1">
                                    <div>
                                        <span>Check out some </span>
                                        <Link to={APP_ROUTES.MARKET_MAIN}>recent listings</Link>
                                    </div>
                                </li>
                            </ul>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    );
}

export default NotFound;
