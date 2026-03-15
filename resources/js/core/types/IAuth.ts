export interface IAuthRequest {
  email: string;
  password: string;
}

export interface IAuthResponse {
  data: {
    access_token: string;
    expires_at: string;
    user: IAuth;
  };
}
export interface IAuth {
  id: string;
  name: string;
  email: string;
  roles: string[];
  permissions: string[];
}

export interface IMeResponse {
  data: IAuth;
}

export interface IChangePasswordRequest {
  current_password: string;
  password: string;
  password_confirmation: string;
}