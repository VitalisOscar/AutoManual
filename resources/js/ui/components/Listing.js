import React from 'react';

function Listing({ car }) {
    return (
        <div className="container">
            <img src={car.main_image.url} />
            <h4>{car.title}</h4>
        </div>
    );
}

export default Listing;
