<template>
  <v-app>
    <!-- Sidebar -->
    <v-navigation-drawer v-model="drawer" app>
      <v-list>
        <!-- Logo -->
        <v-list-item class="px-4 py-5">
          <v-list-item-title class="text-h5 font-weight-bold text-primary">
            Sis-Inventario
          </v-list-item-title>
        </v-list-item>

        <v-divider></v-divider>

        <!-- Menu items -->
        <v-list-item
          v-for="item in menuItems"
          :key="item.title"
          :to="item.to"
          :prepend-icon="item.icon"
          :title="item.title"
          exact
        ></v-list-item>
      </v-list>
    </v-navigation-drawer>

    <!-- Header -->
    <v-app-bar app>
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
      
      <v-app-bar-title>Sistema de Inventario</v-app-bar-title>
      
      <v-spacer></v-spacer>

      <!-- Avatar y menu de usuario -->
      <v-menu offset-y>
        <template v-slot:activator="{ props }">
          <v-btn v-bind="props" variant="text" class="mr-2">
            <v-avatar color="primary" size="36">
              <span class="text-white text-subtitle-1 font-weight-bold">
                {{ getInitials(auth.user?.name || 'U') }}
              </span>
            </v-avatar>
            <span class="ml-2 d-none d-sm-inline">{{ auth.user?.name }}</span>
          </v-btn>
        </template>

        <v-list width="250">
          <v-list-item>
            <template v-slot:prepend>
              <v-avatar color="primary" size="40">
                <span class="text-white font-weight-bold">
                  {{ getInitials(auth.user?.name || 'U') }}
                </span>
              </v-avatar>
            </template>
            <v-list-item-title class="font-weight-bold">
              {{ auth.user?.name }}
            </v-list-item-title>
            <v-list-item-subtitle>
              {{ auth.user?.email }}
            </v-list-item-subtitle>
          </v-list-item>

          <v-divider class="my-2"></v-divider>

          <v-list-item
            prepend-icon="mdi-account"
            title="Mi Perfil"
            @click="showProfile = true"
          ></v-list-item>
          
          <v-list-item
            prepend-icon="mdi-cog"
            title="Configuración"
            to="/settings"
          ></v-list-item>
          
          <v-list-item
            prepend-icon="mdi-help-circle"
            title="Acerca de"
            @click="showAbout = true"
          ></v-list-item>

          <v-divider class="my-2"></v-divider>

          <v-list-item
            prepend-icon="mdi-logout"
            title="Cerrar Sesión"
            color="error"
            @click="logoutDialog = true"
          ></v-list-item>
        </v-list>
      </v-menu>
    </v-app-bar>

    <!-- Contenido Principal -->
    <v-main>
      <v-container fluid>
        <router-view></router-view>
      </v-container>
    </v-main>

    <!-- Dialogos -->
    <v-dialog v-model="logoutDialog" max-width="400">
      <v-card>
        <v-card-title class="text-h5">Cerrar Sesión</v-card-title>
        <v-card-text>¿Estás seguro que deseas cerrar sesión?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey-darken-1" variant="text" @click="logoutDialog = false">
            Cancelar
          </v-btn>
          <v-btn color="error" variant="text" @click="handleLogout" :loading="loading">
            Cerrar Sesión
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="showProfile" max-width="600">
      <v-card>
        <v-card-title class="bg-primary text-white">
          <span>Mi Perfil</span>
          <v-spacer></v-spacer>
          <v-btn icon dark variant="text" @click="showProfile = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text class="pt-6">
          <v-row>
            <v-col cols="12" md="4" class="text-center">
              <v-avatar color="primary" size="100">
                <span class="text-white text-h3 font-weight-bold">
                  {{ getInitials(auth.user?.name || 'U') }}
                </span>
              </v-avatar>
            </v-col>
            <v-col cols="12" md="8">
              <v-list>
                <v-list-item>
                  <template v-slot:prepend>
                    <v-icon color="primary">mdi-account</v-icon>
                  </template>
                  <v-list-item-title>Nombre Completo</v-list-item-title>
                  <v-list-item-subtitle>{{ auth.user?.name }}</v-list-item-subtitle>
                </v-list-item>
                <v-list-item>
                  <template v-slot:prepend>
                    <v-icon color="primary">mdi-email</v-icon>
                  </template>
                  <v-list-item-title>Correo Electrónico</v-list-item-title>
                  <v-list-item-subtitle>{{ auth.user?.email }}</v-list-item-subtitle>
                </v-list-item>
              </v-list>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-dialog>

    <v-dialog v-model="showAbout" max-width="500">
      <v-card>
        <v-card-title class="bg-primary text-white">
          <span>Acerca de</span>
          <v-spacer></v-spacer>
          <v-btn icon dark variant="text" @click="showAbout = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text class="pt-6 text-center">
          <v-icon size="60" color="primary" class="mb-4">mdi-package-variant</v-icon>
          <h2 class="text-h5 mb-2">Sis-Inventario v1.0.0</h2>
          <p class="text-body-1 text-medium-emphasis">
            Sistema de Gestión de Inventarios
          </p>
          <v-divider class="my-4"></v-divider>
          <p class="text-body-2 text-medium-emphasis">
            Desarrollado con Laravel 12 + Vue 3 + Vuetify
          </p>
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-app>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useAuthStore } from '@/stores/auth';
import { useRouter } from 'vue-router';

const auth = useAuthStore();
const router = useRouter();

const drawer = ref(true);
const loading = ref(false);
const logoutDialog = ref(false);
const showProfile = ref(false);
const showAbout = ref(false);

const menuItems = [
  { title: 'Dashboard', icon: 'mdi-view-dashboard', to: '/' },
  { title: 'Productos', icon: 'mdi-package-variant', to: '/productos' },
  { title: 'Categorías', icon: 'mdi-tag-multiple', to: '/categorias' },
  { title: 'Proveedores', icon: 'mdi-truck', to: '/proveedores' },
  { title: 'Movimientos', icon: 'mdi-transfer', to: '/movimientos' },
  { title: 'Reportes', icon: 'mdi-chart-bar', to: '/reportes' },
  { title: 'Configuración', icon: 'mdi-cog', to: '/configuracion' },
];

// Obtener iniciales
const getInitials = (name: string): string => {
  if (!name) return 'U';
  return name
    .split(' ')
    .map(word => word[0])
    .join('')
    .toUpperCase()
    .slice(0, 2);
};

// Logout
const handleLogout = async () => {
  loading.value = true;
  try {
    await auth.logout();
    router.push('/login');
  } finally {
    loading.value = false;
    logoutDialog.value = false;
  }
};
</script>

<style scoped>
.v-navigation-drawer {
  background: rgb(245, 245, 245) !important;
}

.v-list-item--active {
  background: rgba(var(--v-theme-primary), 0.1) !important;
  border-left: 4px solid rgb(var(--v-theme-primary));
}
</style>