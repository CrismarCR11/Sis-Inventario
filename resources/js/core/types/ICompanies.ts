export interface ICompanyRequest {
  name: string;
  description: string;
};

export interface ICompany {
  id: string;
  name: string;
  description: string;
  created_id: string | null;
  created_at: string | null;
  deleted_id: string | null;
};
