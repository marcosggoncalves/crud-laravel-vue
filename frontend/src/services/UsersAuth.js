import axios from "@/axios/public";
import axios_private from "@/axios/private";
import { useRouter } from "vue-router";

export async function authLogin(body) {
    const response = await axios.post('/users/login', body);
    return response.data;
}

export async function authCheck() {
    const router = useRouter();
    
    try {
        await axios_private.post('/users/login-check', {});
    } catch (error) {
        router.push({ path: '/' })
    }
}
