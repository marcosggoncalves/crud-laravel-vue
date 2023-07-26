import axios from "@/axios/private";

export async function getProductsList(page = 1) {
    const response = await axios.get(`/products`, { params: { page } });
    return response.data;
}

export async function productPost(body) {
    const method = body.id != null ? 'put' : 'post';
    const url = body.id != null ? `/products/${body.id}` : '/products';
    const response = await axios[method](url, body);
    return response.data;
}

export async function productDelete(id) {
    const response = await axios.delete(`/products/${id}`);
    return response.data;
}