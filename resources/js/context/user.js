import React, { useState } from 'react';

const UserContext = React.createContext();

function UserProvider({ children }){
    // Tracking the logged in user
    const [currentUser, setCurrentUser] = useState({})

    // Fetch the current user info
    // TODO

    return <UserContext.Provider value={{currentUser, setCurrentUser}}>{children}</UserContext.Provider>
}

export { UserContext, UserProvider }
