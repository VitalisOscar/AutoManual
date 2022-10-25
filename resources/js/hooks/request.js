function useGetRequest(url){
    return sendRequest(url)
}

function usePostRequest(url, data){
    return sendRequest(url, {
        body: JSON.stringify(data)
    });
}

function sendRequest(url, options = {}){
    // TODO fetch from a storage provider
    const userApiToken = "3|GxINktRoOT9oHP6QxOFpmsGBvEr6HMAxWvWKmmfh"

    const headers = {
        "Content-Type": "application/json"
    }

    if(userApiToken) {
        headers.authorization = `Bearer ${userApiToken}`
    }

    return fetch(url, {
        headers: headers
    })
    .then(response => response.json())
}

export { useGetRequest, usePostRequest }
