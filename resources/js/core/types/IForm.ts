export interface IFormInput {
  name: string;
  label?: string;
  type?: string;
  placeholder?: string;
  disabled?: boolean;
  loading?: boolean;
  autocomplete?: string;
  icon?: string;
  variant?: string;
  step?: string;
  min?: string;
}

export interface IFormProviderProps {
  isOpen: boolean;
  item: any | null;
  formTitle: string;
  schema: any;
  loading?: boolean;
}

export interface IFormWrapperProps {
  title?: string;
  loading?: boolean;
  error?: string | null;
}