import React, { useContext, useState } from 'react';
import { Link } from 'react-router-dom';
import { APP_ROUTES, getAppRoute } from '../../routes';
import { UserContext } from '../../context/user';
import { useCarDataOptions } from '../../hooks/car';

function Header() {
    const [menuOpen, setMenuOpen] = useState(false);

    const carData = useCarDataOptions()

    const {currentUser, setCurrentUser} = useContext(UserContext)


    function signout(){
        // TODO implement sign out
    }


    // Links to categories
    const categoryLinks = carData.categories.map(category => (
        <Link key={category.id} to={getAppRoute(APP_ROUTES.MARKET_CATEGORY, {category: category.slug})}>{category.name}</Link>
    ))

    // User related links
    const userLinks = currentUser ?
        <>
            <li className="dropdown-item">
                <Link to={APP_ROUTES.FAVORITES}>
                    <i className="bg-warning fa fa-star"></i>
                    <span>Favorites</span>
                </Link>
            </li>
            <li className="dropdown-item">
                <Link to={APP_ROUTES.ACCOUNT}>
                    <i className="bg-indigo fa fa-user"></i>
                    <span>Your Account</span>
                </Link>
            </li>
            <li className="dropdown-item">
                <Link to={APP_ROUTES.SUBSCRIPTIONS}>
                    <i className="bg-success fa fa-book"></i>
                    <span>Subscriptions</span>
                </Link>
            </li>
            <li className="dropdown-item">
                <Link to={APP_ROUTES.ALERTS}>
                    <i className="bg-danger fa fa-bell"></i>
                    <span>New Listing Alerts</span>
                </Link>
            </li>
            <li className="dropdown-item">
                <Link to={APP_ROUTES.CREATE_AD}>
                    <i className="bg-primary fa fa-plus"></i>
                    <span>Post an Ad</span>
                </Link>
            </li>
            <li className="dropdown-item">
                <Link to={APP_ROUTES.VIEW_ADS}>
                    <i className="bg-indigo fa fa-car"></i>
                    <span>Your Ads</span>
                </Link>
            </li>
            <li className="dropdown-item">
                <Link onClick={signout}>
                    <i className="bg-default fa fa-sign-out"></i>
                    <span>Sign Out</span>
                </Link>
            </li>
        </> :
        <>
            <li className="dropdown-item">
                <Link to={APP_ROUTES.LOG_IN}>
                    <i className="bg-warning fa fa-user"></i>
                    <span>Sign In</span>
                </Link>
            </li>

            <li className="dropdown-item">
                <Link to={APP_ROUTES.SIGN_UP}>
                    <i className="bg-indigo fa fa-user-plus"></i>
                    <span>Register</span>
                </Link>
            </li>
        </>

    return (
        <>
            <header>

                <div className="main-nav">
                    <div className="container px-0 px-sm-3">

                        <button data-toggle="tooltip" title="Menu" className="menu-btn" onClick={() => { setMenuOpen(true) }}>
                            <span>
                                <span className="menu-icon">
                                    <svg focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"></path>
                                    </svg>
                                </span>
                            </span>

                            <div className="overlay"></div>
                        </button>

                        <Link to={APP_ROUTES.HOME} className="navbar-brand">
                            <img src="/img/brand/white.png" alt="Logo" />
                        </Link>

                        <div className="float-right ml-auto links">

                            <Link to={APP_ROUTES.MARKET_MAIN}>All Cars</Link>

                            {categoryLinks}

                            <div className="dropdown">
                                <a className="btn btn-outline-white py-2 mr-1" data-toggle="dropdown">Account<i className="fa fa-caret-down ml-1"></i></a>

                                <ul className="dropdown-menu account-options">
                                    {userLinks}
                                </ul>
                            </div>

                            <Link to={APP_ROUTES.CREATE_AD} title="Post an Ad" className="btn bg-purple py-2">
                                <i className="fa fa-plus mr-1"></i>
                                Post Ad
                            </Link>

                        </div>

                        <div className="float-right ml-auto d-lg-none">

                            <div className="dropdown">
                                <div className="account-options-avatar" data-toggle="dropdown" title="Account Options">
                                    <img src="http://localhost/projects/vo/assets/img/user.png" />
                                </div>
                                <ul className="dropdown-menu account-options">
                                    {userLinks}
                                </ul>
                            </div>

                            <Link to={APP_ROUTES.CREATE_AD} title="Post an Ad" className="btn bg-purple py-2 mr-0 shadow-none post-ad">
                                <i className="fa fa-plus mr-1"></i>
                                Post Ad
                            </Link>
                        </div>
                    </div>
                </div>

            </header>

            <aside className={menuOpen ? "menu open":"menu"} onClick={() => { setMenuOpen(false) }}>
                <div className="menu-items">

                    <div className="logo">
                        <Link to={APP_ROUTES.HOME}>
                            <img src="/img/brand/blue.png" alt="Logo" />
                        </Link>

                        <span className="float-right ml-auto">
                            <i className="fa fa-times close-menu" data-toggle="tooltip" title="Close" onClick={() => { setMenuOpen(false) }}></i>
                        </span>
                    </div>

                    <div className="items">

                        <div className="group">
                            <Link to={APP_ROUTES.MARKET_MAIN}>
                                <i className="fa fa-bus bg-danger"></i>All Cars
                            </Link>

                            {categoryLinks}
                        </div>

                        <Link to={APP_ROUTES.CREATE_AD}>
                            <i className="fa fa-plus bg-indigo"></i>Post free Ad
                        </Link>

                        <a href="">
                            <i className="fa fa-edit bg-warning"></i>Our Blog
                        </a>

                        <a href="">
                            <i className="fa fa-download bg-info"></i>Download App
                        </a>

                    </div>

                </div>
            </aside>
        </>
    );
}

export default Header;
