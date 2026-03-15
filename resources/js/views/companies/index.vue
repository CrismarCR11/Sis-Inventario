<template>
  <NavigationBreadcrumbs :customItems="breadcrumbs" />
  
  <v-container fluid>
    <DataTable
      :items="companies"
      :headers="headers"
      :loading="isLoading"
      :pagination="pagination"
      :show-edit="true"
      :show-delete="true"
      :show-restore="false"
      :initial-search="currentSearchQuery"
      @edit-item="editItem"
      @delete-item="confirmDelete"
      @update:options="handleTableOptionsChange"
      @search="handleSearch"
      @refresh="handleRefresh"
    >
      <template #header-actions>
        <v-btn color="primary" @click="createItem">
          <v-icon start>mdi-plus</v-icon>
          Nueva Empresa
        </v-btn>
      </template>

      <!-- Custom columns -->
      <template #item.ruc="{ item }">
        <span class="font-weight-medium text-mono">{{ item.ruc }}</span>
      </template>

      <template #item.razon_social="{ item }">
        <div>
          <div class="font-weight-bold text-primary">{{ item.razon_social }}</div>
          <div v-if="item.nombre_comercial" class="text-caption text-medium-emphasis">
            {{ item.nombre_comercial }}
          </div>
        </div>
      </template>

      <template #item.contacto="{ item }">
        <div v-if="item.email || item.telefono">
          <div v-if="item.email" class="d-flex align-center">
            <v-icon size="small" color="grey" class="mr-1">mdi-email-outline</v-icon>
            <span class="text-caption">{{ item.email }}</span>
          </div>
          <div v-if="item.telefono" class="d-flex align-center mt-1">
            <v-icon size="small" color="grey" class="mr-1">mdi-phone-outline</v-icon>
            <span class="text-caption">{{ item.telefono }}</span>
          </div>
        </div>
        <span v-else class="text-caption text-medium-emphasis italic">-</span>
      </template>

      <template #item.stats="{ item }">
        <div class="d-flex justify-center">
          <v-chip size="x-small" color="info" variant="tonal">
            <v-icon size="x-small" class="mr-1">mdi-store</v-icon>
            {{ item.locales_count || 0 }} locales
          </v-chip>
        </div>
      </template>

      <template #item.activo="{ item }">
        <v-chip
          :color="item.activo ? 'success' : 'error'"
          size="small"
          variant="flat"
        >
          {{ item.activo ? 'Activo' : 'Inactivo' }}
        </v-chip>
      </template>

      <template #item.created_at="{ item }">
        <span class="text-caption text-medium-emphasis">{{ formatDate(item.created_at) }}</span>
      </template>

      <template #item.actions="{ item }">
        <div class="d-flex gap-1">
          <ActionButton
            icon="mdi-eye-outline"
            color="info"
            tooltip="Ver detalles"
            @click="viewItem(item)"
          />
          <ActionButton
            icon="mdi-pencil-outline"
            color="primary"
            tooltip="Editar"
            @click="editItem(item)"
          />
          <ActionButton
            :icon="item.activo ? 'mdi-close-circle-outline' : 'mdi-check-circle-outline'"
            :color="item.activo ? 'warning' : 'success'"
            :tooltip="item.activo ? 'Desactivar' : 'Activar'"
            @click="toggleStatus(item)"
          />
          <ActionButton
            icon="mdi-trash-can-outline"
            color="error"
            tooltip="Eliminar"
            @click="confirmDelete(item)"
          />
        </div>
      </template>

      <template #modal>
        <CompanyForm
          :is-open="dialog"
          :item="selectedItem"
          :is-loading="isLoading"
          @save="handleSave"
          @cancel="handleCancel"
        />
      </template>
    </DataTable>

    <ConfirmDialog
      v-model="dialogDelete"
      title="¿Eliminar empresa?"
      message="Esta acción no se puede deshacer y eliminará permanentemente la empresa y todos sus datos asociados."
      confirm-button-text="Eliminar"
      confirm-button-color="error"
      @confirm="deleteItemConfirm"
    />

    <ConfirmDialog
      v-model="dialogRestore"
      title="¿Restaurar empresa?"
      message="La empresa volverá a estar activa."
      confirm-button-text="Restaurar"
      confirm-button-color="success"
      @confirm="restoreItemConfirm"
    />
  </v-container>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { storeToRefs } from 'pinia';
import { DataTable, ConfirmDialog, ActionButton } from '@/components/datatable';
import NavigationBreadcrumbs from '../../components/shared/NavigationBreadcrumbs.vue';
import CompanyForm from './Form.vue';
import { useCompanyStore } from '@/stores/companyStore';
import { useGenericTable } from '@/core/composable/datatable/useDataTable';
import { useCompanyDialogs } from './composables/useCompanyDialogs';
import type { Company } from '@/services/companyService';
import type { IPaginationRequest } from '@/core/types/IApi';
import { noty } from '@/core/utils/Noty';

const router = useRouter();
const companyStore = useCompanyStore();
const { companies, isLoading, pagination } = storeToRefs(companyStore);

const breadcrumbs = [
  { title: 'Dashboard', disabled: false, to: '/home' },
  { title: 'Empresas', disabled: true }
];

const headers = [
  { title: 'RUC', key: 'ruc', align: 'start', sortable: true },
  { title: 'Razón Social', key: 'razon_social', sortable: true },
  { title: 'Contacto', key: 'contacto', sortable: false },
  { title: 'Locales', key: 'stats', sortable: false, align: 'center' },
  { title: 'Estado', key: 'activo', align: 'center', sortable: true },
  { title: 'Registro', key: 'created_at', sortable: true },
  { title: 'Acciones', key: 'actions', sortable: false, align: 'center' }
];

const dialog = ref(false);
const selectedItem = ref<Company | null>(null);

const fetchData = (params: IPaginationRequest) => {
  companyStore.getAllPaginated(params);
};

// Table composable
const { 
  currentSearchQuery, 
  handleTableOptionsChange, 
  handleSearch, 
  handleRefresh 
} = useGenericTable(fetchData);

// Dialogs composable
const {
  dialogDelete,
  dialogRestore,
  confirmDelete,
  deleteItemConfirm,
  restoreItemConfirm,
  toggleStatus
} = useCompanyDialogs({
  onDelete: async (item: Company) => {
    await companyStore.deleteCompany(item.id);
    noty.success('Empresa eliminada correctamente');
    handleRefresh();
  },
  onStatusToggle: async () => {
    // No necesitamos hacer nada extra aquí ya que el store actualiza reactivamente el item
    // Pero si quisiéramos refrescar toda la lista:
    // handleRefresh();
  }
});

const createItem = () => {
  selectedItem.value = null;
  dialog.value = true;
};

const editItem = (item: Company) => {
  selectedItem.value = item;
  dialog.value = true;
};

const viewItem = (item: Company) => {
  router.push(`/companies/${item.id}`);
};

const handleSave = () => {
  dialog.value = false;
  selectedItem.value = null;
  handleRefresh();
};

const handleCancel = () => {
  dialog.value = false;
  selectedItem.value = null;
};

const formatDate = (date: string): string => {
  if (!date) return '-';
  return new Date(date).toLocaleDateString('es-PE', {
    year: 'numeric',
    month: 'short',
    day: '2-digit'
  });
};
</script>

<style scoped>
.gap-2 {
  gap: 0.5rem;
}
.gap-1 {
  gap: 0.25rem;
}
.text-mono {
  font-family: monospace;
}
.italic {
  font-style: italic;
}
</style>