import React, { useContext, useEffect, useState } from 'react';
import { API_ENDPOINTS, getApiUrl } from '../../api';
import { useCarDataOptions } from '../../hooks/car';

function MarketFilters({ showCategories=true, onSubmitted }) {
    const [filters, setFilters] = useState({
        keyword: "",
        year_from: "",
        year_to: "",
        price_from: "",
        price_to: "",
        car_make: "",
        car_model: "",
        categories: [],
        body_types: [],
        transmissions: [],
        fuel_types: [],
    })

    // Options we can use to filter
    const carOptions = useCarDataOptions()

    // Models for selected car make
    const [car_models, setCarModels] = useState([])
    const [modelsLoading, setModelsLoading] = useState(false)

    // We shall fetch car models when car make filter changes
    useEffect(fetchCarModels, [filters.car_make])


    function fetchCarModels(){
        setCarModels([])

        if(filters.car_make !== ""){
            setModelsLoading(true)

            useGetRequest(getApiUrl(API_ENDPOINTS.GET_CAR_MODELS) + "?make=" + filters.car_make)
                .then(response => {
                    setModelsLoading(false)

                    if(response.success){
                        // Models are at data
                        setCarModels(response.data)
                    }
                })
        }
    }


    // Event handlers
    function updateKeyword(event){ setFilters({...filters, keyword: event.target.value}) }

    function updateYearFrom(event){ setFilters({...filters, year_from: event.target.value}) }

    function updateYearTo(event){ setFilters({...filters, year_to: event.target.value}) }

    function updatePriceFrom(event){ setFilters({...filters, price_from: event.target.value}) }

    function updatePriceTo(event){ setFilters({...filters, price_to: event.target.value}) }

    function handleCarMakeChange(event){
        setFilters({ ...filters, car_make: event.target.value })
    }

    function handleCarModelChange(event){
        setFilters({ ...filters, car_model: event.target.value })
    }


    // Mutiple value filters
    function handleCategoryChange(event){
        var value = event.target.value

        if(event.target.checked){
            // Add to list
            if(filters.categories.indexOf(value) === -1){
                setFilters({
                    ...filters,
                    categories: [...filters.categories, value]
                })
            }
        }else{
            // remove from list
            setFilters({
                ...filters,
                categories: filters.categories.filter((s) => (s !== value))
            })
        }
    }

    function handleBodyTypeChange(event){
        var value = event.target.value

        if(event.target.checked){
            // Add to list
            if(filters.body_types.indexOf(value) === -1){
                setFilters({
                    ...filters,
                    body_types: [...filters.body_types, value]
                })
            }
        }else{
            // remove from list
            setFilters({
                ...filters,
                body_types: filters.body_types.filter((s) => (s !== value))
            })
        }
    }

    function handleTransmissionChange(event){
        var value = event.target.value

        if(event.target.checked){
            // Add to list
            if(filters.transmissions.indexOf(value) === -1){
                setFilters({
                    ...filters,
                    transmissions: [...filters.transmissions, value]
                })
            }
        }else{
            // remove from list
            setFilters({
                ...filters,
                transmissions: filters.transmissions.filter((s) => (s !== value))
            })
        }
    }

    function handleFuelTypeChange(event){
        var value = event.target.value

        if(event.target.checked){
            // Add to list
            if(filters.fuel_types.indexOf(value) === -1){
                setFilters({
                    ...filters,
                    fuel_types: [...filters.fuel_types, value]
                })
            }
        }else{
            // remove from list
            setFilters({
                ...filters,
                fuel_types: filters.fuel_types.filter((s) => (s !== value))
            })
        }
    }

    function submit(event){
        event.preventDefault();

        // Pass the filters to the callback
        onSubmitted({...filters});
    }


    // Map our filters from available options
    const car_make_filters = carOptions.car_makes.map((option) => (<option value={option.id} key={option.id}>{option.name}</option>))
    const car_model_filters = car_models.map((option) => (<option value={option.id} key={option.id}>{option.name}</option>))

    const category_filters = carOptions.categories.map((option) => (
        <div className="custom-control custom-checkbox mb-2" key={option.id}>
            {
                filters.categories.includes(option.id) ?
                <input className="custom-control-input" id={"category" + option.id} value={option.id} type="checkbox" key={option.id} onChange={handleCategoryChange} checked />
                :
                <input className="custom-control-input" id={"category" + option.id} value={option.id} type="checkbox" key={option.id} onChange={handleCategoryChange} />
            }
            <label htmlFor={"category" + option.id} className="custom-control-label">
                <span>{option.name}</span>
            </label>
        </div>
    ))

    const body_type_filters = carOptions.body_types.map((option) => (
        <div className="custom-control custom-checkbox mb-2" key={option.id}>
            {
                filters.body_types.includes(option.id) ?
                <input className="custom-control-input" id={"body_type" + option.id} value={option.id} type="checkbox" key={option.id} onChange={handleBodyTypeChange} checked />
                :
                <input className="custom-control-input" id={"body_type" + option.id} value={option.id} type="checkbox" key={option.id} onChange={handleBodyTypeChange} />
            }
            <label htmlFor={"body_type" + option.id} className="custom-control-label">
                <span>{option.name}</span>
            </label>
        </div>
    ))

    const transmission_filters = carOptions.transmissions.map((option) => (
        <div className="custom-control custom-checkbox mb-2" key={option}>
            {
                filters.transmissions.includes(option) ?
                <input className="custom-control-input" id={"transmission" + option} value={option} type="checkbox" onChange={handleTransmissionChange} checked />
                :
                <input className="custom-control-input" id={"transmission" + option} value={option} type="checkbox" onChange={handleTransmissionChange} />
            }
            <label htmlFor={"transmission" + option} className="custom-control-label">
                <span>{option}</span>
            </label>
        </div>
    ))

    const fuel_type_filters = carOptions.fuel_types.map((option) => (
        <div className="custom-control custom-checkbox mb-2" key={option}>
            {
                filters.fuel_types.includes(option) ?
                <input className="custom-control-input" id={"fuel" + option} value={option} type="checkbox" onChange={handleFuelTypeChange} checked />
                :
                <input className="custom-control-input" id={"fuel" + option} value={option} type="checkbox" onChange={handleFuelTypeChange} />
            }
            <label htmlFor={"fuel" + option} className="custom-control-label">
                <span>{option}</span>
            </label>
        </div>
    ))

    return (
        <form onSubmit={submit}>

            <article className="card-group-item">
                <header className="card-header border-bottom">
                    <a className="" href="#" data-toggle="collapse" data-target="#by_keyword">
                        <i className="icon-action fa fa-chevron-down"></i>
                        <h6 className="title">By Search keyword</h6>
                    </a>
                </header>

                <div className="filter-content collapse" id="by_keyword">
                    <div className="card-body">
                        <input className="form-control legacy" placeholder="Keyword..." type="text" value={filters.keyword} onChange={updateKeyword} />
                    </div>
                </div>
            </article>

            <article className="card-group-item">
                <header className="card-header">
                    <a href="#" data-toggle="collapse" data-target="#by_price">
                        <i className="icon-action fa fa-chevron-down"></i>
                        <h6 className="title">By Price</h6>
                    </a>
                </header>

                <div className="filter-content collapse " id="by_price">
                    <div className="card-body">

                        <div className="mb-3">
                            <label>From</label>
                            <div className="input-group">
                                <div className="input-group-prepend">
                                    <span className="input-group-text">
                                        <strong>Ksh</strong>
                                    </span>
                                </div>
                                <input className="form-control" type="number" min="0" value={filters.price_from} onChange={updatePriceFrom} />
                            </div>
                        </div>

                        <div>
                            <label>To</label>
                            <div className="input-group">
                                <div className="input-group-prepend">
                                    <span className="input-group-text">
                                        <strong>Ksh</strong>
                                    </span>
                                </div>
                                <input className="form-control" type="number" min="0" value={filters.price_to} onChange={updatePriceTo} />
                            </div>
                        </div>

                    </div>

                </div>
            </article>

            <article className="card-group-item">
                <header className="card-header">
                    <a href="#" data-toggle="collapse" data-target="#by_condition">
                        <i className="icon-action fa fa-chevron-down"></i>
                        <h6 className="title">By Condition</h6>
                    </a>
                </header>

                <div className="filter-content collapse" id="by_condition">
                    <div className="card-body">
                        {category_filters}
                    </div>
                </div>
            </article>

            <article className="card-group-item">
                <header className="card-header">
                    <a href="#" data-toggle="collapse" data-target="#by_body_type">
                        <i className="icon-action fa fa-chevron-down"></i>
                        <h6 className="title">By Body Type</h6>
                    </a>
                </header>

                <div className="filter-content collapse" id="by_body_type">
                    <div className="card-body">
                        {body_type_filters}
                    </div>
                </div>
            </article>

            <article className="card-group-item">
                <header className="card-header">
                    <a href="#" data-toggle="collapse" data-target="#by_model_make">
                        <i className="icon-action fa fa-chevron-down"></i>
                        <h6 className="title">By Make &amp; Model</h6>
                    </a>
                </header>

                <div className="filter-content collapse" id="by_model_make">
                    <div className="card-body">
                        <div className="input-group mb-3">
                            <select className="form-control" value={filters.car_make} onChange={handleCarMakeChange}>
                                <option value="">All Makes</option>
                                {car_make_filters}
                            </select>
                        </div>

                        <div className="input-group">
                            <select className="form-control" value={filters.car_model} onChange={handleCarModelChange}>
                                <option value="">{modelsLoading ? "Loading..." : "All models"}</option>
                                {car_model_filters}
                            </select>
                        </div>
                    </div>
                </div>
            </article>

            <article className="card-group-item">
                <header className="card-header">
                    <a href="#" data-toggle="collapse" data-target="#by_year">
                        <i className="icon-action fa fa-chevron-down"></i>
                        <h6 className="title">By Year</h6>
                    </a>
                </header>

                <div className="filter-content collapse " id="by_year">
                    <div className="card-body">

                        <div className="input-group mb-3">
                            <div className="input-group-prepend">
                                <span className="input-group-text">
                                    <strong>From:</strong>
                                </span>
                            </div>
                            <input className="form-control" type="number" min="1990" max={new Date().getFullYear()} value={filters.year_from} onChange={updateYearFrom} />
                        </div>

                        <div className="input-group">
                            <div className="input-group-prepend">
                                <span className="input-group-text">
                                    <strong>To:&nbsp;&nbsp;</strong>
                                </span>
                            </div>
                            <input className="form-control" type="number" min="1990" max={new Date().getFullYear()} value={filters.year_to} onChange={updateYearTo} />
                        </div>

                    </div>
                </div>
            </article>

            <article className="card-group-item">
                <header className="card-header">
                    <a href="#" data-toggle="collapse" data-target="#by_transmission">
                        <i className="icon-action fa fa-chevron-down"></i>
                        <h6 className="title">By Transmission</h6>
                    </a>
                </header>

                <div className="filter-content collapse" id="by_transmission">
                    <div className="card-body">
                        {transmission_filters}
                    </div>
                </div>
            </article>

            <article className="card-group-item">
                <header className="card-header">
                    <a href="#" data-toggle="collapse" data-target="#by_fuel">
                        <i className="icon-action fa fa-chevron-down"></i>
                        <h6 className="title">By Fuel Type</h6>
                    </a>
                </header>

                <div className="filter-content collapse" id="by_fuel">
                    <div className="card-body pb-1">
                        {fuel_type_filters}
                    </div>
                </div>
            </article>

            <div className="card-group-item border-0">
                <div className="card-body border-0 p-0">
                    <button className="btn btn-link text-warning border-0 rounded-0 shadow-none btn-block py-3">
                        <i className="fa fa-refresh mr-1"></i>Refresh
                    </button>
                </div>
            </div>

        </form>
    );
}

export default MarketFilters;
