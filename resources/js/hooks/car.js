import { useEffect, useState } from "react";
import { API_ENDPOINTS, getApiUrl } from "../api";

/**
 * Fetches car data options such as makes, categories, body types etc
 */
const useCarDataOptions = () => {
    const [data, setCarData] = useState({
        car_makes: [],
        categories: [],
        body_types: [],
        transmissions: [],
        fuel_types: [],
    })

    useEffect(() => {
        useGetRequest(getApiUrl(API_ENDPOINTS.GET_CAR_DATA_OPTIONS))
            .then((response) => {
                if(response.success){
                    setCarData(response.data)
                }else{
                    console.log("ERROR: ", response.message)
                }
            })
            .catch((error) => {
                console.log(error)
            })

    }, [])

    return data
}

/**
 * Add car filters to url
 */
const useApplyCarFilters = (url, filters) => {
    var params = []

    // Check if filters are provided
    // Car filters
    if(filters.body_types){
        filters.body_types.forEach((val) => {
            params.push("body_type[]=" + val)
        })
    }

    if(filters.categories){
        filters.categories.forEach((val) => {
            params.push("category[]=" + val)
        })
    }

    if(filters.transmissions){
        filters.transmissions.forEach((val) => {
            params.push("transmission[]=" + val)
        })
    }

    if(filters.fuel_types){
        filters.fuel_types.forEach((val) => {
            params.push("fuel_type[]=" + val)
        })
    }

    if(filters.car_make !== "") params.push("make=" + filters.car_make)
    if(filters.car_model !== "") params.push("model=" + filters.car_model)
    if(filters.sort !== "") params.push("sort=" + filters.sort)

    // If no filters at all, just return the url
    if(params.length === 0) return url

    // Create a query string
    var query = "?" + params.join("&")

    return url + query
}

export { useCarDataOptions, useApplyCarFilters }
