import axios from "@/axios/public";

export async function authLogin(body) {
    const response = await axios.post('/users/login', body);
    return response.data;
}
