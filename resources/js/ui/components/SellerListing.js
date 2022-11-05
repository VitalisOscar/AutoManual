import React, { useState } from 'react';
import { Link } from 'react-router-dom';
import { API_ENDPOINTS, getApiUrl } from '../../api';
import { useToggleFavorite } from '../../hooks/car';
import { usePostRequest } from '../../hooks/request';
import { APP_ROUTES, getAppRoute } from '../../routes';

function SellerListing({ car }) {

    return (
        <div className={
                "col-12 col-sm-6 col-md-12 col-lg-12 col-xl-12 ad-wrap"
            }>
            <div className={car.is_boosted ? "ad boosted" : "ad"}>
                <div className="card">
                    <div className="container-fluid px-0">
                        <div className="row no-gutters">

                            <div className="col-md-4">

                                {/* CAR IMAGE */}
                                <div className="img-wrap">
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
                                {/* CAR TITLE, FAVORITE, LOCATION AND DATE ADDED */}
                                <div className="title mb-1 d-flex">
                                    <h4 className="listing-title mb-0" data-toggle="tooltip" title={car.title}>
                                        <Link to={getAppRoute(APP_ROUTES.MARKET_SINGLE_CAR, {slug: car.slug})}>
                                        {car.title}
                                        </Link>
                                    </h4>
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
                                {/* END OVERVIEW */}

                                {
                                    car.is_boosted ?
                                        <div className="small for-sponsored text-right">
                                            <i className="text-warning mr-2 fa fa-arrow-up"></i>
                                            <strong>Boosted</strong>
                                        </div>
                                    :
                                    ''
                                }

                            </div>

                            <div className="col-md-3 px-3">
                                <div className="relative">
                                    {/* PRICING */}
                                    <h4 className="car-price text-dark mb-2">{car.price}</h4>

                                    <Link to={getAppRoute(APP_ROUTES.VIEW_SINGLE_SELLER_AD, {slug: car.slug})} className="btn btn-default btn-block shadow-none">
                                        Manage Listing
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

export default SellerListing;
