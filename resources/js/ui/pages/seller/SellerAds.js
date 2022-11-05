import React, { useContext, useEffect, useState } from 'react';
import { Link, NavLink, useParams } from 'react-router-dom';
import { API_ENDPOINTS, getApiUrl } from '../../../api';
import { UserContext } from '../../../context/user';
import { useApplyCarFilters } from '../../../hooks/car';
import { useGetRequest } from '../../../hooks/request';
import { APP_ROUTES, getAppRoute } from '../../../routes';
import SellerListing from '../../components/SellerListing';
import UserNav from '../../components/UserNav';

function SellerAds() {
    // COMPONENT DATA
    const {user, setCurrentUser} = useContext(UserContext)

    const [results, setResults] = useState({}) // Our results from API

    const [loading, setLoading] = useState(false) // Whether results are being fetched at the moment

    // TODO get default filter values from url
    const [filters, setFilters] = useState({
        page: 1,
        nextPage: 1,
        sort: "",
        status: "approved"
    }) // Filters in use for latest request

    // We'll fetch results when filters are updated or when status changes
    useEffect(fetchResults, [filters])


    /**
     * Updates by getting the latest results when page is loaded or filters change
     */
    function fetchResults(){
        // Notify that loading is ongoing
        setLoading(true)

        // The url for fetching results
        // With filters applied as a query string
        var url = useApplyCarFilters(
            getApiUrl(API_ENDPOINTS.GET_SELLER_CARS),
            filters
        )

        useGetRequest(url)
            .then((fetchedResults) => {
                // Update the results
                setLoading(false) // Done
                setResults(fetchedResults.data)
            })
            .catch((error) => {
                console.log(error)
            })
    }


    // DOM EVENT HANDLERS
    function handleSortChange(event){
        setFilters({ ...filters, sort: event.target.value })
    }


    return (
        <>

            {/* MAIN CONTAINER */}
            <div className="container py-5">

                <div className="row">

                    {/* USER NAV */}
                    <div className="col-md-3 user-nav-aside d-none d-md-block">
                        <UserNav />
                    </div>
                    {/* END USER NAV */}

                    {/* MAIN SECTION */}
                    <div className="col-md-9 pl-md-4 results">

                        {/* TOP PART - HEADER */}
                        <div className="d-flex align-items-center mb-3">
                            <h3 className="heading-title mx-3 mx-sm-0">Your Listings</h3>
                        </div>

                        {/* STATUS TABS AND SEARCH */}
                        <div className="ads-bar mb-3 d-sm-flex align-items-center">
                            <div className="categories float-sm-left mb-3 mb-sm-0">
                                <a onClick={() => setFilters({...filters, status: 'approved'})} title="Approved Ads" className={filters.status === 'approved' ? "category active" : "category"}>
                                    Approved
                                </a>

                                <a onClick={() => setFilters({...filters, status: 'pending'})} title="Pending Approval" className={filters.status === 'pending' ? "category active" : "category"}>
                                    Pending
                                </a>

                                <a onClick={() => setFilters({...filters, status: 'rejected'})} title="Rejected Ads" className={filters.status === 'rejected' ? "category active" : "category"}>
                                    Rejected
                                </a>

                            </div>

                            <div className="float-sm-right ml-sm-auto">
                                <form action="" method="get">
                                    <div className="input-group">

                                        <div className="input-group-append bg-primary rounded-right">
                                            <button className="btn btn-primary shadow-none">
                                                <i className="fa fa-search mr-1"></i>Search
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {/* END STATUS TABS AND SEARCH */}

                        {/* END TOP PART */}


                        {/* CONTENT PART */}

                        {
                            loading ?
                                // LOADER
                                <div className="py-5 d-flex align-items-center justify-content-center">
                                    <div className="text-center">
                                        <div className="spinner-border text-primary mb-4"></div>
                                        <div>Just a moment...</div>
                                    </div>
                                </div>
                                :
                                // LISTINGS LIST
                                (
                                    results.total === 0 ?
                                        // NO RESULTS
                                        <div className="row mb-4">
                                            <div className="col-12">
                                                <div className="lead text-center mx-auto">
                                                    <div className="d-inline-block p-3 text-center text-danger mx-auto">
                                                        <i className="fa fa-warning fa-5x"></i>
                                                    </div>
                                                    <br/>
                                                    <h1 className="text-center mb-4 text13">No Listings</h1>

                                                    <div className="text-left">
                                                        <div>
                                                            You do not have any {filters.status} ads at the moment. You can keep adding your listings
                                                        </div>

                                                        <ul>
                                                            <li className="mb-1">
                                                                Create a <Link to={APP_ROUTES.CREATE_AD}>new listing</Link> now
                                                            </li>
                                                        </ul>
                                                    </div>


                                                </div>
                                            </div>

                                        </div>
                                        :
                                        <div className="row">
                                            {
                                                results.items ? results.items.map((car) => {
                                                    return <SellerListing
                                                        car={car}
                                                        key={car.id}
                                                        />
                                                }) : ''
                                            }
                                        </div>
                                )
                        }

                        {/* END CONTENT PART */}

                    </div>
                    {/* END MAIN SECTION */}

                </div>
            </div>

        </>
    );
}

export default SellerAds;
