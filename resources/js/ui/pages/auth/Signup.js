import React, { useContext, useRef, useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { API_ENDPOINTS, getApiUrl } from '../../../api';
import { UserContext } from '../../../context/user';
import { useCountries } from '../../../hooks/countries';
import { APP_ROUTES, getAppRoute } from '../../../routes';

function Signup() {
    const {currentUser, setCurrentUser} = useContext(UserContext)

    const countries = useCountries()

    const [loading, setLoading] = useState(false) // Whether credentials are being sent at the moment

    const [passwordVisible, setPasswordVisible] = useState(false) // Make password visible

    const navigate = useNavigate()

    // TODO get default filter values from url
    const [details, setDetails] = useState({
        first_name: "",
        last_name: "",
        email: "",
        phone: "",
        country_id: 1,
        password: ""
    })

    const [errors, setErrors] = useState({
        first_name: [],
        last_name: [],
        email: [],
        phone: [],
        country_id: [],
        password: []
    })

    /**
     * Sends the details to the backend for saving
     */
    function register(event){
        event.preventDefault()

        // Notify that loading is ongoing
        setLoading(true)

        usePostRequest(getApiUrl(API_ENDPOINTS.SIGNUP), details)
            .then((response) => {
                setLoading(false) // Done

                if(response.success){
                    // Registered
                    // User is at data.user
                    setCurrentUser(response.data.user)

                    // Token is at data.token
                    // TODO save the token to storage

                    // Redirect
                    // TODO to where the user intended to go
                    navigate(APP_ROUTES.FAVORITES)
                }else{
                    // TODO handle the error message properly
                    if(response.message){
                        alert(response.message)
                    }

                    // Set the validation errors
                    setErrors({...errors, ...response.errors})
                }
            })
            .catch((error) => {
                setLoading(false)
                console.log(error)
            })
    }


    // DOM EVENT HANDLERS
    function updateFirstName(event){
        setDetails({ ...details, first_name: event.target.value })
    }

    function updateLastName(event){
        setDetails({ ...details, last_name: event.target.value })
    }

    function updatePhone(event){
        setDetails({ ...details, phone: event.target.value })
    }

    function updateCountry(event){
        setDetails({ ...details, country_id: event.target.value })
    }

    function updateEmail(event){
        setDetails({ ...details, email: event.target.value })
    }

    function updatePassword(event){
        setDetails({ ...details, password: event.target.value })
    }

    return (
    <section className="py-4 py-md-5">
        <div className="container">

            <div className="row">

                <div className="col main-content">

                    <form onSubmit={register}>

                        <div className="auth-card mx-auto">

                            <div className="border with-loader mb-3">

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

                                <div className="px-4 pt-5 pb-1 top text-center">
                                    <Link className="logo d-block mb-4" to={APP_ROUTES.HOME}>
                                        <img src="/img/brand/blue.png" />
                                    </Link>

                                    <h4 className="mb-0">Create account</h4>
                                </div>

                                <div className="px-3 px-sm-4 py-4">

                                    <div className="mb-3 text-center">Continue with:</div>

                                    <div className="mb-4 text-center">
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

                                    <div className="mb-3 text-center">Or sign up without a social account. You can still link one under account settings</div>

                                    <div className="form-group mb-3">
                                        <div className="form-row">

                                            <div className="col-sm-6 mb-3 mb-sm-0">
                                                <div className="input-group">
                                                    <div className="input-group-prepend">
                                                        <span className="input-group-text">
                                                            <i className="fa fa-fw fa-user"></i>
                                                        </span>
                                                    </div>
                                                    <input className="form-control" placeholder="First Name" type="text" value={details.first_name} onChange={updateFirstName} required />
                                                </div>
                                            </div>

                                            <div className="col-sm-6">
                                                <div className="input-group">
                                                    <div className="input-group-prepend">
                                                        <span className="input-group-text">
                                                            <i className="fa fa-fw fa-user"></i>
                                                        </span>
                                                    </div>
                                                    <input className="form-control" placeholder="Last Name" type="text" value={details.last_name} onChange={updateLastName} required />
                                                </div>
                                            </div>

                                        </div>

                                        {
                                            [...errors.first_name, ...errors.last_name].map((error, index) => (
                                                <div key={index} className="small text-danger">{error}</div>
                                            ))
                                        }
                                    </div>

                                    <div className="form-group mb-3">
                                        <div className="input-group">
                                            <div className="input-group-prepend">
                                                <span className="input-group-text">
                                                    <i className="fa fa-fw fa-envelope"></i>
                                                </span>
                                            </div>
                                            <input className="form-control" placeholder="Your Email" type="email" value={details.email} onChange={updateEmail} required />
                                        </div>

                                        {
                                            errors.email.map((error, index) => (
                                                <div key={index} className="small text-danger">{error}</div>
                                            ))
                                        }
                                    </div>

                                    <div className="form-group mb-3">
                                        <div className="form-row">

                                            <div className="col-sm-6 mb-3 mb-sm-0">
                                                <div className="input-group legacy">
                                                    <div className="input-group-prepend">
                                                        <span className="input-group-text">
                                                            <i className="fa fa-fw fa-globe"></i>
                                                        </span>
                                                    </div>

                                                    <select className="nice-select form-control" value={details.country_id} onChange={updateCountry} required>
                                                        <option value="">Country</option>
                                                        {
                                                            countries.map((country) => (
                                                                <option value={country.id} key={country.id}>{country.name + ' (' + country.phone_code + ')'}</option>
                                                            ))
                                                        }
                                                    </select>
                                                </div>

                                            </div>

                                            <div className="col-sm-6">
                                                <div className="input-group legacy">
                                                    <div className="input-group-prepend">
                                                        <span className="input-group-text">
                                                            <i className="fa fa-fw fa-phone"></i>
                                                        </span>
                                                    </div>

                                                    <input className="form-control" placeholder="Phone Number" type="tel" value={details.phone} onChange={updatePhone} required />
                                                </div>
                                            </div>

                                        </div>

                                        {
                                            errors.phone.map((error, index) => (
                                                <div key={index} className="small text-danger">{error}</div>
                                            ))
                                        }

                                    </div>

                                    <div className="form-group mb-4">
                                        <div className="input-group">
                                            <div className="input-group-prepend">
                                                <span className="input-group-text">
                                                    <i className="fa fa-fw fa-lock"></i>
                                                </span>
                                            </div>
                                            <input className="form-control rounded-0" placeholder="Set a Password" type={passwordVisible ? "text" : "password"} value={details.password} onChange={updatePassword} required />
                                            <div className="input-group-append pass-toggle" onClick={() => setPasswordVisible(!passwordVisible)}>
                                                <span className="input-group-text">
                                                    <i className={passwordVisible ? "fa fa-fw fa-eye-slash":"fa fa-fw fa-eye"}></i>
                                                </span>
                                            </div>
                                        </div>

                                        {
                                            errors.password.map((error, index) => (
                                                <div key={index} className="small text-danger">{error}</div>
                                            ))
                                        }
                                    </div>

                                    <div className="mb-3">
                                        <button className="btn btn-default btn-block shadow-none">Submit</button>
                                    </div>

                                    <div>
                                        By signing up, you agree to our
                                        &nbsp;<Link to={getAppRoute(APP_ROUTES.TERMS)}>Terms of Service</Link>&nbsp;
                                        and <Link to={getAppRoute(APP_ROUTES.PRIVACY_POLICY)}>Privacy Policy</Link>
                                    </div>

                                </div>

                            </div>


                            <div className="text-center">
                                <span>Already Registered? <Link to={getAppRoute(APP_ROUTES.LOG_IN)}>Log In</Link></span>
                            </div>

                        </div>
                    </form>

                </div>

            </div>
        </div>
    </section>
    );
}

export default Signup;
