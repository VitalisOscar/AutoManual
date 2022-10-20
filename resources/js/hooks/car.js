import { useEffect, useState } from "react";
import { API_ENDPOINTS, getApiUrl } from "../api";

/**
 * Fetches car data options such as makes, categories, body types etc
 */
const useCarDataOptions = (onLoaded) => {
    useEffect(() => {
        fetch(getApiUrl(API_ENDPOINTS.GET_CAR_DATA_OPTIONS))
            .then(response => response.json())
            .then((response) => {
                if(response.success){
                    onLoaded(response.data)
                }else{
                    console.log("ERROR: ", response.message)
                }
            })
            .catch((error) => {
                console.log(error)
            })

    }, [onLoaded])
}

/**
 * Add car filters to url
 */
const useApplyCarFilters = (url, filters) => {
    var params = []

    // Check if filters are provided
    // Car filters
    if(filters.body_type !== "") params.push("body_type=" + filters.body_type)
    if(filters.category !== "") params.push("category=" + filters.category)
    if(filters.car_make !== "") params.push("make=" + filters.car_make)
    if(filters.car_model !== "") params.push("model=" + filters.car_model)

    // If no filters at all, just return the url
    if(params.length === 0) return url

    // Create a query string
    var query = "?" + params.join("&")

    return url + query
}

export { useCarDataOptions, useApplyCarFilters }
