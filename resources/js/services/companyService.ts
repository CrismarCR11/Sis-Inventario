import axios from '@/plugins/axios';

export interface Company {
    id: string;
    ruc: string;
    razon_social: string;
    nombre_comercial?: string;
    email?: string;
    telefono?: string;
    direccion?: string;
    logo_url?: string;
    configuracion?: {
        moneda: string;
        pais: string;
        zona_horaria: string;
    };
    activo: boolean;
    locales_count?: number;
    created_at: string;
    updated_at: string;
}

export interface CompanyFormData {
    ruc: string;
    razon_social: string;
    nombre_comercial?: string;
    email?: string;
    telefono?: string;
    direccion?: string;
    logo_url?: string;
    configuracion?: {
        moneda: string;
        pais: string;
        zona_horaria: string;
    };
}

class CompanyService {
    private baseUrl = '/companies';

    async all(page: number = 1): Promise<{ data: Company[]; meta: any }> {
        const response = await axios.get(`${this.baseUrl}?page=${page}`);
        return response.data;
    }

    async find(id: string): Promise<Company> {
        const response = await axios.get(`${this.baseUrl}/${id}`);
        return response.data.data;
    }

    async create(data: CompanyFormData): Promise<Company> {
        const response = await axios.post(this.baseUrl, data);
        return response.data.data;
    }

    async update(id: string, data: Partial<CompanyFormData>): Promise<Company> {
        const response = await axios.put(`${this.baseUrl}/${id}`, data);
        return response.data.data;
    }

    async delete(id: string): Promise<void> {
        await axios.delete(`${this.baseUrl}/${id}`);
    }

    // async toggleStatus(id: string): Promise<Company> {
    //     const response = await axios.post(`${this.baseUrl}/${id}/toggle-status`);
    //     return response.data.data;
    // }
    async search(query: string, page: number = 1): Promise<{ data: Company[]; meta: any }> {
        const response = await axios.get(`${this.baseUrl}?search=${query}&page=${page}`);
        return response.data;
    }

    async getByStatus(active: boolean, page: number = 1): Promise<{ data: Company[]; meta: any }> {
        const response = await axios.get(`${this.baseUrl}?active=${active}&page=${page}`);
        return response.data;
    }

    async export(format: 'pdf' | 'excel'): Promise<Blob> {
        const response = await axios.get(`${this.baseUrl}/export`, {
            params: { format },
            responseType: 'blob'
        });
        return response.data;
    }

    async toggleStatus(id: string): Promise<Company> {
        const response = await axios.post(`${this.baseUrl}/${id}/toggle-status`);
        return response.data.data;
    }

    async validateRuc(ruc: string): Promise<{ valid: boolean; message?: string }> {
        const response = await axios.post(`${this.baseUrl}/validate-ruc`, { ruc });
        return response.data;
    }
}

export default new CompanyService();