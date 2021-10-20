import axios from 'axios'

const request = axios.create({
    timeout: 30000,
    headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
    },
    validateStatus: function (status) {
        return status >= 200 && status <= 450;
    }
})

export {
    request
}