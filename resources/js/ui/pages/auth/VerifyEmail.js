import React, { useContext, useRef, useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { API_ENDPOINTS, getApiUrl } from '../../../api';
import { UserContext } from '../../../context/user';
import { APP_ROUTES, getAppRoute } from '../../../routes';

function VerifyEmail() {
    const {currentUser, setCurrentUser} = useContext(UserContext)

    const [loading, setLoading] = useState(false) // Whether communicating with backend at the moment
    const [code, setCode] = useState("") // The verification code

    const navigate = useNavigate()

    /**
     * Sends a request to backend for code to be resent
     */
    function requestCode(event){

    }

    /**
     * Verifies the provided code
     */
    function verifyCode(event){
        event.preventDefault()

        // Notify that loading is ongoing
        setLoading(true)
    }


    return (
    <section className="py-4 py-md-5">
        <div className="container">

            <div className="row">

                <div className="col main-content">

                    <form onSubmit={requestCode}>

                        <div className="auth-card border mx-auto with-loader">

                            {
                                loading ?
                                <div className="loader text-center">
                                    <div className="mx-auto bg-white p-3 ">

                                        <div className="spinner-border text-primary"></div>

                                    </div>
                                </div>
                                :
                                ''
                            }

                            <div className="px-4 pt-5 pb-3 top text-center">
                                <Link className="logo d-block mb-4" to={APP_ROUTES.HOME}>
                                    <img src="/img/brand/blue.png" />
                                </Link>

                                <h4 className="mb-0">Verify Email</h4>
                            </div>

                            <div className="p-4">

                                <div className="form-group mb-3">
                                    <div className="input-group">
                                        <div className="input-group-prepend">
                                            <span className="input-group-text">
                                                <i className="fa fa-fw fa-check-square-o"></i>
                                            </span>
                                        </div>
                                        <input className="form-control" placeholder="Verification Code" type="email" value={code} onChange={() => setCode(this.value)} required />
                                    </div>
                                </div>

                                <div className="mb-3">
                                    <button className="btn btn-default btn-block shadow-none">Verify</button>
                                </div>

                            </div>

                        </div>

                    </form>

                </div>

            </div>
        </div>
    </section>
    );
}

export default VerifyEmail;
