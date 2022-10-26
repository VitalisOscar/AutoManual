import React, { useContext } from 'react';
import { NavLink } from 'react-router-dom';
import { UserContext } from '../../context/user';
import { APP_ROUTES } from "../../routes";

function UserNav(){

    const {currentUser, setCurrentUser, refreshingUser} = useContext(UserContext)

    function signout(){
        // TODO handle sign out
    }

    return (
            refreshingUser ?
            <>
                <div className="py-5 d-flex align-items-center justify-content-center">
                    <div className="text-center">
                        <div className="spinner-border text-primary mb-4"></div>
                        <div>Just a moment...</div>
                    </div>
                </div>
            </>
            :
            <>
                <div className="mb-3 px-2">
                    <div className="d-flex align-items-center mb-3">
                        <div className="media-left">
                            <img src="/img/avatar.png" className="avatar rounded-circle" />
                        </div>

                        <div className="ml-3 text-truncate">
                            <h5 className="mb-0"><strong>{currentUser.first_name + ' ' + currentUser.last_name}</strong></h5>
                            <h6 className="text-truncate" data-toggle="tooltip" title={currentUser.email}>{currentUser.email}</h6>
                        </div>
                    </div>

                    <button onClick={signout} className="btn btn-block shadow-none btn-outline-danger py-1">
                        <i className="fa fa-power-off mr-1"></i>Sign Out
                    </button>
                </div>

                <div className="user-nav">

                <NavLink to={APP_ROUTES.FAVORITES}>
                    <i className="bg-warning fa fa-star"></i>
                    <span>Favorites</span>
                    <i className="fa fa-angle-right"></i>
                </NavLink>

                <NavLink to={APP_ROUTES.ACCOUNT}>
                    <i className="bg-indigo fa fa-user"></i>
                    <span>Your Account</span>
                    <i className="fa fa-angle-right"></i>
                </NavLink>

                <NavLink to={APP_ROUTES.SUBSCRIPTIONS}>
                    <i className="bg-success fa fa-book"></i>
                    <span>Subscriptions</span>
                    <i className="fa fa-angle-right"></i>
                </NavLink>

                <NavLink to={APP_ROUTES.ALERTS}>
                    <i className="bg-danger fa fa-bell"></i>
                    <span>Alerts</span>
                    <i className="fa fa-angle-right"></i>
                </NavLink>

                <NavLink to={APP_ROUTES.CREATE_AD}>
                    <i className="bg-primary fa fa-plus"></i>
                    <span>Sell your Car</span>
                    <i className="fa fa-angle-right"></i>
                </NavLink>

                <NavLink to={APP_ROUTES.VIEW_ADS}>
                    <i className="bg-indigo fa fa-car"></i>
                    <span>Your Ads</span>
                    <i className="fa fa-angle-right"></i>
                </NavLink>
            </div>
        </>
    )
}

export default UserNav
