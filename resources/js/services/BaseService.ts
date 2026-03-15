import type {
  ICrudService,
  IApiResponse,
  IPaginationRequest,
} from "@/core/types/IApi";
import axios from "axios";

export class BaseService<TRequest, TResponse = any>
  implements ICrudService<TRequest>
{
  protected apiVersion = "/v1";

  constructor(protected baseEndpoint: string) {
    this.baseEndpoint = `${this.apiVersion}/${baseEndpoint}`;
  }

  private handleResponse<T>(response: any): IApiResponse<T> {
    return response.data;
  }

  private handleError(error: any): IApiResponse {
    if (axios.isCancel(error)) {
      return {
        success: false,
        message: "Request canceled",
        data: null,
        errors: {},
      };
    }

    if (error && error.data) {
      return {
        success: false,
        message: error.data.message || "Server error",
        data: null,
        errors: error.data.errors || {},
        ...error.data,
      };
    }

    if (error && error.message && error.errors) {
      return {
        success: false,
        message: error.message,
        data: null,
        errors: error.errors,
      };
    }

    return {
      success: false,
      message: error.message || "An unexpected error occurred",
      data: null,
      errors: {},
    };
  }

  async getAllPaginated(
    params?: IPaginationRequest,
    signal?: AbortSignal
  ): Promise<IApiResponse<TResponse[]>> {
    try {
      const response = await httpClient.get<IApiResponse<TResponse[]>>(
        this.baseEndpoint,
        { params, signal }
      );
      return this.handleResponse<TResponse[]>(response);
    } catch (error: any) {
      throw this.handleError(error);
    }
  }

  async getAll(
    pathname?: string,
    params?: Record<string, any>,
    signal?: AbortSignal
  ): Promise<IApiResponse<any>> {
    try {
      const endpoint = pathname
        ? `${this.baseEndpoint}/${pathname}`
        : this.baseEndpoint;
      const response = await httpClient.get<IApiResponse<any>>(endpoint, {
        params,
        signal,
      });
      return this.handleResponse<any>(response);
    } catch (error: any) {
      throw this.handleError(error);
    }
  }

  async getById(id: string | number): Promise<IApiResponse<TResponse>> {
    try {
      const response = await httpClient.get<IApiResponse<TResponse>>(
        `${this.baseEndpoint}/${id}`
      );
      return this.handleResponse<TResponse>(response);
    } catch (error: any) {
      throw this.handleError(error);
    }
  }

  async create(data: TRequest): Promise<IApiResponse<TResponse>> {
    try {
      const response = await httpClient.post<IApiResponse<TResponse>>(
        this.baseEndpoint,
        data
      );
      return this.handleResponse<TResponse>(response);
    } catch (error: any) {
      throw this.handleError(error);
    }
  }

  async update(
    id: string | number,
    data: Partial<TRequest>
  ): Promise<IApiResponse<TResponse>> {
    try {
      const response = await httpClient.put<IApiResponse<TResponse>>(
        `${this.baseEndpoint}/${id}`,
        data
      );
      return this.handleResponse<TResponse>(response);
    } catch (error: any) {
      throw this.handleError(error);
    }
  }

  async delete(id: string | number): Promise<IApiResponse<TResponse>> {
    try {
      const response = await httpClient.delete<IApiResponse<TResponse>>(
        `${this.baseEndpoint}/${id}`
      );
      return this.handleResponse<TResponse>(response);
    } catch (error: any) {
      throw this.handleError(error);
    }
  }

  async restore(id: string | number): Promise<IApiResponse<TResponse>> {
    try {
      const response = await httpClient.post<IApiResponse<TResponse>>(
        `${this.baseEndpoint}/${id}/restore`
      );
      return this.handleResponse<TResponse>(response);
    } catch (error: any) {
      throw this.handleError(error);
    }
  }

  async getByParams(
    params: Record<string, any>,
    signal?: AbortSignal
  ): Promise<IApiResponse<TResponse[]>> {
    try {
      const response = await httpClient.get<IApiResponse<TResponse[]>>(
        this.baseEndpoint,
        { params, signal }
      );
      return this.handleResponse<TResponse[]>(response);
    } catch (error: any) {
      throw this.handleError(error);
    }
  }

  async patch(
    id: string | number,
    data: Partial<TRequest>
  ): Promise<IApiResponse<TResponse>> {
    try {
      const response = await httpClient.patch<IApiResponse<TResponse>>(
        `${this.baseEndpoint}/${id}`,
        data
      );
      return this.handleResponse<TResponse>(response);
    } catch (error: any) {
      throw this.handleError(error);
    }
  }

  async getAllNested(
    parentId: string | number,
    nestedPath: string,
    params?: Record<string, any>,
    signal?: AbortSignal
  ): Promise<IApiResponse<any[]>> {
    try {
      const endpoint = `${this.baseEndpoint}/${parentId}/${nestedPath}`;
      const response = await httpClient.get<IApiResponse<any[]>>(endpoint, {
        params,
        signal,
      });
      return this.handleResponse<any[]>(response);
    } catch (error: any) {
      throw this.handleError(error);
    }
  }

  async createNested(
    parentId: string | number,
    nestedPath: string,
    data: any
  ): Promise<IApiResponse<any>> {
    try {
      const endpoint = `${this.baseEndpoint}/${parentId}/${nestedPath}`;
      const response = await httpClient.post<IApiResponse<any>>(endpoint, data);
      return this.handleResponse<any>(response);
    } catch (error: any) {
      throw this.handleError(error);
    }
  }

  async updateNested(
    parentId: string | number,
    nestedPath: string,
    id: string | number,
    data: Partial<any>
  ): Promise<IApiResponse<any>> {
    try {
      const endpoint = `${this.baseEndpoint}/${parentId}/${nestedPath}/${id}`;
      const response = await httpClient.put<IApiResponse<any>>(endpoint, data);
      return this.handleResponse<any>(response);
    } catch (error: any) {
      throw this.handleError(error);
    }
  }

  async deleteNested(
    parentId: string | number,
    nestedPath: string,
    id: string | number
  ): Promise<IApiResponse<any>> {
    try {
      const endpoint = `${this.baseEndpoint}/${parentId}/${nestedPath}/${id}`;
      const response = await httpClient.delete<IApiResponse<any>>(endpoint);
      return this.handleResponse<any>(response);
    } catch (error: any) {
      throw this.handleError(error);
    }
  }

  async restoreNested(
    parentId: string | number,
    nestedPath: string,
    id: string | number
  ): Promise<IApiResponse<any>> {
    try {
      const endpoint = `${this.baseEndpoint}/${parentId}/${nestedPath}/${id}/restore`;
      const response = await httpClient.post<IApiResponse<any>>(endpoint);
      return this.handleResponse<any>(response);
    } catch (error: any) {
      throw this.handleError(error);
    }
  }

  async getFile(pathname?: string): Promise<Blob> {
    try {
      const endpoint = `${this.baseEndpoint}/${pathname}`;
      const response = await httpClient.get<Blob>(endpoint, {
        responseType: "blob",
      });
      return response.data as Blob;
    } catch (error: any) {
      throw this.handleError(error);
    }
  }
  async exportTable(params?: Record<string, any>): Promise<Blob> {
    try {
      console.log('exportable');
      
      const endpoint = `${this.baseEndpoint}`;
      const response = await httpClient.get<Blob>(endpoint, {
        params,
        responseType: "blob",
      });
      return response.data as Blob;
    } catch (error: any) {
      throw this.handleError(error);
    }
  }
}
