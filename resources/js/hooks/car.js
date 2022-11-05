import { useEffect, useState } from "react";
import { API_ENDPOINTS, getApiUrl } from "../api";
import { useGetRequest, usePostRequest } from "./request";

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

    if(filters.car_make && filters.car_make !== "") params.push("make=" + filters.car_make)
    if(filters.car_model && filters.car_model !== "") params.push("model=" + filters.car_model)
    if(filters.sort && filters.sort !== "") params.push("sort=" + filters.sort)
    if(filters.status && filters.status !== "") params.push("status=" + filters.status)

    // If no filters at all, just return the url
    if(params.length === 0) return url

    // Create a query string
    var query = "?" + params.join("&")

    return url + query
}

/**
 * Toggle a car listing favorite status
 */
function useToggleFavorite(car, setTogglingFavorite, setMarkedFavorite){

    setTogglingFavorite(true)

    // Send request
    usePostRequest(getApiUrl(API_ENDPOINTS.ADD_OR_REMOVE_FAVORITE, {slug: car.slug}), {})
        .then((response) => {
            setTogglingFavorite(false)

            if(response.success){
                // Status was toggled
                car.is_favorite = !car.is_favorite
                setMarkedFavorite(car.is_favorite)
            }else{
                // TODO handle error appropriately
                alert(response.message)
            }

        })
        .catch((error) => console.log(error))
}

/**
 * Fetch car models for a particular car make
 */
function useFetchCarModelsByMake(car_make_id, onFetched){
    if(car_make_id !== ""){
        useGetRequest(getApiUrl(API_ENDPOINTS.GET_CAR_MODELS) + "?make=" + car_make_id)
            .then(response => {
                if(response.success){
                    // Models are at data
                    onFetched(response.data)
                }
            })
            .catch((error) => console.log(error))
    }
}

export { useCarDataOptions, useApplyCarFilters, useToggleFavorite, useFetchCarModelsByMake }
