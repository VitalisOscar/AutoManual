// Definition of API routes
const API_ENDPOINTS = {
    GET_CAR_DATA_OPTIONS: 'data/car/options',
    GET_CAR_MODELS: 'data/car/models',
    GET_MARKETPLACE_CARS: 'marketplace'
}

const BASE_API_URL = 'http://localhost:8000/api/'

/**
 * Get a full api path
 *
 * @param endpoint The api endpoint that will handle the request
 * @param params Url params if any
 */
const getApiUrl = (endpoint, params = null) => {
    return BASE_API_URL + endpoint
}

export { API_ENDPOINTS, BASE_API_URL, getApiUrl }
