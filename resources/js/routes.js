const APP_ROUTES = {
    HOME: '/',

    // MARKET PLACE
    MARKET_MAIN: '/market',
    MARKET_CATEGORY: '/cars/:category',
    MARKET_SINGLE_CAR: '/car/:slug',
    MARKET_SELLER_PAGE: '/market/seller/:slug',

    // AUTH
    LOG_IN: '/login',
    FORGOT_PASSWORD: '/forgot-password',
    SIGN_UP: '/signup',
    VERIFY_EMAIL: 'verify-email',

    // USER
    FAVORITES: '/favorites',
    ACCOUNT: '/account',
    ALERTS: '/alerts',
    CREATE_ALERT: '/alerts/create',
    SUBSCRIPTIONS: '/subscriptions',

    // SELLER
    SELLER_HQ: '/seller/hq',
    SELLER_REGISTRATION: '/seller/register',
    VIEW_ADS: '/seller/ads',
    VIEW_SINGLE_SELLER_AD: '/seller/ads/:slug',
    CREATE_AD: '/seller/new-ad',

    // INFO
    TERMS: '/terms',
    PRIVACY_POLICY: '/privacy-policy',
}

/**
 * Get a internal route
 *
 * @param route The route string
 * @param params Route params if any
 */
 const getAppRoute = (route, params = null) => {
    if(params){
        for(const param in params){
            route = route.replace(`:${param}`, params[param])
        };
    }

    return route
}

export { APP_ROUTES, getAppRoute }
