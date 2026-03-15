<template>
  <div :key="routeKey">
    <v-row class="mb-4" justify="space-between" align="center">
      <v-col cols="12" class="py-0 px-4">
        <h2 class="pa-0">{{ title }}</h2>
      </v-col>
      <v-col cols="12" sm="4" md="3">
        <v-text-field
          v-model="searchQuery"
          :placeholder="searchPlaceholder"
          :style="{ width: searchWidth }"
          class="search-field"
          clearable
          density="compact"
          hide-details
          prepend-inner-icon="mdi-magnify"
          single-line
          variant="solo-filled"
          flat
          v-motion-slide-visible-left
        />
      </v-col>

      <v-col cols="12" sm="8" md="9" class="d-flex justify-end">
        <div class="me-2 d-flex align-center">
          <span v-if="showSelect" class="text-caption me-2">
            {{ selectedItems.length }} seleccionados
          </span>

          <v-btn
            v-if="showMultipleAction"
            :color="multipleActionColor"
            variant="tonal"
            size="small"
            @click="handleMultipleAction"
            class="me-1"
          >
            <v-icon start small>{{ multipleActionIcon }}</v-icon>
            {{ multipleActionText }}
          </v-btn>
        </div>

        <v-tooltip text="Exportar" location="bottom">
          <template v-slot:activator="{ props }">
            <v-btn
              v-if="showExportExcel"
              color="primary"
              variant="flat"
              @click="exportList"
              class="me-2"
              v-motion-slide-visible-right
              icon
              v-bind="props"
            >
              <v-icon>mdi-file-excel</v-icon>
            </v-btn>
          </template>
        </v-tooltip>
        <v-btn
          v-if="$slots['header-actions']"
          color="primary"
          class="refresh-btn me-2"
          @click="refreshList"
          variant="flat"
          v-motion-slide-visible-right
        >
          <v-icon start>mdi-refresh</v-icon>
          Refrescar
        </v-btn>

        <slot name="header-actions" />
      </v-col>
    </v-row>

    <v-card
      elevation="2"
      class="custom-table-card"
      :class="{ 'hide-scroll': displayLoading, 'loading-card': displayLoading }"
      v-motion
      :initial="{ opacity: 0, y: 50 }"
      :enter="{
        opacity: 1,
        y: 0,
        transition: { duration: 500, easing: 'easeOutQuad' },
      }"
    >
      <v-data-table-server
        v-model="selectedItems"
        striped="even"
        :show-select="showSelect"
        :headers="headers"
        :header-props="{
          class: 'bg-primary text-white table-header',
          style: { 'background-color': 'rgb(var(--v-theme-primary))', 'color': 'white' }
        }"
        :items="items"
        :items-length="pagination?.total ?? 0"
        :loading="displayLoading"
        :page="pagination?.current_page ?? 1"
        :item-value="itemValue"
        :items-per-page-options="customItemsPerPageOptions"
        :items-per-page="pagination?.per_page ?? 15"
        @update:options="handleOptionsChange" 
      >
        <template v-for="(_, slot) in $slots" #[slot]="scope">
          <slot :name="slot" v-bind="scope" />
        </template>
        <template v-slot:loading>
          <div
            class="custom-loader"
            v-motion
            :initial="{ opacity: 0, y: -20 }"
            :enter="{
              opacity: 1,
              y: 0,
              transition: { duration: 400, ease: 'easeOutQuad' },
            }"
          >
            <div class="logo-loader">
              <img :src="logoImg" alt="Logo de la aplicación" />
            </div>
            <p class="loading-text">Cargando datos...</p>
          </div>
        </template>

        <template v-slot:item.actions="{ item }">
          <div v-if="showActions" class="table-actions">
            <slot name="custom-actions" :item="item" />

            <template v-if="showRestore && item.deleted_id">
              <ActionButton
                tooltip="Restaurar"
                :icon="restoreButtonIcon"
                :color="restoreButtonColor"
                :on-click="() => handleRestore(item)"
              />
            </template>

            <template v-else>
              <ActionButton
                v-if="showEdit"
                tooltip="Editar"
                :icon="editButtonIcon"
                :color="editButtonColor"
                :on-click="() => handleEdit(item)"
              />

              <ActionButton
                v-if="showDelete && !item.deleted_at"
                tooltip="Eliminar"
                :icon="deleteButtonIcon"
                :color="deleteButtonColor"
                :on-click="() => handleDelete(item)"
              />
            </template>
          </div>
        </template>
      </v-data-table-server>

      <slot name="modal" :item="selectedItem" :refresh="refreshList" />
    </v-card>

    <v-alert v-if="error" type="error" class="mt-4" closable>
      {{ error }}
    </v-alert>
  </div>
