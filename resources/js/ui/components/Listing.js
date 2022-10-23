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

                                <div className="title-top py-2 px-3">
                                    <h5 className="listing-title my-0" data-toggle="tooltip" title={car.title}>
                                        <a href="http://localhost/projects/vo/cars/2015-brand-new-subaru-imprezza-1.html?campaign=leads&amp;medium=internal&amp;source=search">
                                            {car.title}
                                        </a>
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
                                    </div>
                                </div>
                            </div>

                            <div className="col-md-5 ad-info">

                                <div className="title mb-1">
                                    <h4 className="listing-title mb-0" data-toggle="tooltip" title={car.title}>
                                        <a href="http://localhost/projects/vo/cars/2015-brand-new-subaru-imprezza-1.html?campaign=leads&amp;medium=internal&amp;source=search">
                                        {car.title}
                                        </a>
                                    </h4>

                                    <span class="fav-btn" title="Add to Favorites">
                                        <i className="fa fa-heart-o"></i>
                                        <span className="overlay"></span>
                                    </span>
                                    <div className="clearfix"></div>
                                </div>

                                <div className="d-md-flex align-items-center">
                                    <div className="mb-2 float-md-left">
                                        <i className="fa fa-fw fa-map-marker mr-1"></i>{car.location.town}
                                    </div>

                                    <div className="mb-2 float-md-right ml-md-auto">
                                        <i className="fa fa-fw fa-calendar mr-1"></i>{car.added_on}
                                    </div>

                                    <div className="clearfix"></div>
                                </div>

                                <div>
                                    <h5 className="mt-1 mb-2">Overview</h5>
                                    <div className="form-row">
                                        <div className="col-md-6">
                                            <i className="fa fa-check-square-o fa-fw text-muted mr-1"></i>{car.category.name}
                                        </div>

                                        <div className="col-md-6">
                                            <i className="fa fa-check-square-o fa-fw text-muted mr-1"></i>{car.transmission}
                                        </div>

                                        <div className="col-md-6">
                                            <i className="fa fa-check-square-o fa-fw text-muted mr-1"></i>{car.fuel}
                                        </div>

                                        <div className="col-md-6">
                                            <i className="fa fa-check-square-o fa-fw text-muted mr-1"></i>{car.color}
                                        </div>

                                        <div className="col-md-6">
                                            <i className="fa fa-check-square-o fa-fw text-muted mr-1"></i>{car.year}
                                        </div>

                                        <div className="col-md-6">
                                            <i className="fa fa-check-square-o fa-fw text-muted mr-1"></i>{car.mileage}
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div className="col-md-3 p-3">
                                <div className="relative">
                                    <h5 className="car-price mb-1">{car.price}</h5>

                                    <div className="m_info">

                                        <div className="mb-1">
                                            <i className="fa fa-fw fa-bus mr-1"></i>{car.category.name}
                                        </div>

                                        <div className="mb-3">
                                            <span className="float-left location">
                                                <i className="fa fa-fw fa-map-marker mr-1"></i>{car.location.town}
                                            </span>

                                            <span className="float-right">
                                            {car.year}
                                            </span>

                                            <div className="clearfix"></div>
                                        </div>

                                    </div>

                                    <a href="http://localhost/projects/vo/cars/2015-brand-new-subaru-imprezza-1.html?campaign=leads&amp;medium=internal&amp;source=search" className="btn btn-success btn-block shadow-none">Show Details</a>
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
