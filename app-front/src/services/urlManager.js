export default {
    clients: {
        list: '/api/clients'
    },
    loan: {
        validate: '/api/loan/validate',
        approve: '/api/loan',
    },
    route: (url) => {
        return 'http://localhost:8080' + url;
    }
}