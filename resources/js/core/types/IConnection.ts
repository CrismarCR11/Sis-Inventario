export interface IConnection {
  id: number;
  name_connection: string;
  db_driver: string;
  db_host: string;
  db_port: string;
  db_database: string;
  db_type: number;
  db_username: number;
  db_password: number;
  db_datei: string;
  db_datef: number;
  db_agecodigo: number;
  type: number;
}

export interface IConnectionRequest {
  id: number;
  name_connection: string;
  db_driver: string;
  db_host: string;
  db_port: string;
  db_database: string;
  db_type: number;
  db_username: number;
  db_password: number;
  db_datei: string;
  db_datef: number;
  db_agecodigo: number;
  type: number;
}

export interface ICreateConection {
  name_connection: string;
  db_driver: string;
  db_host: string;
  db_port: string;
  db_database: string;
  db_type: number;
  db_username: number;
  db_password: number;
  db_datei: string;
  db_datef: number;
  db_agecodigo: number;
  type: number;
}

export interface IUpdateConection {
  name_connection: string;
  db_driver: string;
  db_host: string;
  db_port: string;
  db_database: string;
  db_type: number;
  db_username: number;
  db_password: number;
  db_datei: string;
  db_datef: number;
  db_agecodigo: number;
  type: number;
}
