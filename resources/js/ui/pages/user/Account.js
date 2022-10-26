import React, { useContext } from 'react';
import { UserContext } from '../../../context/user';
import UserNav from '../../components/UserNav';

function Account() {
    // COMPONENT DATA
    const {user, setCurrentUser} = useContext(UserContext)


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
                            <h3 className="heading-title mx-3 mx-sm-0">Your Account</h3>
                        </div>
                        {/* END TOP PART */}


                        {/* CONTENT PART */}



                        {/* END CONTENT PART */}

                    </div>
                    {/* END MAIN SECTION */}

                </div>
            </div>

        </>
    );
}

export default Account;
