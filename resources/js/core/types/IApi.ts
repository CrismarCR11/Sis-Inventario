export interface IApiResponse<T = any> {
  success: boolean;
  message?: string;
  data: T;
  errors?: Record<string, string[]>;
  meta?: {
    pagination: IPagination;
  };
}

export interface IPagination {
  total: number;
  count: number;
  per_page: number;
  current_page: number;
  total_pages: number;
}

export interface IPaginationRequest {
  page?: number;
  limit?: number;
  search?: string;
  sortBy?: ISortBy;
  [key: string]: any;
}

export interface ISortBy {
  sort: string;
  order: 'asc' | 'desc';
}

export interface ICrudService<TRequest> {
  getAllPaginated(params?: IPaginationRequest, signal?: AbortSignal): Promise<IApiResponse<any>>;
  getAll(pathname?: string, params?: Record<string, any>, signal?: AbortSignal): Promise<IApiResponse<any>>;
  getById(id: string | number): Promise<IApiResponse<any>>;
  create(data: TRequest): Promise<IApiResponse<any>>;
  update(id: string | number, data: Partial<TRequest>): Promise<IApiResponse<any>>;
  delete(id: string | number): Promise<IApiResponse<any>>;
  restore(id: string | number): Promise<IApiResponse<any>>;

  getAllNested?(parentId: string | number, nestedPath: string, params?: Record<string, any>, signal?: AbortSignal): Promise<IApiResponse<any>>;
  createNested?(parentId: string | number, nestedPath: string, data: TRequest): Promise<IApiResponse<any>>;
  updateNested?(parentId: string | number, nestedPath: string, id: string | number, data: Partial<TRequest>): Promise<IApiResponse<any>>;
  deleteNested?(parentId: string | number, nestedPath: string, id: string | number): Promise<IApiResponse<any>>;
  restoreNested?(parentId: string | number, nestedPath: string, id: string | number): Promise<IApiResponse<any>>;

  getByParams?(params: Record<string, any>, signal?: AbortSignal): Promise<IApiResponse<any>>;
  patch?(id: string | number, data: Partial<TRequest>): Promise<IApiResponse<any>>;
  getFile?(pathname: string): Promise<Blob>;
  exportTable(params?: Record<string, any>): Promise<Blob>;
}