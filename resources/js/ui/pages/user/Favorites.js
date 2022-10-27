import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import { API_ENDPOINTS, getApiUrl } from '../../../api';
import { useGetRequest } from '../../../hooks/request';
import { APP_ROUTES } from '../../../routes';
import Listing from '../../components/Listing';
import UserNav from '../../components/UserNav';

function Favorites() {
    // COMPONENT DATA
    const [results, setResults] = useState({}) // Our results from API

    const [loading, setLoading] = useState(false) // Whether results are being fetched at the moment


    useEffect(fetchFavorites, [])


    function fetchFavorites(){
        // Notify that loading is ongoing
        setLoading(true)

        // The url for fetching results
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
            showSeller={true}
            gridDisplay={true} // Display as grid
            />
    }) : ''

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

                    {/* LISTINGS SECTION */}
                    <div className="col-md-9 pl-md-4 results">

                        {/* TOP PART - HEADER */}
                        <div className="d-flex align-items-center mb-3">
                            <h3 className="heading-title mx-3 mx-sm-0">Favorite Cars</h3>
                        </div>
                        {/* END TOP PART */}


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
