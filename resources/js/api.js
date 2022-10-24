// Definition of API routes
const API_ENDPOINTS = {
    GET_COUNTRIES: 'data/countries',

    GET_CAR_DATA_OPTIONS: 'data/car/options',
    GET_CAR_MODELS: 'data/car/models',

    GET_MARKETPLACE_CARS: 'marketplace',
    GET_MARKETPLACE_CARS_BY_CATEGORY: 'marketplace/:category',
    GET_SINGLE_MARKETPLACE_CAR: 'marketplace/:slug',
}

const BASE_API_URL = 'http://localhost:8000/api/'

/**
 * Get a full api path
 *
 * @param endpoint The api endpoint that will handle the request
 * @param params Url params if any
 */
const getApiUrl = (endpoint, params = null) => {
    var url = BASE_API_URL + endpoint

    if(params){
        for(const param in params){
            url = url.replace(`:${param}`, params[param])
        };
    }

    return url
}

export { API_ENDPOINTS, BASE_API_URL, getApiUrl }
