function useGetRequest(url){
    return sendRequest(url)
}

function usePostRequest(url, data){
    return sendRequest(url, {
        method: 'POST',
        body: JSON.stringify(data)
    });
}

function sendRequest(url, options = {}){
    // TODO fetch from a storage provider
    const userApiToken = "3|GxINktRoOT9oHP6QxOFpmsGBvEr6HMAxWvWKmmfh"

    options.headers = {
        "Content-Type": "application/json"
    }

    if(userApiToken) {
        options.headers.authorization = `Bearer ${userApiToken}`
    }

    return fetch(url, options)
    .then(response => response.json())
}

export { useGetRequest, usePostRequest }
