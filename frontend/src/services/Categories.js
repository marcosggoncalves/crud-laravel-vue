import axios from "@/axios/private";

export async function getCategoriesList() {
    const response = await axios.get(`/categories`);
    return response.data;
}

export async function categoryPost(body) {
    const method = body.id != null ? 'put' : 'post';
    const url = body.id != null ? `/categories/${body.id}` : '/categories';
    const response = await axios[method](url, body);
    return response.data;
}

export async function categoryDelete(id) {
    const response = await axios.delete(`/categories/${id}`);
    return response.data;
}