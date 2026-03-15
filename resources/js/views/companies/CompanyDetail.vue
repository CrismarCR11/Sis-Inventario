<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-btn variant="text" prepend-icon="mdi-arrow-left" @click="goBack" class="mb-4">
          Volver a Empresas
        </v-btn>
      </v-col>
    </v-row>

    <v-row v-if="store.loading">
      <v-col cols="12" class="text-center">
        <v-progress-circular indeterminate color="primary" size="60"></v-progress-circular>
      </v-col>
    </v-row>

    <v-row v-else-if="store.currentCompany">
      <v-col cols="12" md="4">
        <v-card>
          <v-card-text class="text-center">
            <v-avatar color="primary" size="120" class="mb-4">
              <span class="text-white text-h2">
                {{ getInitials(store.currentCompany.razon_social) }}
              </span>
            </v-avatar>
            
            <h2 class="text-h5 mb-1">{{ store.currentCompany.razon_social }}</h2>
            <p class="text-medium-emphasis mb-2">RUC: {{ store.currentCompany.ruc }}</p>
            
            <v-chip :color="store.currentCompany.activo ? 'success' : 'error'" class="mb-4">
              {{ store.currentCompany.activo ? 'Activo' : 'Inactivo' }}
            </v-chip>

            <v-divider class="my-4"></v-divider>

            <div class="d-flex justify-space-around">
              <v-btn icon color="info" @click="editCompany">
                <v-icon>mdi-pencil</v-icon>
                <v-tooltip activator="parent">Editar</v-tooltip>
              </v-btn>
              <v-btn icon color="error" @click="confirmDelete">
                <v-icon>mdi-delete</v-icon>
                <v-tooltip activator="parent">Eliminar</v-tooltip>
              </v-btn>
              <v-btn icon :color="store.currentCompany.activo ? 'warning' : 'success'" @click="toggleStatus">
                <v-icon>{{ store.currentCompany.activo ? 'mdi-close-circle' : 'mdi-check-circle' }}</v-icon>
                <v-tooltip activator="parent">
                  {{ store.currentCompany.activo ? 'Desactivar' : 'Activar' }}
                </v-tooltip>
              </v-btn>
            </div>
          </v-card-text>
        </v-card>

        <!-- Estadísticas rápidas -->
        <v-card class="mt-4">
          <v-card-title class="text-subtitle-1 font-weight-bold">
            Estadísticas
          </v-card-title>
          <v-card-text>
            <v-list>
              <v-list-item>
                <template v-slot:prepend>
                  <v-icon color="primary">mdi-store</v-icon>
                </template>
                <v-list-item-title>Locales</v-list-item-title>
                <v-list-item-subtitle>{{ store.currentCompany.locales_count || 0 }}</v-list-item-subtitle>
              </v-list-item>
              <!-- <v-list-item>
                <template v-slot:prepend>
                  <v-icon color="primary">mdi-package-variant</v-icon>
                </template>
                <v-list-item-title>Productos</v-list-item-title>
                <v-list-item-subtitle>{{ store.currentCompany.productos_count || 0 }}</v-list-item-subtitle>
              </v-list-item> -->
              <v-list-item>
                <template v-slot:prepend>
                  <v-icon color="primary">mdi-calendar</v-icon>
                </template>
                <v-list-item-title>Creada</v-list-item-title>
                <v-list-item-subtitle>{{ formatDate(store.currentCompany.created_at) }}</v-list-item-subtitle>
              </v-list-item>
            </v-list>
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" md="8">
        <v-card>
          <v-card-title class="text-h5">Información Detallada</v-card-title>
          <v-card-text>
            <v-table>
              <tbody>
                <tr>
                  <th class="text-left" width="200">RUC:</th>
                  <td>{{ store.currentCompany.ruc }}</td>
                </tr>
                <tr>
                  <th class="text-left">Razón Social:</th>
                  <td>{{ store.currentCompany.razon_social }}</td>
                </tr>
                <tr v-if="store.currentCompany.nombre_comercial">
                  <th class="text-left">Nombre Comercial:</th>
                  <td>{{ store.currentCompany.nombre_comercial }}</td>
                </tr>
                <tr>
                  <th class="text-left">Email:</th>
                  <td>
                    <a :href="`mailto:${store.currentCompany.email}`">{{ store.currentCompany.email || '-' }}</a>
                  </td>
                </tr>
                <tr>
                  <th class="text-left">Teléfono:</th>
                  <td>
                    <a :href="`tel:${store.currentCompany.telefono}`">{{ store.currentCompany.telefono || '-' }}</a>
                  </td>
                </tr>
                <tr>
                  <th class="text-left">Dirección:</th>
                  <td>{{ store.currentCompany.direccion || '-' }}</td>
                </tr>
              </tbody>
            </v-table>

            <v-divider class="my-4"></v-divider>

            <h3 class="text-h6 mb-3">Configuración</h3>
            <v-table v-if="store.currentCompany.configuracion">
              <tbody>
                <tr>
                  <th class="text-left" width="200">Moneda:</th>
                  <td>{{ store.currentCompany.configuracion.moneda || 'PEN' }}</td>
                </tr>
                <tr>
                  <th class="text-left">País:</th>
                  <td>{{ store.currentCompany.configuracion.pais || 'Perú' }}</td>
                </tr>
                <tr>
                  <th class="text-left">Zona Horaria:</th>
                  <td>{{ store.currentCompany.configuracion.zona_horaria || 'America/Lima' }}</td>
                </tr>
              </tbody>
            </v-table>
            <p v-else class="text-medium-emphasis">Sin configuración adicional</p>
          </v-card-text>
        </v-card>

        <!-- Locales de la empresa -->
        <v-card class="mt-4">
          <v-card-title class="d-flex justify-space-between align-center">
            <span class="text-h6">Locales</span>
            <v-btn color="primary" size="small" @click="goToCreateLocal">
              <v-icon left>mdi-plus</v-icon>
              Nuevo Local
            </v-btn>
          </v-card-title>
          <v-card-text>
            <v-list>
              <v-list-item v-for="i in 3" :key="i">
                <template v-slot:prepend>
                  <v-icon color="primary">mdi-store</v-icon>
                </template>
                <v-list-item-title>Local {{ i }}</v-list-item-title>
                <v-list-item-subtitle>Dirección de ejemplo</v-list-item-subtitle>
                <template v-slot:append>
                  <v-btn icon size="small" color="info">
                    <v-icon>mdi-eye</v-icon>
                  </v-btn>
                </template>
              </v-list-item>
            </v-list>
            <p v-if="!store.currentCompany.locales_count" class="text-medium-emphasis text-center py-4">
              No hay locales registrados
            </p>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- Edit Dialog (Reutilizamos el mismo) -->
    <v-dialog v-model="editDialog" max-width="600">
      <v-card>
        <v-card-title class="text-h5">Editar Empresa</v-card-title>
        <v-card-text>
          <v-form ref="form" v-model="valid">
            <v-text-field
              v-model="formData.ruc"
              label="RUC *"
              :rules="[v => !!v || 'RUC es requerido', v => /^[0-9]{11}$/.test(v) || 'RUC debe tener 11 dígitos']"
              required
            ></v-text-field>

            <v-text-field
              v-model="formData.razon_social"
              label="Razón Social *"
              :rules="[v => !!v || 'Razón social es requerida']"
              required
            ></v-text-field>

            <v-text-field
              v-model="formData.nombre_comercial"
              label="Nombre Comercial"
            ></v-text-field>

            <v-text-field
              v-model="formData.email"
              label="Email"
              type="email"
            ></v-text-field>

            <v-text-field
              v-model="formData.telefono"
              label="Teléfono"
            ></v-text-field>

            <v-textarea
              v-model="formData.direccion"
              label="Dirección"
              rows="2"
            ></v-textarea>
          </v-form>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey-darken-1" variant="text" @click="editDialog = false">
            Cancelar
          </v-btn>
          <v-btn
            color="primary"
            :loading="store.loading"
            @click="updateCompany"
          >
            Actualizar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Delete Confirmation Dialog -->
    <v-dialog v-model="deleteDialog" max-width="400">
      <v-card>
        <v-card-title class="text-h5">¿Eliminar Empresa?</v-card-title>
        <v-card-text>
          ¿Estás seguro que deseas eliminar la empresa "{{ store.currentCompany?.razon_social }}"? 
          Esta acción no se puede deshacer y eliminará todos los datos asociados.
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey-darken-1" variant="text" @click="deleteDialog = false">
            Cancelar
          </v-btn>
          <v-btn
            color="error"
            :loading="store.loading"
            @click="deleteCompany"
          >
            Eliminar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useCompanyStore } from '@/stores/companyStore';

