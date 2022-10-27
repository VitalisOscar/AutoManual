import React, { useContext } from 'react';
import { UserContext } from '../../../context/user';
import UserNav from '../../components/UserNav';

function Account() {
    // COMPONENT DATA
    const {currentUser, setCurrentUser, refreshingUser} = useContext(UserContext)


    return (
        <>

            {/* MAIN CONTAINER */}
            <div className="container py-5">

                <div className="row">

                    {/* USER NAV */}
                    <div className="col-md-3 user-nav-aside d-none d-md-block">
                        <UserNav />
                    </div>
                    {/* END USER NAV */}

                    {/* MAIN SECTION */}
                    <div className="col-md-9 pl-md-4 results">

                        {/* TOP PART - HEADER */}
                        <div className="d-flex align-items-center mb-3">
                            <h3 className="heading-title mx-3 mx-sm-0">Account Settings</h3>
                        </div>
                        {/* END TOP PART */}


                        {/* CONTENT PART */}

                        {
                            refreshingUser ?
                                // LOADER
                                <div className="py-5 d-flex align-items-center justify-content-center">
                                    <div className="text-center">
                                        <div className="spinner-border text-primary mb-4"></div>
                                        <div>Just a moment...</div>
                                    </div>
                                </div>

                            :

                                <div class="row">
                                    <div class="col-md-6 col-lg-7">

                                        <div>
                                        
                                            {/* PERSONAL DETAILS */}
                                            <div class="mb-5">
                                                <form method="POST">
                                                    <h5 class="font-weight-600 mb-4">Basic Info</h5>

                                                    <div class="form-group">
                                                        <div class="form-row">
                                                            <div class="col-sm-3 col-md-12 col-lg-4 d-flex align-items-center">
                                                                <strong>Name:</strong>
                                                            </div>

                                                            <div class="col-sm-9 col-md-12 col-lg-8">
                                                                {currentUser.first_name + ' ' + currentUser.last_name}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="form-row">
                                                            <div class="col-sm-3 col-md-12 col-lg-4 d-flex align-items-center">
                                                                <strong>Email:</strong>
                                                            </div>

                                                            <div class="col-sm-9 col-md-12 col-lg-8">
                                                                {currentUser.email}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="form-row">
                                                            <div class="col-sm-3 col-md-12 col-lg-4 d-flex align-items-center">
                                                                <strong>Phone No:</strong>
                                                            </div>

                                                            <div class="col-sm-9 col-md-12 col-lg-8">
                                                                {currentUser.phone}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    
                                                </form>
                                            </div>
                                            {/* END PERSONAL DETAILS */}


                                            {/* VERIFICATION */}
                                            <div class="mb-5">

                                                <h5 class="font-weight-600">Account Verification</h5>

                                                <p>
                                                    Complete account verification to do more such as post your cars
                                                    as a seller, create alerts for new listings etc
                                                </p>

                                                <div>

                                                    <div>
                                                        <h6 class="mb-1"><strong>Phone Number</strong></h6>
                                                        {
                                                            currentUser.phone_verified ?
                                                            <p class="mb-0">
                                                                Verified {currentUser.phone_verified_on}
                                                            </p>
                                                            :
                                                            <button class="ml-auto float-right btn btn-link p-0">Verify Now</button>
                                                        }
                                                    </div>

                                                    <hr class="my-2" />

                                                    <div>
                                                        <h6 class="mb-1"><strong>Email</strong></h6>
                                                        {
                                                            currentUser.email_verified ?
                                                            <p class="mb-0">
                                                                Verified {currentUser.email_verified_on}
                                                            </p>
                                                            :
                                                            <button class="ml-auto float-right btn btn-link p-0">Verify Now</button>
                                                        }
                                                    </div>

                                                    <hr class="my-2" />
                                                </div>
                                            </div>
                                            {/* END VERIFICATION */}


                                            {/* LOGIN */}
                                            <div class="mb-4">

                                                <h5 class="font-weight-600">Login Settings</h5>

                                                <p>
                                                    Manage your log in methods
                                                </p>

                                                <div>

                                                    <div>
                                                        <h6 class="mb-1 font-weight-600">Email Login</h6>
                                                        <p>
                                                            This is your primary log in method and always enabled
                                                        </p>

                                                        <div>
                                                            <button class="btn btn-link py-2 px-2"><i class="fa fa-lock mr-2"></i>Update Password</button>
                                                        </div>
                                                    </div>

                                                    <hr class="my-2" />

                                                    <div>
                                                        <h6 class="mb-1 font-weight-600">Social Accounts</h6>
                                                        <p>
                                                            You can conneect your social accounts and log in quickly
                                                        </p>

                                                        <div>

                                                            <div class="d-flex align-items-center p-3 rounded bg-white border">
                                                                <span class="icon icon-shape text-white btn-facebook d-inline-flex align-items-center justify-content-center">
                                                                    <i class="fa fa-facebook"></i>
                                                                </span>

                                                                <div class="ml-3">
                                                                    <h5 class="mb-1">Facebook Account</h5>
                                                                    <div>
                                                                        <span class="text-success font-weight-600">Connected</span>
                                                                    </div>
                                                                </div>

                                                                <div class="ml-auto">
                                                                    <button class="btn btn-link py-2 px-1">Remove</button>
                                                                </div>
                                                            </div>

                                                            <div class="d-flex align-items-center p-3 rounded bg-white border">
                                                                <span class="icon icon-shape text-white btn-twitter d-inline-flex align-items-center justify-content-center">
                                                                    <i class="fa fa-twitter"></i>
                                                                </span>

                                                                <div class="ml-3">
                                                                    <h5 class="mb-1">Twitter Account</h5>
                                                                    <div>
                                                                        <span>Not Connected</span>
                                                                    </div>
                                                                </div>

                                                                <div class="ml-auto">
                                                                    <button class="btn btn-link py-2 px-1">
                                                                        <i class="fa fa-plus mr-2"></i>Connect
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            <div class="d-flex align-items-center p-3 rounded bg-white border">
                                                                <span class="icon icon-shape text-white bg-danger d-inline-flex align-items-center justify-content-center">
                                                                    <i class="fa fa-google"></i>
                                                                </span>

                                                                <div class="ml-3">
                                                                    <h5 class="mb-1">Google Account</h5>
                                                                    <div>
                                                                        <span class="text-success font-weight-600">Connected</span>
                                                                    </div>
                                                                </div>

                                                                <div class="ml-auto">
                                                                    <button class="btn btn-link py-2 px-1">
                                                                        <i class="fa fa-minus mr-2"></i>Remove
                                                                    </button>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {/* END LOGIN */}

                                        </div>

                                    </div>

                                    <div class="col-md-6 col-lg-5 pl-lg-5">

                                    </div>
                                </div>

                        }


                        {/* END CONTENT PART */}

                    </div>
                    {/* END MAIN SECTION */}

                </div>
            </div>

        </>
    );
}

export default Account;
