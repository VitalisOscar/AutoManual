import React, { useContext, useEffect, useState } from 'react';
import { Link, useParams } from 'react-router-dom';
import { API_ENDPOINTS, getApiUrl } from '../../../api';
import { UserContext } from '../../../context/user';
import { APP_ROUTES, getAppRoute } from '../../../routes';
import NotFound from '../NotFound';

function ListingPage() {
    // Component Data
    const [car, setCar] = useState(null)
    const [loading, setLoading] = useState(true)

    const {currentUser} = useContext(UserContext)

    const [enquiry, setEnquiry] = useState({
        name: currentUser.name ?? '',
        phone: currentUser.phone ?? '',
        phone_code: '',
        message: ''
    })


    const params = useParams()

    // Fetch the listing
    useEffect(() => {
        fetch(getApiUrl(API_ENDPOINTS.GET_SINGLE_MARKETPLACE_CAR, {
            slug: params.slug
        }))
        .then(response => response.json())
        .then(response => {
            setLoading(false)

            if(response.success){
                setCar(response.data)
            }else{
                console.log(response.message)
            }
        })
        .catch(error => console.log(error))
    }, [])


    // EVENT HANDLERS
    function setEnquiryName(event){ setEnquiry({...enquiry, name: event.target.value}) }

    function setEnquiryPhone(event){ setEnquiry({...enquiry, phone: event.target.value}) }

    function setEnquiryPhoneCode(event){ setEnquiry({...enquiry, phone_code: event.target.value}) }

    function setEnquiryMessage(event){ setEnquiry({...enquiry, message: event.target.value}) }


    function sendEnquiry(event){
        event.preventDefault();
        // TODO add send enquiry functionality
    }

    function reportAd(){
        // TODO add report ad functionality
        console.log('Report ad')
    }

    function addFavorite(){
        // TODO add favorite functionality
    }

    return loading ?
        // LOADER
        (
            <div className="py-5 d-flex align-items-center justify-content-center">
                <div className="text-center">
                    <div className="spinner-border text-primary mb-4"></div>
                    <div>Just a moment...</div>
                </div>
            </div>
        )
        :
        (
            car ?
                (
                // CAR INFO
                <section className="py-4 main-content">
                    <div className="container mb-3">

                        <div className="row">

                            {/* FIRST SECTION (LEFT SECTION ON LARGE DEVICE) */}
                            <div className="col-md-8 col-lg-8 col-xl-8 ad-info mb-3">

                                <div className="card h-100">

                                    {/* CAR INTRO */}
                                    <div className="px-3 px-sm-4 py-3 border-bottom">

                                        <div className="d-flex align-items-top mb-3">
                                            <h1 className="heading-title font-weight-700 title float-left">{car.title}</h1>

                                            <span id="fav-btn" className="fav-btn" data-toggle="tooltip" onClick={addFavorite} title="Add to Favorites">
                                                <i id="fav-icon" className="fa fa-heart-o"></i>
                                                <span className="overlay"></span>
                                            </span>

                                            <div className="clearfix"></div>
                                        </div>

                                        <div>
                                            <h6 className="price mb-2">{car.price}</h6>

                                            <h5 className="d-flex align-items-center mb-0">
                                                <i className="fa fa-map-marker fa-sm text-muted mr-3"></i>{(car.location.area ? (car.location.area + ', ') : '') + car.location.town}
                                            </h5>
                                        </div>

                                    </div>
                                    {/* END CAR INTRO */}


                                    {/* CAR IMAGES */}
                                    <div className="carousel slide" id="carousel" data-ride="carousel" data-interval="5000">

                                        <div className="images carousel-inner">

                                            {
                                                car.images.map((image, index) => (
                                                    <div key={image.id} className={"image carousel-item" + (index == 0 ? " active":"")}>
                                                        <img src={image.url} alt={car.title} className="img-fluid"/>
                                                    </div>
                                                ))
                                            }

                                        </div>

                                        <ul className="carousel-indicators">
                                            {
                                                car.images.map((image, index) => (
                                                    <li className={(index == 0 ? " active":"")} key={image.id} data-target="#carousel" data-slide-to={index}></li>
                                                ))
                                            }
                                        </ul>

                                        <div className="carousel-controls">
                                            <a className="carousel-control-prev" data-slide="prev" data-target="#carousel">
                                                <span title="Prev" className="ml-2">
                                                    <span className="fa fa-chevron-left"></span>
                                                </span>
                                            </a>

                                            <a className="carousel-control-next" data-slide="next" href="#carousel">
                                                <span title="Next" className="mr-1">
                                                    <span className="fa fa-chevron-right"></span>
                                                </span>
                                            </a>
                                        </div>

                                    </div>
                                    {/* END CAR IMAGES */}


                                    {/* OVERVIEW AND FEATURES */}
                                    <div className="card-body px-0 py-0 pt-sm-4">
                                        <div className="info-section px-sm-4">

                                            <h5>Description</h5>
                                            <div className="mb-3">
                                                {car.description ?? 'No additional description provided by seller'}
                                            </div>

                                        </div>


                                        {/* CAR OVERVIEW */}
                                        <div className="info-section pt-4 px-sm-4">

                                            <div className="container mb-3 px-2">
                                                <div className="row px-0 overview-wrap">

                                                    <div className="col-6 col-md-6 col-lg-4 px-2">
                                                        <dl className="dlist">
                                                            <dt><i className="fa fa-map-marker bg-danger"></i><span>Town</span></dt>
                                                            <dd>{car.location.town}</dd>
                                                        </dl>
                                                    </div>

                                                    <div className="col-6 col-md-6 col-lg-4 px-2">
                                                        <dl className="dlist">
                                                            <dt><i className="fas fa-dashboard bg-indigo"></i><span>Mileage</span></dt>
                                                            <dd>{car.mileage}</dd>
                                                        </dl>
                                                    </div>

                                                    <div className="col-6 col-md-6 col-lg-4 px-2">
                                                        <dl className="dlist">
                                                            <dt><i className="fa fa-car bg-warning"></i><span>Condition</span></dt>
                                                            <dd>{car.category.name}</dd>
                                                        </dl>
                                                    </div>

                                                    <div className="col-6 col-md-6 col-lg-4 px-2">
                                                        <dl className="dlist">
                                                            <dt><i className="fa fa-calendar-o bg-info"></i><span>Year</span></dt>
                                                            <dd>{car.year}</dd>
                                                        </dl>
                                                    </div>

                                                    <div className="col-6 col-md-6 col-lg-4 px-2">
                                                        <dl className="dlist">
                                                            <dt><i className="fas fa-car-side bg-success"></i><span>Body Type</span></dt>
                                                            <dd>{car.body_type.name}</dd>
                                                        </dl>
                                                    </div>

                                                    <div className="col-6 col-md-6 col-lg-4 px-2">
                                                        <dl className="dlist">
                                                            <dt><i className="fas fa-gas-pump bg-warning"></i><span>Fuel</span></dt>
                                                            <dd>{car.fuel}</dd>
                                                        </dl>
                                                    </div>

                                                    <div className="col-6 col-md-6 col-lg-4 px-2">
                                                        <dl className="dlist">
                                                            <dt><i className="fa fa-paint-brush bg-primary"></i><span>Color</span></dt>
                                                            <dd>{car.color}</dd>
                                                        </dl>
                                                    </div>

                                                    <div className="col-6 col-md-6 col-lg-4 px-2">
                                                        <dl className="dlist">
                                                            <dt><i className="fas fa-gears bg-purple"></i><span>Transmission</span></dt>
                                                            <dd>{car.transmission}</dd>
                                                        </dl>
                                                    </div>

                                                    <div className="col-6 col-md-6 col-lg-4 px-2">
                                                        <dl className="dlist">
                                                            <dt><i className="fa fa-gear bg-danger"></i><span>Engine</span></dt>
                                                            <dd>{car.engine}</dd>
                                                        </dl>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                        {/* END CAR OVERVIEW */}


                                        {/* CAR FEATURES */}
                                        <div className="info-section mb-3 px-sm-4">

                                            <h5>Features</h5>

                                            <div className="container features px-0">
                                                <div className="row px-0">

                                                    {
                                                        car.features.map((feature) => (
                                                            <div key={feature} className="col-sm-4 col-lg-4 feature">
                                                                <i className="fa fa-check-square-o"></i><span>{feature}</span>
                                                            </div>
                                                        ))
                                                    }

                                                </div>
                                            </div>

                                        </div>
                                        {/* END FEATURES */}


                                        {/* REPORT AND SHARE */}
                                        <div className="info-section py-3 px-sm-3 border-top">
                                            <div className="actions">
                                                <button onClick={reportAd} className="btn btn-report btn-link px-0 py-2 mr-2">
                                                    <i className="fa fa-warning mr-1"></i>Report Ad
                                                </button>

                                                <div className="share-links float-right">
                                                    <button title="Share on Facebook" className="bg-primary">
                                                        <i className="fa fa-facebook"></i>
                                                    </button>

                                                    <a href="#" title="Share on Twitter" className="bg-info">
                                                        <i className="fa fa-twitter"></i>
                                                    </a>

                                                    <a href="#" title="Share on WhatsApp" className="bg-success">
                                                        <i className="fa fa-whatsapp"></i>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                        {/* END REPORT AND SHARE */}

                                    </div>
                                    {/* END OVERVIEW AND FEATURES */}

                                </div>

                            </div>
                            {/* END FIRST SECTION */}


                            {/* SECOND SECTION (RIGHT SECTION ON LARGE DEVICE) */}
                            <div className="col-md-4 col-lg-4 col-xl-4 px-0 px-md-3">

                                {/* SELLER INFO */}
                                <div className="px-3 px-md-0">
                                    <div className="card mb-3">
                                        <h5 className="border-bottom px-3 py-2">Listed By</h5>

                                        <div className="px-3 py-2">
                                            <div className="form-row">

                                                <div className="seller mb-2 mb-sm-0 mb-md-2 col-sm-6 col-md-12">
                                                    <div>
                                                        <img className="seller-logo img-fluid" src={car.seller.logo} alt={car.seller.name} />
                                                    </div>

                                                    <div className="mt-3">
                                                        <div className="d-flex align-items-center">
                                                            <strong className="d-inline-block">
                                                                <span className="mr-2">{car.seller.name}</span>
                                                                <span className="font-weight-normal">({car.seller.profile_type.name})</span>
                                                            </strong>

                                                            {/* VERIFICATION STATUS */}
                                                            {
                                                                car.seller.verified ?
                                                                    <div className="verified-seller d-inline-flex align-items-center pl-3 ml-auto" title="The seller has been verified by AutoManual">
                                                                        <strong className="text-success">Verified</strong>
                                                                        <img src="/img/icons/verified.png" alt="Verified Seller" className="ml-auto mr-0 d-inline-block"/>
                                                                    </div>
                                                                :
                                                                    ''
                                                            }
                                                        </div>

                                                        <dl className="mb-0">
                                                            <dt className="font-weight-normal d-inline-block">Total Ads:</dt>
                                                            <dd className="ml-2 d-inline-block">{car.seller.total_approved_cars}</dd>
                                                        </dl>

                                                    </div>

                                                </div>


                                                <div className="col-sm-6 col-md-12">

                                                    <div className="">
                                                        <Link
                                                            to={getAppRoute(APP_ROUTES.MARKET_SELLER_PAGE, {slug: car.seller.slug})}
                                                            className="btn btn-default btn-block py-2 mb-3 shadow-none"
                                                            >
                                                            View Seller Ads
                                                        </Link>
                                                    </div>

                                                    <div className="">
                                                        <div className="contact-options mb-2">
                                                            <h5 className="contact-title font-weight-400">Get in touch</h5>
                                                            <div className="contact">
                                                                <a href={"tel:" + car.seller.phone} className="btn-phone" data-toggle="tooltip" title="Call">
                                                                    <i className="fa fa-phone"></i>
                                                                </a>

                                                                <a href={"mailto:" + car.seller.email} className="btn-mail" data-toggle="tooltip" title="Email">
                                                                    <i className="fa fa-envelope"></i>
                                                                </a>


                                                                <a href={"https://wa.me/" + car.seller.phone + "?text=Hello, I'm interested in your ad"} target="_blank" className="btn-whatsapp" data-toggle="tooltip" title="Whatsapp">
                                                                    <i className="fa fa-whatsapp"></i>
                                                                </a>
                                                            </div>
                                                            <div className="clearfix"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                {/* END SELLER INFO */}



                                {/* SEND INQUIRY */}
                                <div className="px-3 px-md-0">
                                    <div className="card mb-3 pb-2">
                                        <h5 className="border-bottom px-3 py-2">Send Enquiry</h5>

                                        <div className="py-2 px-3 enquiry">

                                            <form onSubmit={sendEnquiry} className="with-loader">

                                                <div className="loader d-none" id="loader">
                                                    <div className="spinner-border text-primary"></div>
                                                </div>

                                                <div className="hint">
                                                    Leave your name, phone number and a short message. We'll let the seller know about your enquiry
                                                </div>

                                                <div className="form-row">
                                                    <div className="col-12 col-sm-6 col-md-12">
                                                        <div className="form-group">
                                                            <div className="input-group">
                                                                <div className="input-group-prepend">
                                                                    <span className="input-group-text">
                                                                        <i className="fa fa-fw fa-user"></i>
                                                                    </span>
                                                                </div>
                                                                <input className="form-control" value={enquiry.name} onChange={setEnquiryName} placeholder="Your Name" type="text" required/>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div className="col-12 col-sm-6 col-md-12">
                                                        <div className="form-group">
                                                            <div className="input-group">
                                                                <div className="input-group-prepend">
                                                                    <span className="input-group-text">
                                                                        <i className="fa fa-phone"></i>
                                                                    </span>
                                                                </div>
                                                                <input className="form-control" value={enquiry.phone} onChange={setEnquiryPhone} placeholder="Phone Number" type="tel" minLength="10" maxLength="10" required/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div className="form-group">
                                                    <textarea className="form-control" rows="4" value={enquiry.message} onChange={setEnquiryMessage} required></textarea>
                                                </div>

                                                <div className="form-group">
                                                    <button className="btn btn-block btn-outline-warning shadow-none" id="send_enquiry">Submit</button>
                                                </div>

                                            </form>

                                            <div className="note">
                                                By clicking Submit, you agree that:
                                                <ul className="px-3">
                                                    <li>The information you provide will be shared with the car seller</li>
                                                    <li>The seller may contact you via SMS, WhatsApp or a phone call regarding the listing</li>
                                                </ul>

                                                We do not share any of your data with any other third party without your consent.
                                                For more info, check our <Link to={getAppRoute(APP_ROUTES.TERMS)}>Terms of Service</Link> and <Link to={getAppRoute(APP_ROUTES.PRIVACY_POLICY)}>Privacy Policy</Link>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                {/* END SELLER ENQUIRY */}


                                {/* BUYER SAFETY */}
                                <div className="card safety-first mb-3 mx-sm-3 mx-md-0">
                                    <h5 className="border-bottom px-3 py-2 text-success">Safety First</h5>

                                    <div className="px-3 pt-2 pb-4 safety">
                                        <div><i className="fa fa-check-square-o text-muted mr-1"></i>Do not make payments before inspecting the vehicle</div>
                                        <div><i className="fa fa-check-square-o text-muted mr-1"></i>Meet with the seller in a safe public place</div>
                                        <div><i className="fa fa-check-square-o text-muted mr-1"></i>Always follow the legal process when purchasing a vehicle</div>
                                        <div><i className="fa fa-check-square-o text-muted mr-1"></i>Report any ads that appear to be fraudulent</div>
                                    </div>
                                </div>
                                {/* END BUYER SAFETY */}

                            </div>
                            {/* END SECOND SECTION */}

                        </div>

                    </div>

                </section>
                )

                :

                // LISTING NOT FOUND

                (<NotFound />)
        )
}

export default ListingPage;
