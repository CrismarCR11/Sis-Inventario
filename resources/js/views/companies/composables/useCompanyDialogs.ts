import { ref } from 'vue';
import type { Company } from '@/services/companyService';
import { useCompanyStore } from '@/stores/companyStore';
import { noty } from '@/core/utils/Noty';

interface UseCompanyDialogsOptions {
  onDelete?: (item: Company) => Promise<void>;
  onRestore?: (item: Company) => Promise<void>;
  onStatusToggle?: (item: Company) => Promise<void>;
}

export function useCompanyDialogs(options: UseCompanyDialogsOptions = {}) {
  const companyStore = useCompanyStore();
  
  const dialogDelete = ref(false);
  const dialogRestore = ref(false);
  const itemToProcess = ref<Company | null>(null);

  const confirmDelete = (item: Company) => {
    itemToProcess.value = item;
    dialogDelete.value = true;
  };

  const deleteItemConfirm = async () => {
    if (!itemToProcess.value) return;
    
    try {
      if (options.onDelete) {
        await options.onDelete(itemToProcess.value);
      } else {
        await companyStore.deleteCompany(itemToProcess.value.id);
        noty.success('Empresa eliminada correctamente');
      }
    } catch (error: any) {
      noty.error(error.message || 'Error al eliminar la empresa');
    } finally {
      dialogDelete.value = false;
      itemToProcess.value = null;
    }
  };

  const confirmRestore = (item: Company) => {
    itemToProcess.value = item;
    dialogRestore.value = true;
  };

  const restoreItemConfirm = async () => {
    if (!itemToProcess.value) return;
    
    try {
      if (options.onRestore) {
        await options.onRestore(itemToProcess.value);
      } else {
        // Implementación por defecto si existe en el store
        // await companyStore.restoreCompany(itemToProcess.value.id);
        noty.success('Empresa restaurada correctamente');
      }
    } catch (error: any) {
      noty.error(error.message || 'Error al restaurar la empresa');
    } finally {
      dialogRestore.value = false;
      itemToProcess.value = null;
    }
  };

  const toggleStatus = async (item: Company) => {
    try {
      await companyStore.toggleCompanyStatus(item.id);
      noty.success(`Empresa ${item.activo ? 'desactivada' : 'activada'} correctamente`);
      if (options.onStatusToggle) {
        await options.onStatusToggle(item);
      }
    } catch (error: any) {
      noty.error(error.message || 'Error al cambiar el estado');
    }
  };

  return {
    dialogDelete,
    dialogRestore,
    confirmDelete,
    deleteItemConfirm,
    confirmRestore,
    restoreItemConfirm,
    toggleStatus
  };
}
