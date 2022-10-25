import React, { useEffect, useState } from 'react';
import { API_ENDPOINTS, getApiUrl } from '../api';
import useGetRequest from '../hooks/request';

const UserContext = React.createContext();

function UserProvider({ children }){
    // Tracking the logged in user
    const [currentUser, setCurrentUser] = useState(null)

    // Whether the auth state is being validated
    const [refreshingUser, setRefreshingUser] = useState(true)

    // Refresh the current user info
    useEffect(() => {
        // TODO maintain and fetch from a storage provider
        const userApiToken = "3|GxINktRoOT9oHP6QxOFpmsGBvEr6HMAxWvWKmmfh"

        useGetRequest(getApiUrl(API_ENDPOINTS.REFRESH_USER))
            .then(response => {
                if(response.success){
                    // User is in data
                    setCurrentUser(response.data)
                    console.log("AUTH: User refreshed")
                }

                // Done refreshing
                setRefreshingUser(false)
            })
            .catch(error => {
                setRefreshingUser(false)
                console.error('AUTH ERROR', error)
            })

    }, [])

    return <UserContext.Provider value={{currentUser, setCurrentUser, refreshingUser}}>{children}</UserContext.Provider>
}

export { UserContext, UserProvider }
