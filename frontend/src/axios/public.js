
import axios from 'axios';
import apiUrl from './index.js';

const instance = axios.create({
    baseURL: apiUrl,
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    }
});

export default instance;