import React, { useEffect, useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { API_ENDPOINTS, getApiUrl } from '../../../api';
import { useApplyCarFilters } from '../../../hooks/car';
import { useGetRequest } from '../../../hooks/request';
import { APP_ROUTES } from '../../../routes';
import Listing from '../../components/Listing';
import MarketFilters from '../../components/MarketFilters';

function MarketPlace() {

    // COMPONENT DATA
    const [results, setResults] = useState({}) // Our results from API

    const [loading, setLoading] = useState(false) // Whether results are being fetched at the moment

    const [filtersShown, setFiltersShown] = useState(false) // Controls display of filters on small screens

    // TODO get default filter values from url
    const [filters, setFilters] = useState({
        keyword: "",
        year_from: "",
        year_to: "",
        price_from: "",
        price_to: "",
        car_make: "",
        car_model: "",
        category: "",
        body_type: "",
        page: 1,
        nextPage: 1,
        sort: "",

    }) // Filters in use for latest request


    // We'll fetch results when filters are updated
    useEffect(fetchResults, [filters])


    // Page header may be different
    // e.g depending on filters
    var page_header = "Cars for sale"



    /**
     * Updates by getting the latest results when page is loaded or filters change
     */
    function fetchResults(){
        // Notify that loading is ongoing
        setLoading(true)

        // The url for fetching results
        // With filters applied as a query string
        var url = useApplyCarFilters(
            getApiUrl(API_ENDPOINTS.GET_MARKETPLACE_CARS),
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


    function receiveFilters(latestFilters){
        // TODO Check if filters changed and update url query

        setFilters(latestFilters) // Update our filters
        setFiltersShown(false) // Hide if displayed on small screen
    }


    // MAPPINGS
    // Map each car item to a Listing component
    const listingList = results.items ? results.items.map((car) => {
        return <Listing car={car} key={car.id} />
    }) : ''


    const filtersComponent = <MarketFilters onSubmitted={receiveFilters} />

    return (
        <>
            {/* SMALL SCREEN FILTERS */}
            <div className={"filters-aside filters d-lg-none" + (filtersShown ? " shown":"")} onClick={(e) => { if(e.target.classList.contains('filters')){ setFiltersShown(false) }}}>
                <div>

                    <div className="bg-default p-3 text-white d-flex align-items-center filters-header">
                        <h5 className="my-0 text-white float-left">
                            <i className="fa fa-fw fa-filter"></i>
                            <span className="font-weight-500">Refine Results</span>
                        </h5>

                        <span className="close float-right ml-auto" onClick={() => setFiltersShown(false)}>
                            <i className="fa fa-times text-white"></i>
                        </span>
                        <div className="clearfix"></div>
                    </div>

                    {filtersComponent}

                </div>
            </div>


            {/* MAIN CONTAINER */}
            <div className="container py-5">

                <div className="row">
                    {/* FILTERS SECTION */}
                    <div className="col-lg-3 d-none d-lg-block">

                        <div className="sticky-top">
                            <div className="filters mb-4">

                                <div className="card shadow-none border-primary">

                                    <div className="card-header bg-purple text-white">
                                        <h5 className="my-0 text-white">
                                            <i className="fa fa-fw fa-filter"></i>
                                            <span className="font-weight-500">Refine Results</span>
                                        </h5>
                                    </div>

                                    {filtersComponent}

                                </div>

                            </div>
                        </div>

                    </div>
                    {/* END FILTERS SECTION */}


                    {/* LISTINGS SECTION */}
                    <div className="col-md-12 col-lg-9 results">

                        {/* TOP PART - HEADER AND SORTING */}
                        <div className="mb-4 section-top">

                            <div className="d-md-flex align-items-center">
                                <div className="float-md-left mr-md-auto mb-3 mb-md-0">
                                    <h1 className="h2 font-weight-bold mb-0">
                                        {page_header}
                                    </h1>
                                </div>

                                <div className="float-md-right ml-md-auto d-flex align-items-center">
                                    <button className="btn btn-outline-warning btn-sm px-3 shadow-none create-alert-btn" data-toggle="modal" data-target="#new-alert">
                                        <i className="fa fa-bell mr-1"></i>Create Alert
                                    </button>

                                    <button onClick={() => setFiltersShown(true)} className="btn btn-primary btn-sm py-2 px-3 shadow-none d-lg-none open-filters">
                                        <i className="fa fa-filter mr-1"></i>Filters
                                    </button>

                                    <div className="d-flex align-items-center float-right ml-auto">
                                        <select value={filters.sort} className="form-control custom-select-sm custom-select order-by" onChange={handleSortChange}>
                                            <option value="">Most Recent</option>
                                            <option value="oldest">Oldest First</option>
                                            <option value="atoz">Title (A to Z)</option>
                                            <option value="ztoa">Title (Z to A)</option>
                                        </select>
                                    </div>
                                </div>

                                <div className="clearfix"></div>
                            </div>

                            <button className="create-alert btn btn-warning" title="Create Alert">
                                <i className="fa fa-bell"></i>
                            </button>
                        </div>
                        {/* END RESULTS TOP PART */}


                        {/* LISTINGS PART */}

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
                                                    <h1 className="text-center mb-4 text13">No Results</h1>

                                                    <div className="text-left">
                                                        <div>
                                                            Unfortunately, your search returned zero listings. Here are things you can try:
                                                        </div>

                                                        <ul>
                                                            <li className="mb-1">Change your filters</li>
                                                            <li className="mb-1">
                                                                <div>Create an alert (We'll notify you when a matching car is listed)</div>
                                                                <Link to={APP_ROUTES.ALERTS} className="btn btn-outline-warning btn-sm">Create an Alert</Link>
                                                            </li>
                                                            <li className="mb-1">Check back later</li>
                                                        </ul>
                                                    </div>


                                                </div>
                                            </div>

                                        </div>
                                        :
                                        <div className="row">
                                            {listingList}
                                        </div>
                                )
                        }

                        {/* END LISTINGS PART */}

                    </div>
                    {/* END LISTINGS SECTION */}

                </div>
            </div>

        </>
    );
}

export default MarketPlace;
