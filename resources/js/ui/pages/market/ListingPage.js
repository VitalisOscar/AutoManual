import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import { API_ENDPOINTS, getApiUrl } from '../../../api';

function ListingPage() {
    // Component Data
    const [car, setCar] = useState({})
    const [loading, setLoading] = useState(false)


    const params = useParams()

    // Fetch the listing
    useEffect(() => {
        fetch(getApiUrl(API_ENDPOINTS.GET_SINGLE_MARKETPLACE_CAR, {
            slug: params.slug
        }))
        .then(response => response.json())
        .then(response => {
            setLoading(false)

            if(response.success){
                setCar(response.data)
            }else{
                console.log(response.message)
            }
        })
        .catch(error => console.log(error))
    }, [])



    const images = car.images ? car.images.map(image => (<img src={image.url} />)) : ''

    return (
        <div>
            <h3>{car.title}</h3>
            {images}
        </div>
    );
}

export default ListingPage;
