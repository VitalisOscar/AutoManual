import React, { useEffect, useState } from 'react';
import { API_ENDPOINTS, getApiUrl } from '../../../api';
import { useGetRequest } from '../../../hooks/request';
import ListingAlert from '../../components/ListingAlert';
import UserNav from '../../components/UserNav';

function Alerts() {
    // COMPONENT DATA
    const [results, setResults] = useState({})
    const [loading, setLoading] = useState(true)


    useEffect(fetchAlerts, [])


    function fetchAlerts(){
        // Notify that loading is ongoing
        setLoading(true)

        // The url for fetching results
        var url = getApiUrl(API_ENDPOINTS.GET_ALERTS)

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
                            <h3 className="heading-title mx-3 mx-sm-0">Listing Alerts</h3>

                            <button className="btn ml-sm-auto mr-0 btn-primary py-2 shadow-none ">New Alert</button>
                        </div>
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
                            (
                                results.total === 0 ?
                                    // USER HAS NO ALERTS
                                    <div className="cfa" id="cfa">

                                        <div className="mb-3">
                                            You do not have any active alert at the moment.
                                            Get to be the first to know when new cars you like are listed.
                                        </div>

                                        <ul>
                                            <li>
                                                Choose from multiple features of vehicles you like e.g car models, conditions etc.
                                            </li>

                                            <li>
                                                Once a matching listing is created, we'll deliver it straight to your email inbox.
                                            </li>
                                        </ul>

                                    </div>

                                    :

                                    <div className="row">
                                        {
                                            results.items.map((alert) => (
                                                <ListingAlert alert={alert} />
                                            ))
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

export default Alerts;
