import type { DataTableHeader } from "vuetify";

export interface ITableProps {
  store: any;
  headers: DataTableHeader[];
  itemValue?: string;
  searchPlaceholder?: string;
  initialSearch?: string;
  searchKey?: string;
  searchWidth?: string;
  headerClass?: string;
  showActions?: boolean;
  showEdit?: boolean;
  showDelete?: boolean;
  hideDeletedActions?: boolean;
  editButtonColor?: string;
  editButtonIcon?: string;
  deleteButtonColor?: string;
  deleteButtonIcon?: string;
}
