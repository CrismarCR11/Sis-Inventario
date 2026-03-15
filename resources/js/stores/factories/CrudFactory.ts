import type {
  ICrudService,
  IApiResponse,
  IPagination,
  IPaginationRequest,
} from "@/core/types/IApi";
import type { StoreGeneric } from "pinia";
import axios from "axios";

interface ICrudState<TResponse> {
  items: TResponse[];
  item: TResponse | null;
  pagination: IPagination | null;
  loading: boolean;
  formLoading: boolean;
  error: string | null;
  queryParams: IPaginationRequest;
  searchAbortController: AbortController | null;
}

export const createCrudStoreOptions = <TRequest, TResponse>(
  service: ICrudService<TRequest>
) => {
  return {
    state: (): ICrudState<TResponse> => ({
      items: [],
      item: null,
      pagination: {
        total: 0,
        count: 0,
        per_page: 10,
        current_page: 1,
        total_pages: 1,
      },
      loading: false,
      formLoading: false,
      error: null,
      queryParams: {
        page: 1,
        limit: 10,
      },
      searchAbortController: null,
    }),

    getters: {
      getItems: (state: ICrudState<TResponse>) => state.items,
      getItem: (state: ICrudState<TResponse>) => state.item,
      getLoading: (state: ICrudState<TResponse>) => state.loading,
      getFormLoading: (state: ICrudState<TResponse>) => state.formLoading,
      getPagination: (state: ICrudState<TResponse>) => state.pagination,
      getError: (state: ICrudState<TResponse>) => state.error,
    },

    actions: {
      async getAllPaginated(
        this: StoreGeneric,
        params?: IPaginationRequest
      ): Promise<void> {
        if (this.searchAbortController) {
          this.searchAbortController.abort();
        }

        const controller = new AbortController();
        this.searchAbortController = controller;

        this.loading = true;
        this.error = null;
        try {
          const mergedParams = {
            ...this.queryParams,
            ...params,
          };
          this.queryParams = mergedParams;
          const response = await service.getAllPaginated(
            mergedParams,
            controller.signal
          );
          if (response.success && response.data !== null) {
            this.items = response.data as TResponse[];
            this.pagination = response.meta?.pagination || this.pagination;
          } else {
            this.error = response.message || "Error fetching data";
          }
        } catch (e: any) {
          if (!axios.isCancel(e)) {
            this.error = e.message || "An unexpected error occurred";
          }
        } finally {
          if (this.searchAbortController === controller) {
            this.searchAbortController = null;
          }
          this.loading = false;
        }
      },
      async exportTable(
        this: StoreGeneric,
        params?: Record<string, any>
      ){
        const response = await service.exportTable(params );
        return response;
      },

      async getAll(
        this: StoreGeneric,
        pathname?: string,
        params?: Record<string, any>
      ): Promise<void> {
        if (this.searchAbortController) {
          this.searchAbortController.abort();
        }

        const controller = new AbortController();
        this.searchAbortController = controller;

        this.loading = true;
        this.error = null;
        try {
           const response = await service.getAll(pathname, params, controller.signal);
          if (response.data !== null) {
            this.items = response.data as TResponse[];
          } else {
            this.error = response.message || "Error fetching data";
          }
        } catch (e: any) {
          this.error = e.message || "An unexpected error occurred";
        } finally {
          if (this.searchAbortController === controller) {
            this.searchAbortController = null;
          }
          this.loading = false;
        }
      },

      async getById(this: StoreGeneric, id: string | number): Promise<void> {
        this.formLoading = true;
        this.error = null;
        try {
          const response = await service.getById(id);
          if (response.data != null) {
            this.item = response.data;
          } else {
            this.error = response.message || "Error fetching item";
          }
        } catch (e: any) {
          this.error = e.message || "An unexpected error occurred";
        } finally {
          this.formLoading = false;
        }
      },

      async create(
        this: StoreGeneric,
        data: TRequest
      ): Promise<IApiResponse<TResponse>> {
        this.formLoading = true;
        this.error = null;
        try {
          const response = await service.create(data);
          return response;
        } catch (e: any) {
          return e as IApiResponse<TResponse>;
        } finally {
          this.formLoading = false;
        }
      },

      async update(
        this: StoreGeneric,
        id: string | number,
        data: TRequest
      ): Promise<IApiResponse<TResponse>> {
        this.formLoading = true;
        this.error = null;
        try {
          const response = await service.update(id, data);
          return response;
        } catch (e: any) {
          return e as IApiResponse<TResponse>;
        } finally {
          this.formLoading = false;
        }
      },

      async delete(
        this: StoreGeneric,
        id: string | number
      ): Promise<IApiResponse> {
        this.formLoading = true;
        this.error = null;
        try {
          const response = await service.delete(id);
          return response;
        } catch (e: any) {
          return e as IApiResponse;
        } finally {
          this.formLoading = false;
        }
      },

      async restore(
        this: StoreGeneric,
        id: string | number
      ): Promise<IApiResponse<TResponse>> {
        this.formLoading = true;
        this.error = null;
        try {
          const response = await service.restore(id);
          return response;
        } catch (e: any) {
          return e as IApiResponse<TResponse>;
        } finally {
          this.formLoading = false;
        }
      },

      async getByParams(
        this: StoreGeneric,
        params: Record<string, any>
      ): Promise<IApiResponse<TResponse[]>> {
        this.formLoading = true;
        this.error = null;
        try {
          if (service.getByParams) {
            const response = await service.getByParams(params);
            return response;
          } else {
            throw new Error(
              "getByParams method not implemented in the service."
            );
          }
        } catch (e: any) {
          return e as IApiResponse<TResponse[]>;
        } finally {
          this.formLoading = false;
        }
      },

      async patch(
        this: StoreGeneric,
        id: string | number,
        data: Partial<TRequest>
      ): Promise<IApiResponse<TResponse>> {
        this.formLoading = true;
        this.error = null;
        try {
          if (service.patch) {
            const response = await service.patch(id, data);
            return response;
          } else {
            throw new Error("Patch method not implemented in the service.");
          }
        } catch (e: any) {
          return e as IApiResponse<TResponse>;
        } finally {
          this.formLoading = false;
        }
      },


      async downloadFile(this: StoreGeneric, pathname: string) {
        this.formLoading = true;
        this.error = null;
        try {
          if (service.getFile) {
            const response = await service.getFile(pathname);
            return response;
          } else {
            throw new Error("Patch method not implemented in the service.");
          }
        } catch (e: any) {
          return e as IApiResponse<TResponse>;
        } finally {
          this.formLoading = false;
        }
      },
    },
  };
};
