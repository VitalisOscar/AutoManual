import React from 'react';
import { useParams } from 'react-router-dom';

function SellerPage() {
    const params = useParams()

    return (
        <div>
            <h3>Seller {params.slug}</h3>
        </div>
    );
}

export default SellerPage;
