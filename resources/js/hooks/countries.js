import { useEffect, useState } from 'react';
import { API_ENDPOINTS, getApiUrl } from '../api';

function useCountries(){

    const [countries, setCountries] = useState([]);

    useEffect(() => {
        useGetRequest(getApiUrl(API_ENDPOINTS.GET_COUNTRIES))
            .then((response) => response.json())
            .then((response) => {
                if(response.success){
                    setCountries(response.data)

                    console.log("APP: Countries fetched")
                }else{
                    console.log(response.message)
                }
            })
            .catch((error) => console.log(error))
    }, [])

    return countries
}

export { useCountries }