const route = useRoute();
const router = useRouter();
const store = useCompanyStore();

const editDialog = ref(false);
const deleteDialog = ref(false);
const valid = ref(false);
const form = ref();

const formData = ref({
    ruc: '',
    razon_social: '',
    nombre_comercial: '',
    email: '',
    telefono: '',
    direccion: ''
});

onMounted(async () => {
    const id = route.params.id as string;
    if (id) {
        await store.fetchCompany(id);
        if (store.currentCompany) {
            formData.value = {
                ruc: store.currentCompany.ruc,
                razon_social: store.currentCompany.razon_social,
                nombre_comercial: store.currentCompany.nombre_comercial || '',
                email: store.currentCompany.email || '',
                telefono: store.currentCompany.telefono || '',
                direccion: store.currentCompany.direccion || ''
            };
        }
    }
});

const getInitials = (name: string): string => {
    if (!name) return 'EM';
    return name
        .split(' ')
        .map(word => word[0])
        .join('')
        .toUpperCase()
        .slice(0, 2);
};

const formatDate = (date: string): string => {
    if (!date) return '-';
    return new Date(date).toLocaleDateString('es-PE', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};

const goBack = () => {
    router.push('/companies');
};

const editCompany = () => {
    editDialog.value = true;
};

const updateCompany = async () => {
    const { valid: isValid } = await form.value.validate();
    if (!isValid) return;

    try {
        await store.updateCompany(route.params.id as string, formData.value);
        editDialog.value = false;
        // Recargar datos actualizados
        await store.fetchCompany(route.params.id as string);
    } catch (error) {
        // Error ya manejado por el store
    }
};

const confirmDelete = () => {
    deleteDialog.value = true;
};

const deleteCompany = async () => {
    try {
        await store.deleteCompany(route.params.id as string);
        deleteDialog.value = false;
        router.push('/companies');
    } catch (error) {
        // Error ya manejado por el store
    }
};

const toggleStatus = async () => {
    try {
        await store.toggleCompanyStatus(route.params.id as string);
        await store.fetchCompany(route.params.id as string);
    } catch (error) {
        // Error ya manejado por el store
    }
};

const goToCreateLocal = () => {
    router.push(`/locales/create?company_id=${route.params.id}`);
};
</script>