import React from 'react';
import { useParams } from 'react-router-dom';

function ListingPage() {
    const params = useParams()

    return (
        <div>
            <h3>Listing {params.slug}</h3>
        </div>
    );
}

export default ListingPage;
