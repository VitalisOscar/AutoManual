import React from 'react';

export default function ListingAlert({ alert }){
    return (
        <div className="alert-wrap" id="_$2y$10$KweNd4XG/QLdY2Pi.8PSeuJdA6XB1RZb43gASF9hcf4fJlTHgwGkm" data-alert="1" data-key="1" data-extra="1654867393">
            <div className="row p-0">
                <div className="col-sm-9 col-md-10">
                    <div className="alert-title text-truncate">
                        <strong>Email Alert</strong>
                        <span data-toggle="tooltip" title="vitalisoscar6@gmail.com"> - vitalisoscar6@gmail.com</span>
                    </div>

                    <div className="text-muted mb-2">
                        1990 to 2020 • KSh0 to KSh4,390,244 • Brand New • SUV • Automatic • Petrol
                    </div>

                    <div className="mb-3">
                        <i className="fa fa-tags text-muted mr-1"></i>No Keyword
                    </div>

                    <div className="meta d-flex align-items-center">
                        <span className="float-left date"><i className="fa fa-calendar bg-primary mr-1"></i>Jun 10, 2022</span>
                        <span onclick="deleteAlert('$2y$10$KweNd4XG/QLdY2Pi.8PSeuJdA6XB1RZb43gASF9hcf4fJlTHgwGkm')" className="delete-btn d-sm-none mr-0" data-toggle="tooltip" title="Delete">
                            <i className="fa fa-trash"></i>
                            <div className="overlay"></div>
                        </span>
                        <div className="clearfix"></div>
                    </div>

                </div>

                <div className="col-sm-3 col-md-2 border-left d-none d-sm-block">
                    <div className="h-100 d-flex align-items-center w-100 text-center">
                        <button onclick="deleteAlert('$2y$10$KweNd4XG/QLdY2Pi.8PSeuJdA6XB1RZb43gASF9hcf4fJlTHgwGkm')" className="btn btn-outline-danger shadow-none btn-sm btn-block py-2">
                            <i className="fa fa-trash mr-1"></i>Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    )
}
