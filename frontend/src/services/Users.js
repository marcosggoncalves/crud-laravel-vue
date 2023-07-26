import axios from "@/axios/private";

export async function getUsersList(page = 1) {
    const response = await axios.get(`/users`, { params: { page } });
    return response.data;
}

export async function userPost(body) {
    const method = body.id != null ? 'put' : 'post';
    const url = body.id != null ? `/users/${body.id}` : '/users';
    const response = await axios[method](url, body);
    return response.data;
}

export async function userDelete(id) {
    const response = await axios.delete(`/users/${id}`);
    return response.data;
}