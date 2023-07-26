
import axios from 'axios';

const instance = axios.create({
    baseURL: 'http://sistemadourados.ddns.net:8000/api/v1/',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    }
});

export default instance;