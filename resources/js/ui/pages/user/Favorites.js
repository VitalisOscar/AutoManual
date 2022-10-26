import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import { API_ENDPOINTS, getApiUrl } from '../../../api';
import { useApplyCarFilters } from '../../../hooks/car';
import { useGetRequest } from '../../../hooks/request';
import { APP_ROUTES } from '../../../routes';
import Listing from '../../components/Listing';

function Favorites() {
    // COMPONENT DATA
    const [results, setResults] = useState({}) // Our results from API

    const [loading, setLoading] = useState(false) // Whether results are being fetched at the moment


    // We'll fetch results when filters are updated
    useEffect(fetchFavorites, [])


    /**
     * Updates by getting the latest results when page is loaded or filters change
     */
    function fetchFavorites(){
        // Notify that loading is ongoing
        setLoading(true)

        // The url for fetching results
        // With filters applied as a query string
        var url = getApiUrl(API_ENDPOINTS.GET_FAVORITE_CARS)

        useGetRequest(url)
            .then((fetchedResults) => {
                // Update the results
                setResults(fetchedResults.data)
                setLoading(false) // Done
            })
            .catch((error) => {
                setLoading(false) // Done
                console.log(error)
            })
    }



    // MAPPINGS
    // Map each car item to a Listing component
    const listingList = results.items ? results.items.map((car) => {
        return <Listing
            car={car}
            key={car.id}
            showSeller={false} // Minimized detail - no seller
            gridDisplay={true} // Display as grid
            />
    }) : ''

    return (
        <>

            {/* MAIN CONTAINER */}
            <div className="container py-5">

                <div className="row">

                    {/* LISTINGS SECTION */}
                    <div className="col-12 results">

                        {/* TOP PART - HEADER AND SORTING */}
                        <div className="mb-4 section-top">

                            <div className="d-md-flex align-items-center">
                                <div className="float-md-left mr-md-auto mb-3 mb-md-0">
                                    <h1 className="h2 font-weight-bold mb-0">
                                        Favorites
                                    </h1>
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
                                                    <h1 className="text-center mb-4 text13">No Favorites</h1>

                                                    <div className="text-left">
                                                        <div>
                                                            You do not have any favorites at the moment. To add a car as a favorite listing, click on it's <i className="fa fa-heart-o text-warning"></i> icon
                                                        </div>

                                                        <ul>
                                                            <li className="mb-1">Change your filters</li>
                                                            <li className="mb-1">
                                                                Browse some <Link to={APP_ROUTES.MARKET_MAIN}>car listings</Link> and try out
                                                            </li>
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

export default Favorites;
