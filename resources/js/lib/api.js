export default class ApiHandler {
    constructor() {
        axios.defaults.headers.common = {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };
    }

    test(){
        return "あいうえお"
    }
}
