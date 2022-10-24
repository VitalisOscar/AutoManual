import React from 'react';
import { Link } from 'react-router-dom';
import { APP_ROUTES, getAppRoute } from '../../routes';

function Listing({ car }) {
    return (
        <div className="col-12 col-sm-6 col-md-12 col-lg-12 col-xl-12 ad-wrap">
            <div className="ad">
                <div className="card">
                    <div className="container-fluid px-0">
                        <div className="row no-gutters">

                            <div className="col-md-4">

                                {/* CAR IMAGE AND TITLE */}

                                <div className="title-top py-2 px-3">
                                    <h5 className="listing-title my-0" data-toggle="tooltip" title={car.title}>
                                        <Link to={getAppRoute(APP_ROUTES.MARKET_SINGLE_CAR, {slug: car.slug})}>
                                            {car.title}
                                        </Link>
                                    </h5>
                                    <span className="fav-btn" data-toggle="tooltip" title="Add to Favorites">
                                        <i className="fa fa-heart-o"></i>
                                        <span className="overlay"></span>
                                    </span>
                                    <div className="clearfix"></div>
                                </div>

                                <div className="img-wrap">

                                    <span className="top-badge">
                                        <i className="fa fa-certificate"></i>
                                    </span>

                                        <div style={{background: "url(" + car.main_image.url + ")", backgroundSize: "cover"}}>
                                            <Link to={getAppRoute(APP_ROUTES.MARKET_SINGLE_CAR, {slug: car.slug})} className="d-block position-absolute top-0 bottom-0 right-0 left-0">
                                                <div className="position-absolute bottom-0 right-0 d-inline-block py-1 px-2 rounded bg-dark">
                                                    <i className="fa fa-photo text-white mr-2"></i>
                                                    <span className="text-white">{car.total_images}</span>
                                                </div>
                                            </Link>
                                        </div>
                                </div>
                            </div>

                            <div className="col-md-5 ad-info">
                                {/* CAR LOCATION AND DATE ADDED */}
                                <div className="title mb-1">
                                    <h4 className="listing-title mb-0" data-toggle="tooltip" title={car.title}>
                                        <Link to={getAppRoute(APP_ROUTES.MARKET_SINGLE_CAR, {slug: car.slug})}>
                                        {car.title}
                                        </Link>
                                    </h4>

                                    <span className="fav-btn" title="Add to Favorites">
                                        <i className="fa fa-heart-o"></i>
                                        <span className="overlay"></span>
                                    </span>
                                    <div className="clearfix"></div>
                                </div>

                                <div className="d-md-flex align-items-center">
                                    <div className="mb-2 float-left">
                                        <i className="fa fa-fw fa-map-marker mr-1"></i>{car.location.town}
                                    </div>

                                    <div className="mb-2 float-right ml-auto">
                                        <i className="fa fa-fw fa-calendar mr-1"></i>{car.added_on}
                                    </div>

                                    <div className="clearfix"></div>
                                </div>

                                {/* OVERVIEW */}
                                <div>
                                    <h5 className="heading mt-1 mb-2">Overview</h5>
                                    <div className="form-row">
                                        <div className="col-6">
                                            <i className="fas fa-car fa-fw text-primary mr-2"></i>{car.category.name}
                                        </div>

                                        <div className="col-6">
                                            <i className="fas fa-gear fa-fw text-primary mr-2"></i>{car.transmission}
                                        </div>

                                        <div className="col-6">
                                            <i className="fas fa-gas-pump fa-fw text-primary mr-2"></i>{car.fuel}
                                        </div>

                                        <div className="col-6">
                                            <i className="fa fa-dashboard fa-fw text-primary mr-2"></i>{car.mileage}
                                        </div>

                                        <div className="col-6">
                                            <i className="fa fa-calendar-o fa-fw text-primary mr-2"></i>{car.year}
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div className="col-md-3 px-3">
                                <div className="relative">
                                    {/* PRICING AND SELLER */}
                                    <h4 className="car-price text-dark mb-2">{car.price}</h4>

                                    <div class="seller mb-3">
                                        <Link to="" title={"More by " + car.seller.name} className="d-inline-block mb-1">
                                            <img src={car.seller.logo} alt={car.seller.name} class="seller-logo" />
                                        </Link>

                                        {/* VERIFICATION STATUS */}
                                        {
                                            car.seller.verified ?
                                                <div class="verified-seller d-flex align-items-center pl-3" title="The seller has been verified by AutoManual">
                                                    <strong class="text-success">Verified</strong>
                                                    <img src="/img/icons/verified.png" alt="Verified Seller" class="ml-auto mr-0 d-inline-block"/>
                                                </div>
                                            :
                                                ''
                                        }
                                    </div>

                                    <Link to={getAppRoute(APP_ROUTES.MARKET_SINGLE_CAR, {slug: car.slug})} className="btn btn-default btn-block shadow-none">
                                        Open Full Details
                                    </Link>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Listing;
