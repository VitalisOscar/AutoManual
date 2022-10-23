import React, { useContext, useEffect, useState } from 'react';
import { API_ENDPOINTS, getApiUrl } from '../../../api';
import { CarDataContext } from '../../../context/car_data';
import { useApplyCarFilters } from '../../../hooks/car';
import Listing from '../../components/Listing';

function MarketPlace() {

    // COMPONENT DATA
    const [results, setResults] = useState({}) // Our results from API

    const [loading, setLoading] = useState(false) // Whether results are being fetched at the moment

    const [filters, setFilters] = useState({
        car_make: "",
        car_model: "",
        category: "",
        body_type: "",
        page: 1,
        nextPage: 1,
        sort: "",

    }) // Filters in use for latest request

    // Options we can use to filter
    const carOptions = useContext(CarDataContext)

    // Models for selected car make
    const [car_models, setCarModels] = useState([])
    const [modelsLoading, setModelsLoading] = useState(false)


    // DESIRED EFFECTS
    // We'll fetch results when filters are updated
    useEffect(fetchResults, [filters])

    // We shall fetch car models when car make filter changes
    useEffect(fetchCarModels, [filters.car_make])



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

        fetch(url)
            .then((resp) => resp.json())
            .then((fetchedResults) => {
                // Update the results
                setLoading(false) // Done
                setResults(fetchedResults.data)
            })
            .catch((error) => {
                console.log(error)
            })
    }

    function fetchCarModels(){
        setCarModels([])

        if(filters.car_make !== ""){
            setModelsLoading(true)

            fetch(getApiUrl(API_ENDPOINTS.GET_CAR_MODELS) + "?make=" + filters.car_make)
                .then(response => response.json())
                .then(response => {
                    setModelsLoading(false)

                    if(response.success){
                        // Models are at data
                        setCarModels(response.data)
                    }
                })
        }
    }


    // DOM EVENT HANDLERS
    // Filter change handlers
    function handleCarMakeChange(event){
        setFilters({ ...filters, car_make: event.target.value })
    }

    function handleCarModelChange(event){
        setFilters({ ...filters, car_model: event.target.value })
    }

    function handleCategoryChange(event){
        setFilters({ ...filters, category: event.target.value })
    }

    function handleBodyTypeChange(event){
        setFilters({ ...filters, body_type: event.target.value })
    }

    function handleSortChange(event){
        setFilters({ ...filters, sort: event.target.value })
    }



    // MAPPINGS
    // Map each car item to a Listing component
    const listingList = results.items ? results.items.map((car) => {
        return <Listing car={car} key={car.id} />
    }) : 'No listings'


    // Map our filters
    const car_make_filters = carOptions.car_makes.map((option) => (<option value={option.id} key={option.id}>{option.name}</option>))
    const car_model_filters = car_models.map((option) => (<option value={option.id} key={option.id}>{option.name}</option>))
    const category_filters = carOptions.categories.map((option) => (<option value={option.id} key={option.id}>{option.name}</option>))
    const body_type_filters = carOptions.body_types.map((option) => (<option value={option.id} key={option.id}>{option.name}</option>))



    return (
        <div>
            <h3>Buy Cars</h3>

            <div>
                <h5>Filters</h5>

                <form>

                    <div>
                        Category:
                        <select value={filters.category} onChange={handleCategoryChange}>
                            <option value="">All</option>
                            {category_filters}
                        </select>
                    </div>

                    <div>
                        Body:
                        <select value={filters.body_type} onChange={handleBodyTypeChange}>
                            <option value="">All</option>
                            {body_type_filters}
                        </select>
                    </div>

                    <div>
                        Make:
                        <select value={filters.car_make} onChange={handleCarMakeChange}>
                            <option value="">All</option>
                            {car_make_filters}
                        </select>
                    </div>

                    <div>
                        Model:
                        <select value={filters.car_model} onChange={handleCarModelChange}>
                            <option value="">{modelsLoading ? "Loading..." : "All"}</option>
                            {car_model_filters}
                        </select>
                    </div>

                    <div>
                        Sort:
                        <select value={filters.sort} onChange={handleSortChange}>
                            <option value="">Most Recent</option>
                            <option value="oldest">Oldest</option>
                            <option value="atoz">Title (A to Z)</option>
                            <option value="ztoa">Title (Z to A)</option>
                        </select>
                    </div>

                </form>
            </div>

            {loading ? <span>Loading...</span> : <span>Results</span>}

            {listingList}

            <div>
                Page {results.page} of {results.max_pages}
            </div>
        </div>
    );
}

export default MarketPlace;