</template>

<script setup lang="ts">
import { ref, watch, computed } from "vue";
import { useRoute } from "vue-router";
import type { IPagination } from "@/core/types/IApi";
import logoImg from "@/assets/images/favi.png";
import ActionButton from "./ActionButton.vue";

const customItemsPerPageOptions = [10, 25, 50, 100];

type Header = {
  title: string;
  key: string;
  [key: string]: any;
};

interface ITableProps {
  items: any[];
  headers: Header[];
  loading: boolean;
  pagination: IPagination | null;
  itemValue?: string;
  searchPlaceholder?: string;
  initialSearch?: string;
  searchWidth?: string;
  headerClass?: string;
  showActions?: boolean;
  showEdit?: boolean;
  showDelete?: boolean;
  showRestore?: boolean;
  showExportExcel?: boolean;
  hideDeletedActions?: boolean;
  editButtonColor?: string;
  editButtonIcon?: string;
  deleteButtonColor?: string;
  deleteButtonIcon?: string;
  restoreButtonColor?: string;
  restoreButtonIcon?: string;
  error?: string;
  showSelect?: boolean;
  initialSelectedItems?: any[];
  showMultipleAction?: boolean;
  multipleActionText?: string;
  multipleActionColor?: string;
  multipleActionIcon?: string;
  title?: string;
}

const props = withDefaults(defineProps<ITableProps>(), {
  itemValue: "id",
  searchPlaceholder: "Buscar...",
  initialSearch: "",
  searchWidth: "250px",
  headerClass: "bg-primary text-white",
  showActions: true,
  showEdit: true,
  showDelete: true,
  showRestore: false,
  showExportExcel: false,
  hideDeletedActions: false,
  editButtonColor: "primary",
  editButtonIcon: "mdi-pencil",
  deleteButtonColor: "error",
  deleteButtonIcon: "mdi-delete",
  restoreButtonColor: "primary",
  restoreButtonIcon: "mdi-undo",
  error: "",
  showSelect: false,
  initialSelectedItems: () => [],
  showMultipleAction: false,
  multipleActionText: "Aplicar Acción",
  multipleActionColor: "info",
  multipleActionIcon: "mdi-check-all",
});

const emit = defineEmits([
  "edit-item",
  "delete-item",
  "restore-item",
  "export-excel",
  "search",
  "refresh",
  "update:options",
  "multiple-action",
  "update:selected-items",
]);

const route = useRoute();
const routeKey = ref(0);
const searchQuery = ref(props.initialSearch);
const selectedItem = ref<any>(null);
const selectedItems = ref<any[]>(props.initialSelectedItems ?? []);
const isInitialLoading = ref(true);

let searchTimeout: ReturnType<typeof setTimeout>;

const displayLoading = computed(() => {
  return props.loading || isInitialLoading.value;
});

watch(
  () => route.fullPath,
  () => {
    routeKey.value += 1;
  }
);

watch(
  () => props.items,
  (newVal) => {
    if (newVal) {
      isInitialLoading.value = false;
    }
  }
);

watch(
  () => props.initialSelectedItems,
  (newVal) => {
    selectedItems.value = newVal ?? [];
  },
  { deep: true, immediate: true }
);

watch(searchQuery, (newVal) => {
  clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => {
    emit("search", newVal);
  }, 300);
});

watch(
  () => props.initialSearch,
  (newVal) => {
    searchQuery.value = newVal;
  }
);

watch(selectedItems, (newVal) => {
  emit("update:selected-items", newVal);
});

const handleOptionsChange = (options: any) => {
  emit("update:options", options);
};

const handleEdit = (item: any) => {
  selectedItem.value = item;
  emit("edit-item", item);
};

const handleDelete = (item: any) => {
  selectedItem.value = item;
  emit("delete-item", item);
};

const handleRestore = (item: any) => {
  selectedItem.value = item;
  emit("restore-item", item);
};

const handleMultipleAction = () => {
  if (selectedItems.value.length > 0) {
    emit("multiple-action", selectedItems.value);
  }
};

const refreshList = () => {
  selectedItems.value = [];
  emit("refresh");
};

const exportList = () => {
  emit("export-excel");
};
</script>
