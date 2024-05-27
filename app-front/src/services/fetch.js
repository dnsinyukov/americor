import {defu} from 'defu';
import {ofetch} from "ofetch";

export default function (url, options = {}) {

    const defaults = {
        baseURL: `http://localhost:8080/api`,
    }

    const params = defu(options, defaults)

    return ofetch(url, params);
}