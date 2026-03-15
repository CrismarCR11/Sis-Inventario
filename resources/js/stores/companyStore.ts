import { defineStore } from 'pinia';
import companyService, { type Company, type CompanyFormData } from '@/services/companyService';
import { createCrudStoreOptions } from '@/stores/factories/CrudFactory';
import { useAuthStore } from '@/stores/auth';
import type { IPaginationRequest } from '@/core/types/IApi';

const crudOptions = createCrudStoreOptions<CompanyFormData, Company>(companyService);

interface CompanyState {
    companies: Company[];
    currentCompany: Company | null;
    loading: boolean;
    error: string | null;
    pagination: {
        total: number;
        count: number;
        per_page: number;
        current_page: number;
        total_pages: number;
    };
     lastResponse: any;
}

export const useCompanyStore = defineStore('company', {
    state: (): CompanyState => ({
        companies: [],
        currentCompany: null,
        loading: false,
        error: null,
        pagination: {
            total: 0,
            count: 0,
            per_page: 15,
            current_page: 1,
            total_pages: 1
        },
        lastResponse: null,
    }),

    getters: {
        isLoading: (state) => state.loading,
        getError: (state) => state.error,
        activeCompanies: (state) => state.companies.filter(c => c.activo),
        totalItems: (state) => state.pagination.total
    },

    actions: {
        async getAllPaginated(params: IPaginationRequest) {
            this.loading = true;
            this.error = null;
            try {
                const response = await companyService.search(params.search || '', params.page || 1);
                this.companies = response.data;
                if (response.meta) {
                    this.pagination = {
                        total: response.meta.total,
                        count: response.data.length,
                        per_page: response.meta.per_page,
                        current_page: response.meta.current_page,
                        total_pages: response.meta.last_page
                    };
                }
            } catch (error: any) {
                this.error = error.response?.data?.message || 'Error al cargar empresas';
                console.error('Error fetching companies:', error);
            } finally {
                this.loading = false;
            }
        },

        async fetchCompanies(page: number = 1) {
            const auth = useAuthStore();
            if (!auth.isAuthenticated) return;

            this.loading = true;
            this.error = null;
            
            try {
                const response = await companyService.all(page);
                this.companies = response.data;
                if (response.meta) {
                    this.pagination = {
                        total: response.meta.total,
                        count: response.data.length,
                        per_page: response.meta.per_page,
                        current_page: response.meta.current_page,
                        total_pages: response.meta.last_page
                    };
                }
            } catch (error: any) {
                this.error = error.response?.data?.message || 'Error al cargar empresas';
                console.error('Error fetching companies:', error);
            } finally {
                this.loading = false;
            }
        },

        async fetchCompany(id: string) {
            this.loading = true;
            this.error = null;
            
            try {
                this.currentCompany = await companyService.find(id);
            } catch (error: any) {
                this.error = error.response?.data?.message || 'Error al cargar la empresa';
                console.error('Error fetching company:', error);
            } finally {
                this.loading = false;
            }
        },

        async createCompany(data: CompanyFormData) {
            this.loading = true;
            this.error = null;
            
            try {
                const newCompany = await companyService.create(data);
                this.companies.unshift(newCompany);
                return newCompany;
            } catch (error: any) {
                this.error = error.response?.data?.message || 'Error al crear empresa';
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async updateCompany(id: string, data: Partial<CompanyFormData>) {
            this.loading = true;
            this.error = null;
            
            try {
                const updated = await companyService.update(id, data);
                const index = this.companies.findIndex(c => c.id === id);
                if (index !== -1) {
                    this.companies[index] = updated;
                }
                if (this.currentCompany?.id === id) {
                    this.currentCompany = updated;
                }
                return updated;
            } catch (error: any) {
                this.error = error.response?.data?.message || 'Error al actualizar empresa';
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async deleteCompany(id: string) {
            this.loading = true;
            this.error = null;
            
            try {
                await companyService.delete(id);
                this.companies = this.companies.filter(c => c.id !== id);
            } catch (error: any) {
                this.error = error.response?.data?.message || 'Error al eliminar empresa';
                throw error;
            } finally {
                this.loading = false;
            }
        },
        async toggleCompanyStatus(id: string) {
            this.loading = true;
            this.error = null;
            
            try {
                const updated = await companyService.toggleStatus(id);
                const index = this.companies.findIndex(c => c.id === id);
                if (index !== -1) {
                    this.companies[index] = updated;
                }
                if (this.currentCompany?.id === id) {
                    this.currentCompany = updated;
                }
                return updated;
            } catch (error: any) {
                this.error = error.response?.data?.message || 'Error al cambiar estado de la empresa';
                throw error;
            } finally {
                this.loading = false;
            }
        },
        async clearCurrentCompany() {
            this.currentCompany = null;
        },
        async resetError() {
            this.error = null;
        },

        // Método para limpiar el store (útil al logout)
        async reset() {
            this.companies = [];
            this.currentCompany = null;
            this.loading = false;
            this.error = null;
            this.pagination = {
                total: 0,
                count: 0,
                per_page: 15,
                current_page: 1,
                total_pages: 1
            };
            this.lastResponse = null;
        }

    }
});