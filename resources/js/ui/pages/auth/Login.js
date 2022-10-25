import React, { useContext, useRef, useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { API_ENDPOINTS, getApiUrl } from '../../../api';
import { UserContext } from '../../../context/user';
import { usePostRequest } from '../../../hooks/request';
import { APP_ROUTES, getAppRoute } from '../../../routes';

function Login() {
    const {currentUser, setCurrentUser} = useContext(UserContext)

    const [loading, setLoading] = useState(false) // Whether credentials are being sent at the moment

    const [passwordVisible, setPasswordVisible] = useState(false) // Make password visible

    const navigate = useNavigate()

    const [credentials, setCredentials] = useState({
        email: "",
        password: "",
        remember_me: true
    })

    /**
     * Sends the credentials to the backend for authentication
     */
    function authenticate(event){
        event.preventDefault()

        // Notify that loading is ongoing
        setLoading(true)

        usePostRequest(getApiUrl(API_ENDPOINTS.LOGIN), credentials)
            .then((response) => {
                setLoading(false) // Done

                if(response.success){
                    // Authenticated
                    // User is at data.user
                    setCurrentUser(response.data.user)

                    // Token is at data.token
                    // TODO save the token to storage

                    // Redirect
                    // TODO to where the user intended to go
                    navigate(APP_ROUTES.FAVORITES)
                }else{
                    // TODO handle the auth error
                    alert(response.message)
                }
            })
            .catch((error) => {
                setLoading(false)
                console.log(error)
            })
    }


    // DOM EVENT HANDLERS
    function updateEmail(event){
        setCredentials({ ...credentials, email: event.target.value })
    }

    function updatePassword(event){
        setCredentials({ ...credentials, password: event.target.value })
    }

    function updateRememberMe(event){
        setCredentials({ ...credentials, remember_me: !credentials.remember_me })
    }

    return (
    <section className="py-4 py-md-5">
        <div className="container">

            <div className="row">

                <div className="col main-content">

                    <form onSubmit={authenticate}>

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

                                <h4 className="mb-0">Log in to your account</h4>
                            </div>

                            <div className="p-4">

                                <div className="form-group mb-3">
                                    <div className="input-group">
                                        <div className="input-group-prepend">
                                            <span className="input-group-text">
                                                <i className="fa fa-fw fa-envelope"></i>
                                            </span>
                                        </div>
                                        <input className="form-control" name="email" placeholder="Email Address" type="email" value={credentials.email} onChange={updateEmail} required />
                                    </div>
                                </div>

                                <div className="form-group mb-4">
                                    <div className="input-group">
                                        <div className="input-group-prepend">
                                            <span className="input-group-text">
                                                <i className="fa fa-fw fa-lock"></i>
                                            </span>
                                        </div>
                                        <input className="form-control rounded-0" placeholder="Password" name="password" type={passwordVisible ? "text" : "password"} value={credentials.password} onChange={updatePassword} required />
                                        <div className="input-group-append pass-toggle" onClick={() => setPasswordVisible(!passwordVisible)}>
                                            <span className="input-group-text">
                                                <i className={passwordVisible ? "fa fa-fw fa-eye-slash":"fa fa-fw fa-eye"}></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div className="form-group mb-4">
                                    <div className="custom-control custom-checkbox">
                                        <input className="custom-control-input mb-0" id="remember" name="remember_me" checked={credentials.remember_me} type="checkbox" onChange={updateRememberMe} />
                                        <label htmlFor="remember" className="custom-control-label">
                                            <span>Remember Me</span>
                                        </label>
                                    </div>
                                </div>

                                <div className="mb-3">
                                    <button className="btn btn-default btn-block shadow-none">Submit</button>
                                </div>

                                <div className="text-center mb-4">
                                    <div className="mb-3">Use your social account:</div>

                                    <div>
                                        <Link to="" className="social-btn mr-3 btn btn-google bg-danger">
                                            <i className="fa fa-google text-white"></i>
                                        </Link>

                                        <Link to="" className="social-btn mr-3 btn btn-facebook">
                                            <i className="fa fa-facebook text-white"></i>
                                        </Link>

                                        <Link to="" className="social-btn btn btn-twitter">
                                            <i className="fa fa-twitter"></i>
                                        </Link>
                                    </div>
                                </div>

                                <div className="text-center mb-3">
                                    <span>Forgot Password? <Link to={getAppRoute(APP_ROUTES.FORGOT_PASSWORD)}>Reset Password</Link></span>
                                </div>

                                <div className="text-center">
                                    <span>Not Registered? <Link to={getAppRoute(APP_ROUTES.SIGN_UP)}>Create Account</Link></span>
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

export default Login;
