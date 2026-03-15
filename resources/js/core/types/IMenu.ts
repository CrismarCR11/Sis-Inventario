export interface IMenu {
  header?: string;
  title?: string;
  icon?: any;
  to?: string;
  chip?: string;
  chipColor?: string;
  chipBgColor?: string;
  chipVariant?: string;
  chipIcon?: string;
  children?: IMenu[];
  disabled?: boolean;
  permissions?: string[];
  roles?: string[];
  type?: string;
  subCaption?: string;
  external?: boolean;
}