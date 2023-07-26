import axios from 'axios';

let token = window.localStorage.getItem('token_');

const instance = axios.create({
    baseURL: 'http://localhost:8000/api/v1/',
    headers: {
        "Content-Type": "application/json",
        "authorization": `Bearer ${token}`
    }
});

export default instance;