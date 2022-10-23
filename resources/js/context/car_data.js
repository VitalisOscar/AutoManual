import React, { useState } from 'react';
import { useCarDataOptions } from '../hooks/car';

const CarDataContext = React.createContext();

function CarDataProvider({ children }){
    const [data, setCarData] = useState({
        car_makes: [],
        categories: [],
        body_types: [],
        transmissions: [],
        fuel_types: [],
    })

    useCarDataOptions(setCarData)

    return <CarDataContext.Provider value={data}>{children}</CarDataContext.Provider>
}

export { CarDataContext, CarDataProvider }
