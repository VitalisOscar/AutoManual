import React from 'react';
import { Link } from 'react-router-dom';
import { APP_ROUTES } from '../routes';

function Footer() {
    return (
        <footer className="pt-5 text-white">

        <div className="container">
            <div className="row">

                <div className="col-sm-8 col-md-6 mb-3">

                    <div className="mb-3">
                        <h4 className="heading text-white">Get our news straight to your inbox!</h4>
                        <form action="" method="post" className="py-2" id="newsletter-form" autoComplete= "off">
                            <div className="input-group mb-2">
                                <input type= "email" className="form-control default" placeholder="Your Email" name="email" required />
                                <div className="input-group-append">
                                    <button className="btn btn-success border-0 px-3">Sign Up</button>
                                </div>
                            </div>

                            <small className="text-light">We do not share your data with third parties.You can opt out any time.</small>
                        </form>
                    </div>

                </div>

            </div>

            <div className="row">

                <div className="col-sm-5">
                    <div className="mb-3">
                        <h6 className="heading text-white">About Us</h6>
                        <p>
                            We are a platform that brings together individual car sellers, agents, dealers, auto companies and potential car buyers. Buy and list new, imported and used vehicles easily.
                        </p>
                    </div>

                    <div>

                        <h6 className="heading text-white">Connect with Us</h6>
                        <div className="py-2 mb-4">

                            <a href= "" className="icon icon-shape bg-primary text-white mr-1">
                                <i className="fa fa-facebook"></i>
                            </a>

                            <a href= "" className="icon icon-shape bg-info text-white mx-1">
                                <i className="fa fa-twitter"></i>
                            </a>

                            <a href= "" className="icon icon-shape bg-danger text-white ml-1">
                                <i className="fa fa-instagram"></i>
                            </a>

                        </div>

                    </div>

                </div>

                <div className="col-sm-7">
                    <div className="row">

                        <div className="col-sm">
                            <div>
                                <h6 className="heading text-white">Car Sellers</h6>

                                <ul className="list-unstyled">
                                    <li className="mb-2 px-2">
                                        <Link to={APP_ROUTES.SELLER_REGISTRATION}>
                                            <i className="fa fa-caret-right mr-1"></i>Registration
                                        </Link>
                                    </li>

                                    <li className="mb-2 px-2">
                                        <Link to={APP_ROUTES.LOG_IN}>
                                            <i className="fa fa-caret-right mr-1"></i>Sign In
                                        </Link>
                                    </li>

                                    <li className="mb-2 px-2">
                                        <Link to={APP_ROUTES.VIEW_ADS}>
                                            <i className="fa fa-caret-right mr-1"></i>My Listings
                                        </Link>
                                    </li>

                                    <li className="mb-2 px-2">
                                        <Link to={APP_ROUTES.CREATE_AD}>
                                            <i className="fa fa-caret-right mr-1"></i>New Ad
                                        </Link>
                                    </li>

                                </ul>
                            </div>
                        </div>

                        <div className="col-sm">
                            <div>
                                <h6 className="heading text-white">Buyers</h6>

                                <ul className="list-unstyled">
                                    <li className="mb-2 px-2">
                                        <Link to={APP_ROUTES.SIGN_UP}>
                                            <i className="fa fa-caret-right mr-1"></i>Create Account
                                        </Link>
                                    </li>

                                    <li className="mb-2 px-2">
                                        <Link to={APP_ROUTES.LOG_IN}>
                                            <i className="fa fa-caret-right mr-1"></i>Log In
                                        </Link>
                                    </li>

                                    <li className="mb-2 px-2">
                                        <Link to={APP_ROUTES.FAVORITES}>
                                            <i className="fa fa-caret-right mr-1"></i>Favorite Listings
                                        </Link>
                                    </li>

                                    <li className="mb-2 px-2">
                                        <Link to={APP_ROUTES.ALERTS}>
                                            <i className="fa fa-caret-right mr-1"></i>New Listing Alerts
                                        </Link>
                                    </li>

                                </ul>
                            </div>

                            <div>
                                <h6 className="heading text-white">Other</h6>

                                <ul className="list-unstyled">
                                    <li className="mb-2 px-2"><a href= "mailto:info@automanual.co.ke?subject=Feedback"><i className="fa fa-caret-right mr-1"></i>Feedback</a></li>
                                </ul>
                            </div>
                        </div>

                        <div className="col-sm">
                            <div>

                                <h6 className="heading text-white">Get in touch</h6>
                                <ul className="list-unstyled">
                                    <li className="px-1 mb-2">
                                        <a href="">
                                            <i className="fa fa-fw fa-map-marker mr-2 text-primary"></i>
                                            Nairobi Kenya
                                        </a>
                                    </li>
                                    <li className="px-1 mb-2">
                                        <a href="tel:+254790210091">
                                            <i className="fa fa-fw fa-phone mr-2 text-success"></i>
                                            +2547 90 210 091
                                        </a>
                                    </li>
                                    <li className="px-1">
                                        <a href="mailto:info@automanual.co.ke">
                                            <i className="fa fa-fw fa-envelope mr-2 text-warning"></i>
                                            info@automanual.co.ke
                                        </a>
                                    </li>
                                </ul>

                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

        <div className="bg-dark p-2 text-center">
            <small>&copy;{new Date().getFullYear()} All Rights Reserved | AutoManual</small>
        </div>

    </footer>
    );
}

export default Footer;
