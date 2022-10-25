import { useContext } from 'react'
import { Navigate, Outlet } from 'react-router-dom'
import { UserContext } from '../context/user'
import { APP_ROUTES } from '../routes'

const ProtectedRoutes = () => {
    const {currentUser, setCurrentUser} = useContext(UserContext)

    return (
        currentUser ? <Outlet/> : <Navigate to={APP_ROUTES.LOG_IN} />
    )
}

export default ProtectedRoutes
